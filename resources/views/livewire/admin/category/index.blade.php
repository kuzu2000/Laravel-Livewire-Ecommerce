<div>
<div>
    <div wire:ignore.self class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Category
                    <a href="{{url('admin/category/create')}}" class="btn btn-primary float-end">Add Category</a>
                </h3>
            </div>
            <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                                <a href="{{url('admin/category/'.$category->id.'/edit')}}" class="btn btn-success">Edit</a>
                                <button wire:click="deleteCategory({{$category->id}})" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{$categories->links()}}
            </div>
        </div>    
    </div>
</div>
</div>