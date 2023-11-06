<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $category_id;

    public function deleteCategory($category_id){
            $this->category_id = $category_id;
    }

    public function destroyCategory() {
        Category::findOrFail($this->category_id)->delete();
        session()->flash('message', 'Category Deleted Successfully');
    }

    // public function editPost($id) {
    //     $post = Category::findOrFail($id);
    //     if( !$post) {
    //         session()->flash('message','Post not found');
    //     } else {
    //             $this->name = $post->name;     
    //             $this->updatePost = true;
    //         }        
    // }
    
    public function render()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.category.index', ['categories' => $categories]);
    }
}