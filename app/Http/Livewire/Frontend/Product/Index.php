<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{

    public $products, $category, $priceInput;

    protected $queryString = [
        'priceInput' => ['except' => '', 'as' => 'price']
    ];
    
    public function mount($category) {
        $this->category = $category;
    }
    
    public function render()
    {
        $this->products = Product::where('category_id', $this->category->id)->
        when($this->priceInput, function($q) {
            $q->when($this->priceInput == 'high-to-low', function($q2) {
                $q2->orderBy('price', 'DESC');
            })->when($this->priceInput == 'low-to-high', function($q2) {
                $q2->orderBy('price', 'ASC');
            });
        })->get();
        return view('livewire.frontend.product.index',
        ['products' => $this->products,
         'category' => $this->category]);
    }
}