<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariationGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'variations_products_group';

    protected $guarded  = [
        'id',
    ];

    // protected $casts = [
    //     'state' => 'boolean', // This is when you have a column in your database table that is of type boolean
    //     'images' => 'array', // The img urls are saved like an array
    // ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    //  table: categories_specifications | mid table between product_categories (subcategories) and specifications
    // public function specifications(): HasMany
    // {
    //     return $this->hasMany(CategoriesSpecifications::class, 'prod_category_id', 'id');
    // }
}
