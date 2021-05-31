<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\vacations;
use App\scheduler;
use Auth;

class SummaryController extends Controller
{
    public function summaries()
    {
        try
        {

            return view('summary.summaries');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');    
        }catch(\Illuminate\Database\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');    
        }
    }


    public function summary_user()
    {
        try
        {
            $user_id = Auth::id();

            $schedulers = scheduler::whereUser_id($user_id)->get();
            $job_time = 0;
            foreach($schedulers as $job)
                $job_time += (strtotime($job->end) - strtotime($job->start))/60;

            return view('summary.summary_user')->withJob($job_time);
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');    
        }catch(\Illuminate\Database\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');    
        }
    }
}
