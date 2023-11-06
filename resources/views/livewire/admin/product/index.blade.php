<div>
    <div>
        <div wire:ignore.self class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                <div class="modal-body">
                  Are you sure do you want to delete the selected product?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" wire:click.prevent="destroyProduct" class="btn btn-primary" data-bs-dismiss="modal">Delete</button>
                </div>
                </form>
              </div>
            </div>
          </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
            <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>product
                        <a href="{{url('admin/products/create')}}" class="btn btn-primary float-end">Add product</a>
                    </h3>
                </div>
                <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->price}}</td>
                                <td>
                                    <a href="{{url('admin/products/'.$product->id.'/edit')}}" class="btn btn-success">Edit</a>
                                    <button wire:click="deleteProduct({{$product->id}})" data-bs-toggle="modal" data-bs-target="#deleteProductModal" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                {{$products->links()}}
                </div>
            </div>    
        </div>
    </div>

</div>
