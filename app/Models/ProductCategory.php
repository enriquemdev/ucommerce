<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_categories';

    protected $guarded  = [
        'id',
    ];
    protected $casts = [
        'shipping_price_weight' => 'boolean', // This is when you have a column in your database table that is of type boolean
    ];

    public function parent_category(): BelongsTo
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id', 'id');
    }

    //  table: categories_specifications | mid table between product_categories (subcategories) and specifications
    public function specifications(): HasMany
    {
        return $this->hasMany(CategoriesSpecifications::class, 'prod_category_id', 'id');
    }

    //  table: product_category_variations | mid table between product_categories (subcategories) and variations
    public function variations(): HasMany
    {
        return $this->hasMany(SubcategoryVariation::class, 'product_category_id', 'id');
    }

    // A product belongs to a subcategory (ProductCategory)
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id');
    }

}
