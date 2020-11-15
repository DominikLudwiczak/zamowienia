<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\shops;
use App\scheduler;
use Auth;

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
        $shops = shops::all();
        $schedulers = scheduler::where('date', 'like', '%'.$year."-".$month.'%')->where('user_id', Auth::user()->id)->OrderBy('start')->get();
        return view('calendar.scheduler.scheduler_user')->withMonth($month)->withYear($year)->withMiesiace($this->miesiace)->withSchedulers($schedulers)->withShops($shops);
    }

    // scheduler_admin
    public function scheduler_admin()
    {
        $shops = shops::all();
        return view('calendar.scheduler.scheduler_admin')->withShops($shops);
    }

    // scheduler_shop
    public function scheduler_shop($id, $month=null, $year=null)
    {
        if($month==null)
            $month = date('m');
        if($year==null)
            $year = date('Y');
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);
        $shop = shops::findOrFail($id);
        $users = User::all();
        $schedulers = scheduler::where('date', 'like', '%'.$year."-".$month.'%')->where('shop_id', $id)->OrderBy('start')->get();
        return view('calendar.scheduler.scheduler_shop')->withMonth($month)->withYear($year)->withMiesiace($this->miesiace)->withShop($shop)->withSchedulers($schedulers)->withUsers($users);
    }


    // scheduler add
    public function add($id)
    {
        $users = User::all();
        return view('calendar.scheduler.add')->withUsers($users)->withShopid($id);
    }

    // scheduler add_store
    public function add_store(Request $request, $id)
    {
        try
        {
            $work = new scheduler;
            $work->date = $request->date;
            $work->start = $request->start;
            $work->end = $request->end;
            $work->user_id = $request->user;
            $work->shop_id = $id;
            $work->who_added = Auth::user()->id;
            $work->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
        return redirect(route('scheduler_shop', ['id' => $id]))->withSuccess('Dodano zmianę');
    }

    // scheduler view
    public function view($id)
    {
        $work = scheduler::findOrFail($id);
        $user = User::findOrFail($work->user_id);
        $shop = shops::findOrFail($work->shop_id);
        return view('calendar.scheduler.view')->withWork($work)->withUser($user)->withShop($shop);
    }

    // scheduler edit
    public function edit($id)
    {
        $work = scheduler::findOrFail($id);
        $users = User::all();
        $shop = shops::findOrFail($work->shop_id);
        $curr_usr = Auth::user();
        return view('calendar.scheduler.edit')->withWork($work)->withUsers($users)->withShop($shop)->with('curr_usr', $curr_usr);
    }

    // scheduler edit_store
    public function edit_store(Request $request, $id)
    {
        try
        {
            $work = scheduler::findOrFail($id);
            $work->date = $request->date;
            $work->start = $request->start;
            $work->end = $request->end;
            $work->user_id = $request->user;
            $work->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
        return redirect(route('scheduler_view', ['id' => $id]))->withSuccess('Edytowano zmianę');
    }

    // scheduler delete
    public function delete(Request $request)
    {
        try
        {
            $work = scheduler::findOrFail($request->id);
            $work->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('scheduler_shop', ['id' => $work->shop_id]))->withFailed('Wystąpił błąd');
        }
        return redirect(route('scheduler_shop', ['id' => $work->shop_id]))->withSuccess('Usunięto zmianę');
    }
}