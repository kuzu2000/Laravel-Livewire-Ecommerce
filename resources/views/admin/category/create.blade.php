@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Category
                    <a href="{{url('admin/category')}}" class="btn btn-primary float-end">BACK</a>
                </h3>
            </div>
            <div class="card-body">
            <form action="{{url('admin/category')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" />
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" />
                    @error('image')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <button class="btn btn-primary float-end" type="Submit">Save</button>
                </div>
            </form>
            </div>
        </div>    
    </div>
</div>
@endsection