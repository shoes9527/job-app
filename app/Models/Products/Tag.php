<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'product_id', 'tag_id');
    }
}
