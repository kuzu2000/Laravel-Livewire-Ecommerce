<div>

    <div>
        <div wire:ignore.self class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                <div class="modal-body">
                  Are you sure do you want to delete the selected category?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" wire:click.prevent="destroyCategory" class="btn btn-primary" data-bs-dismiss="modal">Delete</button>
                </div>
                </form>
              </div>
            </div>
          </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Products
                        <a href="{{url('admin/products')}}" class="btn btn-primary float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{url('admin/products/'.$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                            Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">
                            Product Images</button>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane border p-3 fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" value={{$product->name}} class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label>Product Price</label>
                                <input type="number" name="price" value={{$product->price}} class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label>Product Quantity</label>
                                <input type="number" name="quantity" value={{$product->quantity}} class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == $product->category_id ? 'selected' : ''}}>
                                            {{$category->name}}
                                        </option>  
                                    @endforeach 
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Product Description</label>
                                <textarea name="description" class="form-control" rows="4">{{$product->description}}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane border p-3 fade" id="details" role="tabpanel" aria-labelledby="details-tab">        
                            <div class="mb-3">
                                <label>Upload Product Images</label>
                                <input type="file" name="image[]" class="form-control" multiple>
                            </div>
                        <div>
                            @if($product->productImages)
                            <div class="row">
                                @foreach($product->productImages as $image)
                                <div class="col-md-2">
                                    <img src="{{asset($image->image)}}" style="width:100px;height:100px;"
                                    class="me-4 border" title="Img {{$image->id}}" alt="">
                                    <button wire:click="deleteImage({{$image->id}})" class="d-block btn btn-link" data-bs-toggle="modal" data-bs-target="#deleteImageModal">Remove</button>
                                </div>
                                @endforeach  
                            </div>                                      
                            @else
                                <h5>No Image Added</h5>  
                            @endif  
                        </div>
                      </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>