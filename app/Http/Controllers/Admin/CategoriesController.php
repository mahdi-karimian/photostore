<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Requests\Admin\categories\StoreRequest;
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
        $categories = Category::paginate(3);

        return view('admin.categories.all', compact('categories'));
    }

    public function delete($category_id)
    {
        $category = Category::find($category_id);
        $category->delete();
        return back()->with('success', 'دسته بندی حذف شد ');
    }

    public function edit($category_id)
    {
        $category = Category::find($category_id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateRequest $request, $category_id)
    {
        $validatedData = $request->validated();
        $category = Category::find($category_id);
        $updatedCategory = $category->update([
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
        ]);
        if (!$updatedCategory) {
            return back()->with('failed', 'بروزرسانی با مشکل مواجه شد  ');
        }
        return back()->with('success', 'بروزرسانی با موفقیت انجام شد   ');

    }
}
