<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\shops;

class SchedulerController extends Controller
{
    // konstruktor
    public function __construct()
    {
        $this->middleware('CheckActive');
        $this->miesiace=['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    }


    // scheduler_user
    public function scheduler_user($month=null, $year=null)
    {
        if($month==null)
            $month = date('m');
        if($year==null)
            $year = date('Y');
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);

        return view('calendar.scheduler.scheduler_user')->withMonth($month)->withYear($year)->withMiesiace($this->miesiace);
    }

    // scheduler_admin
    public function scheduler_admin()
    {
        $shops = shops::all();
        return view('calendar.scheduler.scheduler_admin')->withShops($shops);
    }
}
