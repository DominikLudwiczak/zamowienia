<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class EmployeeController extends Controller
{
    // user
    public function user()
    {
        return view('employees.user');
    }

    // all - admin
    public function all()
    {
        $users = User::paginate(15);
        return view('employees.admin')->withUsers($users);
    }

    // edit
    public function edit()
    {
        return view('employees.edit');
    }

    // delete
    public function delete(Request $request)
    {
        return redirect()->back()->withSuccess('Usunięto użytkownika');
    }

    // search
    public function search(Request $request)
    {

    }
}
