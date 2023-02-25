<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function all()
    {
        $users= User::paginate(10);
        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store()
    {

    }

    public function edit($user_id)
    {
        $user= User::findOrFail($user_id);
        return view('admin.users.edit',compact('user'));
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
