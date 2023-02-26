<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function all()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store(StoreRequest $request)
    {
        $validatedDate = $request->validated();
        $createdUser = User::create([
            'name' => $validatedDate['name'],
            'email' => $validatedDate['email'],
            'mobile' => $validatedDate['mobile'],
            'role' => $validatedDate['role'],
        ]);
        if (!$createdUser) {
            return back()->with('failed', 'کاربر ایحاد نشد');
        }
        return back()->with('success', 'کاربر ایجاد شد ');
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, $user_id)
    {
        $validatedDate = $request->validated();
        $user = User::findOrFail($user_id);
        $updatedUser = $user->update([
            'name' => $validatedDate['name'],
            'email' => $validatedDate['email'],
            'mobile' => $validatedDate['mobile'],
            'role' => $validatedDate['role'],
        ]);
        if (!$updatedUser) {
            return back()->with('failed', 'بروزرسانی انجام نشد');
        }
        return back()->with('success', 'بروزسانی یا موفقیت انجام شد ');
    }

    public function delete($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        return back()->with('success', 'کاربر حذف شد ');
    }
}
