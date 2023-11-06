<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Wishlist;

class WishlistShow extends Component
{
    public function removeWishListItem(int $wishlist_id) {
        Wishlist::where('user_id', auth()->user()->id)->where('id', $wishlist_id)->delete();
        $this->emit('wishlistAddedUpdated');
        session()->flash('message', 'Wishlist item Removed successfully');
    }

    public function render()
    {
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.wishlist-show' , [
            'wishlist' => $wishlist
        ]);
    }
}