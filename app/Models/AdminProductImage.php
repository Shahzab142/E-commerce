<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProductImage extends Model
{
        protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Product Relationship
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(AdminProduct::class);
    }
}