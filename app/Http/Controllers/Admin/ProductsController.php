<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\products\StoreRequest;
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
        $products= Product::paginate(10);
        return view('admin.products.all',compact('products'));

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
        try {
            $basePath = 'products/' . $createdProduct->id . '/';
            $sourceImageFullPath = $basePath . 'source_url' . $validatedData['source_url']->GetClientOriginalName();

            $images = [
                'thumbnail_url' => $validatedData['thumbnail_url'],
                'demo_url' => $validatedData['demo_url'],
            ];
            $imagesPath = ImageUploader::uploadMany($images, $basePath);
            ImageUploader::upload($validatedData['source_url'], $sourceImageFullPath, 'local_storage');
            $updatedProduct = $createdProduct->update([
                'thumbnail_url' => $imagesPath['thumbnail_url'],
                'demo_url' => $imagesPath['demo_url'],
                'source_url' => $sourceImageFullPath,
            ]);
            if (!$updatedProduct) {
                throw new \Exception('تصویری آپلود نشد ');
            }
            return back()->with('success', 'محصول مورد نظر ایجاد شد ');
        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }

    }

    public function downloadDemo($product_id)
    {
        $product = Product::findOrFail($product_id);
       //dd('/public/'.$product->demo_url);
        return response()->download(public_path('/public/'.$product->demo_url));
    }

    public function downloadSource($product_id)
    {
        $product = Product::findOrFail($product_id);
 //dd(storage_path('app/local_storage/'.$product->source_url));
        return response()->download(storage_path('app/local_storage/'.$product->source_url) );

    }

    public function delete($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return back()->with('success','محصول حذف شد ');
    }
}
