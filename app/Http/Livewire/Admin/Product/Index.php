<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
     use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $product_id, $imageId;

    public function deleteProduct($product_id){
            $this->product_id = $product_id;
    }

    public function destroyProduct() {
        Product::findOrFail($this->product_id)->delete();
        session()->flash('message', 'Product Deleted Successfully');
    }    

    public function deleteImage($imageId) {
        dd($imageId);
        $this->imageId = $imageId;
    }
    
    public function render()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('livewire.admin.product.index', ['products' => $products]);
    }
}