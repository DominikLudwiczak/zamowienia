<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\vacations;
use App\scheduler;
use App\holidays;
use App\User;
use Auth;
use Gate;

class SummaryController extends Controller
{
    public function summaries()
    {
        try
        {
            $users = User::all();
            $tab = array();
            $i = 0;
            foreach($users as $user)
            {
                $tab[$i][0] = $user->name;
                $tab[$i][1] = $this->getJobTime($user->id, date('Y'), date('m'));
                $tab[$i][2] = $this->getVacationTime($user->id, date('Y'), date('m'));
                $tab[$i][3] = $user->id;
                $i++;
            }
            return view('summary.summaries')->withUsers($tab);
        }catch(\Illuminate\Database\QueryException $ex){
            return $ex;
            return redirect()->back()->withFailed('Wystąpił błąd');    
        }catch(\Illuminate\Database\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');    
        }
    }



    public function summaries_search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != '')
                $users = User::where('name', 'like', '%'.$query.'%')->orderBy('name')->get();
            
            if($users->count() > 0)
            {
                foreach($users as $user)
                {
                    $job = $this->getJobTime($user->id, date('Y'), date('m'));
                    $vacation = $this->getVacationTime($user->id, date('Y'), date('m'));
                    $output .= '
                        <tr>
                            <td class="align-middle">'.$user->name.'</td>
                            <td class="align-middle">'.floor($job/60).' godziny '.($job-floor($job/60)*60).' minut</td>
                            <td class="align-middle">'.$vacation.' dni</td>
                        </tr>
                    ';
                }
            }
            else
            {
                $output = '
                    <tr>
                        <td colspan="100%" class="align-middle">Nie znaleziono</td>
                    </tr>
                ';
            }
            $data = array('table_data' => $output);
            echo json_encode($data);
        }
    }



    public function summary($id = null, $time = null)
    {
        try
        {
            if(!$id)
                $id = Auth::id();

            if($id != Auth::id() && !Gate::allows('admin'))
                return redirect()->back()->withFailed('Nie masz dostępu do tego zasobu');

            $user = User::findOrFail($id);

            if($time==null)
                $time = date('Y-m');

            $job_time = $this->getJobTime($user->id, date('Y', strtotime($time)), date('m', strtotime($time)));
            $vacation_time = $this->getVacationTime($user->id, date('Y', strtotime($time)), date('m', strtotime($time)));

            $jobs = scheduler::select('date')->whereUser_id($user->id)->where('date', '<=', date('Y-m-d'))->distinct('date')->orderBy('date')->get();
            $time_years = [];
            if(count($jobs) > 0)
            {
                foreach($jobs as $row)
                    if(date('Y', strtotime($row->date)) != end($time_years))
                        array_push($time_years, date('Y', strtotime($row->date)));
            }
            else
                $time_years[0] =  date('Y');
            
            $vacation_min = vacations::select('start')->whereUser_id($user->id)->min('start');
            $vacation_max = vacations::select('end')->whereUser_id($user->id)->max('end');

            if($vacation_min)
                for($i=date('Y', strtotime($vacation_min)); $i <= date('Y', strtotime($vacation_max)); $i++)
                    if(!in_array($i, $time_years))
                        array_push($time_years, $i);
            else if(!in_array(date('Y'), $time_years))
                $vacation_years[0] = date('Y');

            $workingHours = $this->getWorkingDays(date('Y', strtotime($time)), date('m', strtotime($time)))*8;

            if($job_time > $workingHours*60)
            {
                $salary_base = $workingHours * $user->base_sallary;
                $pom = $job_time-($workingHours*60);
                $salary_extended = (floor($pom/60) * $user->extended_sallary) + ((($pom - (floor($pom/60)*60))/60)*$user->extended_sallary);
            }
            else
            {
                $salary_base = (floor($job_time/60) * $user->base_sallary) + ((($job_time - (floor($job_time/60)*60))/60)*$user->base_sallary);
                $salary_extended = 0;
            }
            return view('summary.summary')->withUser($user)->withJobTime($job_time)->withVacationTime($vacation_time)->withTime($time)->withTimeYears($time_years)->withWorkingHours($workingHours)->withBaseSalary($salary_base)->withExtendedSalary($salary_extended);
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(\Illuminate\Database\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }


    private function getJobTime($id, $year, $month)
    {
        try
        {
            $date = "$year-$month";
            $schedulers = scheduler::whereUser_id($id)->where('date', 'like', $date.'-%')->where('date', '<=', date('Y-m-d'))->get();
            $job_time = 0;
            foreach($schedulers as $job)
                $job_time += (strtotime($job->end) - strtotime($job->start))/60;
            return $job_time;
        }catch(\Illuminate\Database\QueryException $ex){
            return false;
        }catch(\Illuminate\Database\Exception $ex){
            return false;
        }
    }


    private function getVacationTime($id, $year, $month)
    {
        try
        {
            $vacations = vacations::whereUser_id($id)
                                    ->whereConfirmed(1)
                                    ->where('start', 'like', $year.'-'.$month.'%')
                                    ->orWhere(function($query) use ($id, $year, $month){
                                        $query->whereUser_id($id)
                                            ->whereConfirmed(1)
                                            ->where('end', 'like', $year.'-'.$month.'%');
                                    })->get();
            $vacation_time = 0;
            foreach($vacations as $vacation)
            {
                if(date("Y", strtotime($vacation->end)) != $year)
                    $vacation->end = "$year-12-31";
                if(date("Y", strtotime($vacation->start)) != $year)
                    $vacation->start = "$year-01-01";
                $days = date_diff(date_create($vacation->start), date_create($vacation->end));
                $vacation_time += $days->format("%a")+1;
            }
            return $vacation_time;
        }catch(\Illuminate\Database\QueryException $ex){
            return false;
        }catch(\Illuminate\Database\Exception $ex){
            return false;
        }
    }

    private function getWorkingDays($year, $month)
    {
        try
        {
            $days = 0;
            for($i=0; $i < ceil((cal_days_in_month(CAL_GREGORIAN, $month, $year) + date('N', strtotime($year."-".$month."-1")))/7)*7; $i++)
            {
                $z = str_pad($i-(date('N', strtotime($year."-".$month."-1"))-1)+1, 2, 0, STR_PAD_LEFT);

                if($z > 0 && $z <= cal_days_in_month(CAL_GREGORIAN, $month, $year))
                {
                    $holiday = holidays::where('date', '=', $year.'-'.$month.'-'.$z)->first();
                    if($holiday)
                        continue;

                    if(date("N", strtotime($year."-".$month."-".$z)) == 7)
                        continue;

                    $days++;
                }
            }
            return $days;
        }catch(\Illuminate\Database\QueryException $ex){
            return false;
        }catch(\Illuminate\Database\Exception $ex){
            return false;
        }
    }
}
