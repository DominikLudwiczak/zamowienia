<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    // konstruktor
    public function __construct()
    {
        $this->middleware('CheckActive');
        $this->middleware('CheckAdmin');
        $this->miesiace=['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    }


    // scheduler
    public function scheduler($month=null, $year=null)
    {
        if($month==null)
            $month = date('m');
        if($year==null)
            $year = date('Y');
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);

        return view('calendar.scheduler.scheduler')->withMonth($month)->withYear($year)->withMiesiace($this->miesiace);
    }
}
