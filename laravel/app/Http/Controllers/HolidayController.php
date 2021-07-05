<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\holidays;

class HolidayController extends Controller
{
    // konstruktor
    public function __construct()
    {
        $this->miesiace=['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    }

    public function holidays($month=null, $year = null)
    {
        try
        {
            $holidays = holidays::select('date')->get();
            $years = [];
            foreach($holidays as $holiday)
                if(date('Y', strtotime($holiday->date)) != end($years))
                    array_push($years, date('Y', strtotime($holiday->date)));

            session(['url' => null]);
            if($month==null)
                $month = date('m');
            if($year==null)
                $year = date('Y');
            $month = str_pad($month, 2, 0, STR_PAD_LEFT);

            $holidays = holidays::where('date', 'like', $year.'-'.$month.'-%')->get();
            return view('calendar.holidays.holidays')->withHolidays($holidays)->withMonth($month)->withYear($year)->withMiesiace($this->miesiace)->withYears($years);
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
            return view('calendar.holidays.holiday')->withHoliday($holiday);
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
            session(['url' => $request->url]);
            
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
