<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function categories() {
        $categories = Category::all();
        return view('frontend.collections.category.index', compact('categories'));
    }

    public function products($category_slug) {
        $category = Category::where('name', $category_slug)->first();

        if($category) {
            
            return view('frontend.collections.products.index', compact('category'));
        } else {
            return redirect()->back();
        }
    }

    public function productView(string $category_slug, string $product_slug) {
        $category = Category::where('name', $category_slug)->first();

        if($category) {
            $product = $category->products()->where('slug', $product_slug)->first();
            if($product) {
                return view('frontend.collections.products.view', compact('product','category'));
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function thankYou() {
        return view('frontend.thank-you');
    }
}