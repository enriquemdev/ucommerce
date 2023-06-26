<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded  = [
        'id',
    ];
    protected $casts = [
        'state' => 'boolean', // This is when you have a column in your database table that is of type boolean
        'images' => 'array', // The img urls are saved like an array
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    // Table: variations_products_group | mid table between products and variations details (one to many)
    public function variation_group(): HasMany
    {
        return $this->hasMany(VariationGroup::class, 'product_id', 'id');
    }
}
