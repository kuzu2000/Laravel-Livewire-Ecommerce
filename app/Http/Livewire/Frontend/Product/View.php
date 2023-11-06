<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $category, $product, $quantityCount = 1;


    public function addToWishList($productId) {
        if(Auth::check()) {
            if(Wishlist::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                // $this->dispatchBrowserEvent('message', [
                //     'text' => 'Added to wishlist successfully',
                //     'type' => 'warning',
                //     'status' => 409
                // ]);
                session()->flash('message', 'Already Added to wishlist');
            } else {
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                $this->emit('wishlistAddedUpdated');
            //  $this->dispatchBrowserEvent('message', [
            //         'text' => 'Added to wishlist successfully',
            //         'type' => 'success',
            //         'status' => 401
            //     ]);
            session()->flash('message', 'Added to wishlist successfully');
            }    
        } else {
            // $this->dispatchBrowserEvent('message', [
            //     'text' => 'Please login to continue',
            //     'type' => 'info',
            //     'status' => 401
            // ]);
            session()->flash('message', 'Please login to continue');
            return false;
        }
    }

    public function decrementQuantity() {
        if($this->quantityCount < 1) {
            $this->quantityCount--;
        }
    }

    public function incrementQuantity() {
        if($this->quantityCount < 10) {
            $this->quantityCount++;
        }
    }
    public function mount($category, $product) {
        $this->category = $category;
        $this->product = $product;
    }

    public function addToCart($productId) {
        if(Auth::check()) {
            if($this->product->where('id', $productId)->exists()) {
                if(!Cart::where('id', $productId)->where('user_id', auth()->user()->id)->exists()) {
                    if($this->product->quantity > 0) {
                        if($this->product->quantity > $this->quantityCount) {
                            Cart::create([
                               'user_id' => auth()->user()->id,
                               'product_id' => $productId,
                               'quantity' => $this->quantityCount
                            ]);
                            $this->emit('CartAddedUpdated');
                            session()->flash('message', 'Product Added To Cart');
                        } else {
                            session()->flash('message', 'Only'.$this->product->quantity.'Quantity Available');
                        }
                    } else {
                        session()->flash('message', 'Out of Stock');
                    } 
                } else {
                    session()->flash('message', 'Already Added To Cart');
                }       
            }
        } else {
            session()->flash('message', 'Please login to add to cart');
        }
    }

    
    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}