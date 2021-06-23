<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\vacations;
use App\scheduler;
use App\User;
use Auth;

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
                $tab[$i][2] = $this->getVacationTime($user->id, date('Y'));
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
                    $vacation = $this->getVacationTime($user->id, date('Y'));
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


    public function summary_user()
    {
        try
        {
            $user_id = Auth::id();

            $job_time = $this->getJobTime($user_id, date('Y'), date('m'));

            $vacation_time = $this->getVacationTime($user_id, date('Y'));

            return view('summary.summary_user')->withJob($job_time)->withVacation($vacation_time);
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(\Illuminate\Database\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }



    public function summary($id, $job = null, $vacation = null)
    {
        try
        {
            $user = User::findOrFail($id);

            if($job==null)
                $job = date('Y-m');

            if($vacation==null)
                $vacation = date('Y');

            $job_time = $this->getJobTime($user->id, date('Y', strtotime($job)), date('m', strtotime($job)));
            $vacation_time = $this->getVacationTime($user->id, $vacation);

            $jobs = scheduler::select('date')->whereUser_id($user->id)->where('date', '<=', date('Y-m-d'))->distinct('date')->orderBy('date')->get();
            $job_years = [];
            foreach($jobs as $row)
                if(date('Y', strtotime($row->date)) != end($job_years))
                    array_push($job_years, date('Y', strtotime($row->date)));

            $vacation_min = vacations::select('start')->whereUser_id($user->id)->min('start');
            $vacation_max = vacations::select('end')->whereUser_id($user->id)->max('end');
            $vacation_years = [];
            for($i=date('Y', strtotime($vacation_min)); $i <= date('Y', strtotime($vacation_max)); $i++)
                array_push($vacation_years, $i);

            return view('summary.summary')->withUser($user)->withJobTime($job_time)->withVacationTime($vacation_time)->withJob($job)->withVacation($vacation)->withVacationYears($vacation_years)->withJobYears($job_years);
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
            $schedulers = scheduler::whereUser_id($id)->where('date', 'like', $date.'%')->where('date', '<=', date('Y-m-d'))->get();
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


    private function getVacationTime($id, $year)
    {
        try
        {
            $vacations = vacations::whereUser_id($id)
                                    ->whereConfirmed(1)
                                    ->where('start', 'like', $year.'%')
                                    ->orWhere(function($query) use ($id, $year){
                                        $query->whereUser_id($id)
                                            ->whereConfirmed(1)
                                            ->where('end', 'like', $year.'%');
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
        }
        catch(\Illuminate\Database\QueryException $ex){
            return false;
        }catch(\Illuminate\Database\Exception $ex){
            return false;
        }
    }
}
