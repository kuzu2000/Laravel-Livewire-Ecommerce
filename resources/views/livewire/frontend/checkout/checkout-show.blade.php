<div>

    <div>
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">You will be charged ${{ number_format($this->totalProductAmount, 2) }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" wire:submit.prevent="onlineOrder({{$this->totalProductAmount}})" class="require-validation p-3" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                @csrf
                <div class='form-row row'>
                   <div class='col-xs-12 col-md-6 form-group required'>
                      <label class='control-label'>Name on Card</label> 
                      <input class='form-control' wire:model.defer="fullname" type='text'>
                   </div>
                   <div class='col-xs-12 col-md-6 form-group required'>
                      <label class='control-label'>Card Number</label> 
                      <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                   </div>                           
                </div>                        
                <div class='form-row row'>
                   <div class='col-xs-12 col-md-4 form-group cvc required'>
                      <label class='control-label'>CVC</label> 
                      <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                   </div>
                   <div class='col-xs-12 col-md-4 form-group expiration required'>
                      <label class='control-label'>Expiration Month</label> 
                      <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                   </div>
                   <div class='col-xs-12 col-md-4 form-group expiration required'>
                      <label class='control-label'>Expiration Year</label> 
                      <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                   </div>
                </div>
              {{-- <div class='form-row row'>
                 <div class='col-md-12 error form-group hide'>
                    <div class='alert-danger alert'>Please correct the errors and try
                       again.
                    </div>
                 </div>
              </div> --}}
                <div class="form-row row mt-3">
                   <div class="col-xs-12">
                      <button class="btn btn-primary btn-block" type="submit">Pay Now</button>
                   </div>
                </div>
             </form>
          </div>
        </div>
      </div>
    </div>

    <div class="py-3 py-md-4 checkout">
        <div class="container">
            <h4>Checkout</h4>
            <hr>

            @if($this->totalProductAmount != '0')
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="shadow bg-white p-3">
                        <h4 class="text-primary">
                            Item Total Amount :
                            <span class="float-end">${{$this->totalProductAmount}}</span>
                        </h4>
                        <hr>
                        <small>* Items will be delivered in 3 - 5 days.</small>
                        <br/>
                        <small>* Tax and other charges are included ?</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="shadow bg-white p-3">
                        <h4 class="text-primary">
                            Basic Information
                        </h4>
                        <hr>

                        
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="text" wire:model.defer="email" class="form-control" placeholder="Enter Email" />
                                    @error('email')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone Number</label>
                                    <input type="number" wire:model.defer="phone" class="form-control" placeholder="Enter Phone Number" />
                                    @error('phone')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email Address</label>
                                    <input type="email" wire:model.defer="email" class="form-control" placeholder="Enter Email Address" />
                                    @error('email')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Pin-code (Zip-code)</label>
                                    <input type="number" wire:model.defer="pincode" class="form-control" inputmode="numeric" maxlength="6" placeholder="Enter Pin-code" />
                                    @error('pincode')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Full Address</label>
                                    <textarea wire:model.defer="address" class="form-control" rows="2"></textarea>
                                    @error('address')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Select Payment Mode: </label>
                                    <div class="d-md-flex align-items-start">
                                        <div class="nav col-md-3 flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <button class="nav-link fw-bold" id="cashOnDeliveryTab-tab" data-bs-toggle="pill" data-bs-target="#cashOnDeliveryTab" type="button" role="tab" aria-controls="cashOnDeliveryTab" aria-selected="true">Cash on Delivery</button>

                                            <button class="nav-link fw-bold" id="onlinePayment-tab" data-bs-toggle="pill" data-bs-target="#onlinePayment" type="button" role="tab" aria-controls="onlinePayment" aria-selected="false">Online Payment</button>
                                        </div>
                                        <div class="tab-content col-md-9" id="v-pills-tabContent">
                                            <div class="tab-pane fade" id="cashOnDeliveryTab" role="tabpanel" aria-labelledby="cashOnDeliveryTab-tab" tabindex="0">
                                                <h6>Cash on Delivery Mode</h6>
                                                <hr/>
                                                <button type="button" wire:loading.attr="disabled" wire:click="codOrder" class="btn btn-primary">
                                                    <span wire:loading.remove wire:target="codOrder">
                                                        Place Order (Cash on Delivery)
                                                    </span>
                                                    <span wire:loading wire:target="codOrder">
                                                        Placing Order...
                                                        </span>
                                                </button>

                                            </div>
                                            <div class="tab-pane fade" id="onlinePayment" role="tabpanel" aria-labelledby="onlinePayment-tab" tabindex="0">
                                                <h6>Online Payment Mode</h6>
                                                <hr/>
                                                <button type="button" wire:loading.attr="disabled" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Pay Now <span>Stripe</span></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                       

                    </div>
                </div>

            </div>
            @else
            <div class="card card-body shadow">
                <h4>No items in cart</h4>
                <a href="{{url('collections')}}" class="btn btn-warning">Shop now</a>
            </div>
            @endif
        </div>
    </div>




<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
$(function() {
  var $form = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form = $(".require-validation"),
    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
    $inputs = $form.find('.required').find(inputSelector),
    $errorMessage = $form.find('div.error'),
    valid = true;
    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
        }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
      if (response.error) {
          $('.error')
              .removeClass('hide')
              .find('.alert')
              .text(response.error.message);
      } else {
          /* token contains id, last4, and card type */
          var token = response['id'];
          $form.find('input[type=text]').empty();
          $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
          $form.get(0).submit();
      }
  }
});
</script>
</div>