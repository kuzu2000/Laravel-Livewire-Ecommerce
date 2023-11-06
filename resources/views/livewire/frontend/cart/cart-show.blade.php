<div>
    <div class="py-3 py-md-5">
        <div class="container">
            <h4>My Cart</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">

                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Products</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Price</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Quantity</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Total</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Remove</h4>
                                </div>
                            </div>
                        </div>

                        @forelse ($carts as $cart)
                        @if($cart->product)
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-md-6 my-auto">
                                    <a href="{{url('collections/'.$cart->product->category->name.'/'.$cart->product->slug)}}">
                                        <label class="product-name">
                                            <img src="{{asset($cart->product->productImages[0]->image)}}" style="width: 50px; height: 50px" alt="{{$cart->product->name}}">
                                            {{$cart->product->name}}
                                        </label>
                                    </a>
                                </div>
                                <div class="col-md-1 my-auto">
                                    <label class="price">${{$cart->product->price}} </label>
                                </div>
                                <div class="col-md-2 col-7 my-auto">
                                    <div class="quantity">
                                        <div class="input-group">
                                            <button class="btn btn1" wire:loading.attr="disabled" wire:click="decrementQuantity({{$cart->id}})"><i class="fa fa-minus"></i></button>
                                            <input type="text" value="{{$cart->quantity}}" class="input-quantity" />
                                            <button class="btn btn1" wire:loading.attr="disabled" wire:click="incrementQuantity({{$cart->id}})"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 my-auto">
                                    <label class="price">${{$cart->product->price * $cart->quantity}} </label>
                                    @php
                                     $totalPrice += $cart->product->price * $cart->quantity 
                                    @endphp
                                </div>
                                <div class="col-md-2 col-5 my-auto">
                                    <div class="remove">
                                        <button wire:loading.attr="disabled" wire:click="removeCartItem({{$cart->id}})" class="btn btn-danger btn-sm">
                                            <span wire:loading.remove wire:target="removeCartItem({{$cart->id}})">
                                            <i class="fa fa-trash"></i> Remove
                                        </span>
                                            <span wire:loading wire:target="removeCartItem({{$cart->id}})">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <h3>No Cart Items Available</h3>
                        @endforelse
                        
                                
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 my-md-auto mt-3">
                    <h4>
                        Get the best deals & Offers <a href="{{url('/collections')}}">Shop Now</a>
                    </h4>
                </div>
                <div class="col-md-4">
                    <div class="shadow-sm bg-white p-3">
                        <h4> Total: <span class="float-end">${{$totalPrice}}</span></h4>
                        <hr>
                        <a href="{{url('/checkout')}}" class="btn btn-warning w-100">Checkout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
