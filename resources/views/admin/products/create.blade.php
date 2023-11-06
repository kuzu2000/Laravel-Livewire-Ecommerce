@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Add Products
                    <a href="{{url('admin/products')}}" class="btn btn-primary float-end">Back</a>
                </h3>
            </div>
            <div class="card-body">
                <form action="{{url('admin/products')}}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                            <input type="text" name="name" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Product Slug</label>
                            <input type="text" name="slug" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Product Price</label>
                            <input type="number" name="price" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Product Quantity</label>
                            <input type="number" name="quantity" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>  
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Product Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="tab-pane border p-3 fade" id="details" role="tabpanel" aria-labelledby="details-tab">        
                        <div class="mb-3">
                            <label>Upload Product Images</label>
                            <input type="file" name="image[]" class="form-control" multiple>
                        </div>

                    </div>
                  </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection