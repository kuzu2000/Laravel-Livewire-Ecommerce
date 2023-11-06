<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'quantity',
        'price',
        'slug'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function productImages() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}