<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vacations;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckActive');
        $this->middleware('CheckAdmin');
        $this->miesiace=['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    }

    public function calendar($month=null, $year=null)
    {
        if($month==null)
            $month = date('m');
        if($year==null)
            $year = date('Y');
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);
        
        $vacations = vacations::where('start', 'like', '%'.$year."-".$month.'%')->orWhere('end', 'like', '%'.$year."-".$month.'%')->OrderBy('start')->get();
        return view('calendar.calendar')->with('month', $month)->with('year', $year)->with('vacations', $vacations)->with('miesiace', $this->miesiace);
    }
}