<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
    //
    public function index() {
        return view('admin.category.index');
    }

    public function create() {
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request) {
        $validatedData = $request->validated();
        
        $category = new Category;
        $category->name = $validatedData['name'];

        if($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';
            $imageFile = $request->file('image');
                $ext = $imageFile->getClientOriginalExtension();
                $fileName = time().'.'.$ext;
                $imageFile->move($uploadPath,$fileName);
                $category->image = $uploadPath.$fileName;
            }
        
        $category->save();

        return redirect('admin/category')->with('message', 'Category Added Successfully');
    }

    public function edit(Category $category) {
        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryFormRequest $request, $category) {
        $validatedData = $request->validated();

        $category = Category::findOrFail($category);
        $category->name = $validatedData['name'];
        $category->update();
        return redirect('admin/category')->with('message', 'Category Updated Successfully');
    }
}