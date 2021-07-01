<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\holidays;

class HolidayController extends Controller
{
    public function holidays($year = null)
    {
        try
        {
            $holidays = holidays::select('date')->get();
            $years = [];
            foreach($holidays as $holiday)
                if(date('Y', strtotime($holiday->date)) != end($years))
                    array_push($years, date('Y', strtotime($holiday->date)));

            if($year == null)
                $year = date('Y');

            $holidays = holidays::where('date', 'like', $year.'-%')->paginate(15);
            return view('holidays.holidays')->withHolidays($holidays)->withYear($year)->withYears($years);
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }


    public function holiday($id)
    {
        try
        {
            $holiday = holidays::findOrFail($id);
            return view('holidays.holiday')->withHoliday($holiday);
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }


    public function holiday_store(Request $request, $id)
    {
        try
        {
            $holiday = holidays::findOrFail($id);
            $holiday->name = $request->name;
            $holiday->date = $request->date;
            $holiday->save();

            return redirect()->back()->withSuccess('Zapisano zmiany');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }

    public function delete_holiday(Request $request)
    {
        try
        {
            holidays::findOrFail($request->id)->delete();
            return redirect()->route('holidays')->withSuccess('Usunięto święto');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }



    public function new_holiday_store(Request $request)
    {
        try
        {
            $holiday = new holidays;
            $holiday->name = $request->name;
            $holiday->date = $request->date;
            $holiday->save();

            return redirect()->route('holidays')->withSuccess('Dodano nowe święto');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
    }
}
