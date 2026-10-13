<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminCategory extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Database Table
    |--------------------------------------------------------------------------
    |
    | Your model is called AdminCategory, but your database table is
    | called "categories".
    |
    */

    protected $table = 'categories';


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'slug',
        'image',
        'short_description',
        'description',
        'status',
        'show_on_homepage',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/'.$this->image))) {
            return asset('storage/'.$this->image);
        }

        return asset('assets/img/placeholder-category.svg');
    }


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'show_on_homepage' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(AdminProduct::class, 'category_id');
    }
}