<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\products\StoreRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Utilities\ImageUploader;


class ProductsController extends Controller
{
    public function all()
    {
        $products = Product::paginate(10);
        return view('admin.products.all', compact('products'));

    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.add', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $validatedData = $request->validated();
        $createdProduct = Product::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
            'owner_id' => $admin->id,
        ]);

    }

    public function downloadDemo($product_id)
    {
        $product = Product::findOrFail($product_id);
        //dd('/public/'.$product->demo_url);
        return response()->download(public_path('/public/' . $product->demo_url));
    }

    public function downloadSource($product_id)
    {
        $product = Product::findOrFail($product_id);
        //dd(storage_path('app/local_storage/'.$product->source_url));
        return response()->download(storage_path('app/local_storage/' . $product->source_url));


    }

    public function delete($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return back()->with('success', 'محصول حذف شد ');
    }

    public function edit($product_id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($product_id);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateRequest $request, $product_id)
    {
        $validatedData = $request->validated();
         $product = Product::findOrFail($product_id);
        $updatedProduct = $product->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'category_id' => $validatedData['category_id'],
        ]);
       return $this->uploadImages($product,$validatedData);
    }

    private function uploadImages($createdProduct, $validatedData)
    {
        try {
            $basePath = 'products/' . $createdProduct->id . '/';

            $sourceImageFullPath = null;
             $data = [];
            if (isset($validatedData['source_url'])) {
                $sourceImageFullPath = $basePath . 'source_url' . $validatedData['source_url']->GetClientOriginalName();
                ImageUploader::upload($validatedData['source_url'], $sourceImageFullPath, 'local_storage');
                $data += ['source_url' => $sourceImageFullPath];
            };

            if (isset($validatedData['thumbnail_url'])) {
                $fullPath = $basePath . 'thumbnail_url' . '_' . $validatedData['thumbnail_url']->GetClientOriginalName();
                ImageUploader::upload($validatedData['thumbnail_url'], $fullPath, 'public_storage');
                $data += ['thumbnail_url' => $fullPath];

            };
            if (isset($validatedData['demo_url'])) {
                $fullPath = $basePath . 'demo_url' . '_' . $validatedData['demo_url']->GetClientOriginalName();
                $data += ['demo_url' => $fullPath];
                ImageUploader::upload($validatedData['demo_url'], $fullPath, 'public_storage');
                 $data += ['demo_url' => $fullPath];

            };

            $updatedProduct = $createdProduct->update($data);
            if (!$updatedProduct) {
                throw new \Exception('تصویری آپلود نشد ');
            }
            return back()->with('success', 'محصول مورد نظر بروزرسانی شد  ');
        } catch (\Exception $e) {
             return back()->with('failed', $e->getMessage());
        }

    }
}
