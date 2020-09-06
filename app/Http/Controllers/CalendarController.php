<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckActive');
        $this->middleware('CheckAdmin');
    }

    public function calendar()
    {
        return view('calendar.calendar');
    }
}