<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    //
    public function index() {
        return view('admin.products.index');
    }

    public function create() {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    public function store(ProductFormRequest $request) {
        $validatedData = $request->validated();

        $category = Category::findOrFail($validatedData['category_id']);
        $product = $category->products()->create([
           'category_id' => $validatedData['category_id'],
           'name' => $validatedData['name'],
           'price' => $validatedData['price'],
           'slug' => Str::slug($validatedData['name']),
           'quantity' => $validatedData['quantity'],
           'description' => $validatedData['description'],
        ]);

        if($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';

            $i = 1;
            foreach($request->file('image') as $imageFile) {
                $ext = $imageFile->getClientOriginalExtension();
                $fileName = time().$i++.'.'.$ext;
                $imageFile->move($uploadPath,$fileName);
                $finalImagePathName = $uploadPath.$fileName;
                
                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName
                ]);
            }
        }

        return redirect('admin/products')->with('message', 'Product Added Successfully');
        
    }

    public function edit(int $id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    public function update(ProductFormRequest $request, int $id)
    {
        $validatedData = $request->validated();
        
        $product = Category::findOrFail($validatedData['category_id'])->products()->where('id', $id)->first();
         
        if($product) {
            $product->update([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'slug' => Str::slug($validatedData['slug']),
                'quantity' => $validatedData['quantity'],
                'description' => $validatedData['description'],
            ]);

            if($request->hasFile('image')) {
                $uploadPath = 'uploads/products/';
    
                $i = 1;
                foreach($request->file('image') as $imageFile) {
                    $ext = $imageFile->getClientOriginalExtension();
                    $fileName = time().$i++.'.'.$ext;
                    $imageFile->move($uploadPath,$fileName);
                    $finalImagePathName = $uploadPath.$fileName;
                    
                    $product->productImages()->create([
                        'product_id' => $product->id,
                        'image' => $finalImagePathName
                    ]);
                }
            }
                return redirect('admin/products')->with('message', 'Product Updated Successfully');
        } else {
            return redirect('admin/products')->with('message', 'Product Not Found');
        } 
    }

    public function destroyImage(int $img_id) {
        $productImage = ProductImage::findOrFail($img_id);

        if(File::exists($productImage->image)) {
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message','Product Image Deleted');
    }

}