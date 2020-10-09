<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vacations;
use App\user;
use Auth;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckActive');
        $this->miesiace=['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    }

    public function calendar($month=null, $year=null)
    {
        if($month==null)
            $month = date('m');
        if($year==null)
            $year = date('Y');
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);
        
        $users = user::all();
        $vacations = vacations::where('start', 'like', '%'.$year."-".$month.'%')->orWhere('end', 'like', '%'.$year."-".$month.'%')->OrderBy('start')->get();
        return view('calendar.vacations.vacations')->with('month', $month)->with('year', $year)->with('vacations', $vacations)->with('miesiace', $this->miesiace)->with('users', $users);
    }



    public function add()
    {
        $users = user::all();
        return view('calendar.vacations.add')->with('users', $users);
    }




    public function add_store(Request $request)
    {
        if(!isset($request->double))
        {
            $vacations = vacations::where('end', '>=', $request->start)->where('start', '<=', $request->end)->get();
            if($vacations->where('confirmed', 1)->count() > 0)
                $double = 'vacation';
            else if($vacations->where('confirmed', 0)->count() > 0)
                $double = 'proposal';

            if(isset($double))
                return redirect()->back()->withInput()->with('double', $double);
        }

        $vacation = new vacations;
        $vacation->start = $request->start;
        $vacation->end = $request->end;
        if($request->user == 0)
            $vacation->user_id = Auth::user()->id;
        else
            $vacation->user_id = $request->user;
        $vacation->who_added = Auth::user()->id;
        $vacation->save();

        return redirect()->back()->with('success', 'Wysłano wniosek!');
    }
}