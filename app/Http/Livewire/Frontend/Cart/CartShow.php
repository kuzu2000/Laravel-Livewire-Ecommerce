<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $carts, $totalPrice = 0;

    public function decrementQuantity($cartId) {
        $cart = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();
        if($cart) {
            $cart->decrement('quantity');
            session()->flash('message','Quantity Updated');
        } else {
            session()->flash('message','Something went wrong!');
        }
    }

    public function incrementQuantity($cartId) {
        $cart = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();
        if($cart) {
            if($cart->product->quantity > $cart->quantity) {
                $cart->increment('quantity');
            session()->flash('message','Quantity Updated');
        } else {
            session()->flash('message','Only'.$cart->product->quantity.'Quantity Available');
        }
            } else {
                session()->flash('message','Something went wrong!');
            }
            
    }

    public function removeCartItem($cartId) {
        $cart = Cart::where('user_id', auth()->user()->id)->where('id', $cartId)->first();
        if($cart) {
            $cart->delete();
            $this->emit('CartAddedUpdated');
            session()->flash('mesage', 'Cart Item Removed Successfully');
        } else {
            session()->flash('message','Something went wrong!');
        }
    }

    public function render()
    {
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show', [
            'carts' => $this->carts
        ]);
    }
}