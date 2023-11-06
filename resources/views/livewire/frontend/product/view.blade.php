<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            @if(session('message'))
            <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <div class="row">
                <div class="col-md-5">
                    <div class="bg-white border">
                        @if($product->productImages)
                        <img src="{{asset($product->productImages[0]->image)}}" class="w-100" alt="Img">
                        @else
                        <h3>No Images Added</h3>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            {{$product->name}}
                        </h4>
                        <hr>
                        <p class="product-path">
                            Home / {{$product->category->name}} /  {{$product->name}}
                        </p>
                        <div>
                            <span class="selling-price">${{$product->price}}</span>
                        </div>
                        <div>
                            @if($product->quantity > 0)
                            <label class="btn-sm py-1 text-white bg-success">In Stock</label>
                            @else
                            <label class="btn-sm py-1 text-white bg-danger">Out of Stock</label>
                            @endif
                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                                <input type="text" wire:model="quantityCount" value={{$this->quantityCount}} value="1" class="input-quantity" />
                                <span class="btn btn1" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn1" wire:click="addToCart({{$product->id}})"> <i class="fa fa-shopping-cart"></i> Add To Cart</button>

                            <button type="button" wire:click="addToWishList({{$product->id}})" class="btn btn1">
                                <span wire:loading.remove wire:target="addToWishList">
                                    <i class="fa fa-heart"></i> Add To Wishlist 
                                    </span>
                                    <span wire:loading wire:target="addToWishList"><i class="fa fa-spinner fa-spin"></i></span>
                                </button>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-0">Small Description</h5>
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
