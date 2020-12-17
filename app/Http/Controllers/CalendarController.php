<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vacations;
use App\user;
use Auth;
use Gate;
use Carbon;

class CalendarController extends Controller
{
    // konstruktor
    public function __construct()
    {
        $this->miesiace=['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    }

    // vacation_check
    public function vacation_check($start, $end, $userid, $vacationid = null)
    {
        $vacations = Vacations::where('end', '>=', $start)->where('start', '<=', $end)->where('id', '!=', $vacationid)->get();
        if($vacations->where('user_id', '=', $userid)->where('confirmed', '>=', 0)->count() > 0)
            return 'double';
        elseif($vacations->where('confirmed', 1)->count() > 0)
            return 'vacation';
        elseif($vacations->where('confirmed', 0)->count() > 0)
            return 'proposal';

        return false;
    }


    // calendar
    public function calendar($month=null, $year=null)
    {
        session(['url' => null]);
        if($month==null)
            $month = date('m');
        if($year==null)
            $year = date('Y');
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);
        
        $users = user::all();
        $curr_usr = Auth::user()->id;
        $vacations = vacations::where('start', 'like', '%'.$year."-".$month.'%')->orWhere('end', 'like', '%'.$year."-".$month.'%')->OrderBy('start')->get();
        return view('calendar.vacations.vacations')->with('month', $month)->with('year', $year)->with('vacations', $vacations)->with('miesiace', $this->miesiace)->with('users', $users)->with('curr_usr', $curr_usr);
    }


    // add
    public function add()
    {
        $users = user::whereActive(1)->get();
        return view('calendar.vacations.add')->with('users', $users);
    }



    // add_store
    public function add_store(Request $request)
    {
        if(!isset($request->double))
        {
            if($request->user == 0)
                $userid = Auth::user()->id;
            else
                $userid = $request->user;
            $double = $this->vacation_check($request->start, $request->end, $userid);
            if($double != false)
                return redirect()->back()->withInput()->with('double', $double);
        }

        try
        {
            $vacation = new vacations;
            $vacation->start = $request->start;
            $vacation->end = $request->end;
            if($request->user == 0)
                $vacation->user_id = Auth::user()->id;
            else
                $vacation->user_id = $request->user;
            $vacation->who_added = Auth::user()->id;
            $vacation->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }

        return redirect()->back()->with('success', 'Wysłano wniosek');
    }


    // requests
    public function requests()
    {
        session(['url' => null]);
        $curr_usr = Auth::user()->id;
        if(!Gate::allows('admin'))
            $requests = vacations::where('user_id', $curr_usr)->orderBy('created_at', 'desc')->paginate(15);
        else
            $requests = vacations::orderBy('created_at', 'desc')->paginate(15);
        $users = user::all();
        return view('calendar.requests.requests')->withRequests($requests)->withUsers($users)->with('curr_usr', $curr_usr);
    }


    // request
    public function request($id)
    {
        $request = vacations::findOrFail($id);
        if($request->user_id != Auth::user()->id && !Gate::allows('admin'))
            return redirect()->back()->withFailed('Nie masz dostępu do tego zasobu');
        $users = user::all();
        return view('calendar.requests.request')->withRequest($request)->withUsers($users);
    }


    // request_store
    public function request_store(Request $request, $id)
    {
        try
        {
            session(['url' => $request->url]);

            $vacation = vacations::findOrFail($id);
            if(!$request->has('status') && $request->start == $vacation->start && $request->end == $vacation->end)
                return redirect()->back();
            else
            {
                if($request->user_id != Auth::user()->id && !Gate::allows('admin'))
                    return redirect()->back()->withFailed('Nie masz dostępu do tego zasobu');
                if($request->start != $vacation->start || $request->end != $vacation->end)
                {
                    $double = false;
                    if(!isset($request->double))
                        $double = $this->vacation_check($request->start, $request->end, $vacation->user_id, $id);
                        
                    if($double === 'vacation')
                        return redirect()->back()->withFailed('W tym okresie istnieje już urlop, popraw swój wniosek');
                    elseif($double === 'double')
                        return redirect()->back()->withFailed('W tym okresie masz już złożony wniosek o urlop, popraw swój wniosek');
                    elseif($double === 'proposal')
                        return redirect()->back()->withInput()->withDouble('proposal');
                    else
                    {
                        $vacation->start = $request->start;
                        $vacation->end = $request->end;
                        $msg = 'Zmieniono datę urlopu';
                    }
                }
                elseif($request->has('status'))
                {
                    if($request->status === "deny")
                        $vacation->confirmed = -1;
                    elseif($request->status === "allow")
                    {
                        $vacation->confirmed = 1;
                        $similar = vacations::where('start', '<=', $vacation->end)->where('end', '>=', $vacation->start)->where('id', '!=', $id)->get();
                        foreach($similar as $row)
                        {
                            $row->confirmed = -1;
                            $row->who_conf = Auth::user()->id;
                            $row->save();
                        }
                    }
                    $vacation->who_conf = Auth::user()->id;
                    $msg = 'Zmieniono status urlopu';
                }
                $vacation->save();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd!');
        }
        return redirect()->back()->withSuccess($msg);
    }



    // search
    public function request_search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');

            $requests = vacations::join('users', 'users.id', '=', 'vacations.user_id')
                                    ->select('vacations.*', 'users.name as user')
                                    ->where('vacations.start', 'like', "%$query%")
                                    ->orWhere('vacations.end', 'like', "%$query%")
                                    ->orWhere('vacations.created_at', 'like', "%$query%")
                                    ->orWhere('vacations.updated_at', 'like', "%$query%")
                                    ->orWhere('users.name', 'like', "%$query%")
                                    ->OrderBy('vacations.created_at', 'desc')
                                    ->get();

            if(!Gate::allows('admin'))
                $requests = $requests->where('user_id', Auth::user()->id);

            if($requests->count() > 0)
            {
                foreach($requests as $key => $request)
                {
                    $output .= "
                        <tr class='table-row table-row__hover' onclick='table_row_href(".$request->id.")'>
                            <td class=align-middle>".($key+1)."</td>
                            <td class=align-middle>$request->user</td>
                            <td class=align-middle>$request->start</td>
                            <td class=align-middle>$request->end</td>
                            <td class=align-middle>".Carbon\Carbon::parse($request->created_at)->diffForHumans()."</td>";

                    if($request->confirmed == -1)
                        $output .= "<td style='background-color: red; color: white;'>odrzucony</td>";
                    elseif($request->confirmed == 0)
                        $output .= "<td style='background-color: #209DFC; color: white;'>do rozpatrzenia</td>";
                    else
                        $output .= "<td style='background-color: #00DC60; color: white;'>przyjęty</td>";
                    $output .= "</tr>";
                }
            }
            else
            {
                $output = '
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="align-middle">Nie znaleziono</td>
                        <td></td>
                        <td></td>
                    </tr>
                ';
            }
            $data = array('table_data' => $output);
            echo json_encode($data);
        }
    }
}