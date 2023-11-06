<?php

namespace App\Http\Livewire\Frontend\Checkout;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Order;
use Livewire\Component;
use Stripe\StripeClient;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CheckoutShow extends Component
{
    public $carts, $totalProductAmount;


    public $fullname, $email, $phone, $pincode, $address, $payment_mode = NULL, $payment_id = NULL;

    public function rules() {
        return 
        ['fullname' => 'required|string',
         'email' => 'required|email',
         'phone' => 'required|numeric',
         'pincode' => 'required|integer',
         'address' => 'required|string'   
        ];
    }


    public function placeOrder() {
        $this->validate();
        $order = Order::create([
            'user_id' => auth()->user()->id, 
        'tracking_no' => 'eshopee-'.Str::random(10),
        'fullname' => $this->fullname,
        'email' => $this->email,
        'phone' => $this->phone,
        'pincode' => $this->pincode,
        'address' => $this->address,
        'status_message' => 'in progress',
        'payment_mode'=> $this->payment_mode ,
        'payment_id' => $this->payment_id
        ]);

        foreach ($this->carts as $cart) {

            $orderItems = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' =>$cart->quantity,
                'price' => $cart->product->price
            ]);
            
            $cart->product()->where('id', $cart->product_id)->decrement('quantity', $cart->quantity);
         } 

         return $order;

        
    }

    public function onlineOrder(Request $request, $amount) {
        $this->payment_mode = 'Paid by Stripe';
        $codOrder = $this->placeOrder();
        if($codOrder) {
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $stripe->paymentIntents->create([
                'amount' => 100 * $amount,
                'currency' => 'usd',
                'description' => 'Demo payment with stripe',
                'receipt_email' => auth()->user()->email,
                'confirm' => true,
                'payment_method' => 'pm_card_visa',
                'payment_method_types' => ['card'],
                'return_url' => 'http://localhost:8000/thank-you',
            ]);
            Cart::where('user_id', auth()->user()->id)->delete();
            session()->flash('message', 'Order Placed Successfully');
            return redirect('thank-you');
        } else {
            session()->flash('message', 'Something went wrong');
            return redirect()->back();
        }
    }

    public function codOrder() {
        $this->payment_mode = 'Cash on Delivery';
        $codOrder = $this->placeOrder();
        if($codOrder) {
            Cart::where('user_id', auth()->user()->id)->delete();
            session()->flash('mesasge', 'Order Placed Successfully');
            return redirect()->to('thank-you');
        } else {
            session()->flash('mesasge', 'Something went wrong');
        }
    }
    
    public function totalProductAmount() {
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        foreach ($this->carts as $cart) {
           $this->totalProductAmount += $cart->product->price * $cart->quantity;
        } 
        return $this->totalProductAmount;
    }
    
    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;
        
        $this->totalProductAmount = $this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show', [
            'totalProductAmount' => $this->totalProductAmount,
        ]);
    }
}