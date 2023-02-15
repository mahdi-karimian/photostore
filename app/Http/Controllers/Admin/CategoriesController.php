<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreRequest $request)
    {
        $validatedDate = $request->validated();
        $createdCategory = Category::create([
            'title' => $validatedDate['title'],
            'slug' => $validatedDate['slug'],
        ]);

        if (!$createdCategory) {

            return back()->with('failed', 'دسته بندی ایجاد نشد ');
        } else {
            return back()->with('success', 'دسته بندی با موفقیت اینجاد شد ');
        }
    }

    public function all()
    {
        $categories = Category::all();

        return view('admin.categories.all',compact('categories'));
    }
}
