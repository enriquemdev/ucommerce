<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// mid table between product_categories (subcategories) and variations
class SubcategoryVariation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_category_variations';

    protected $guarded  = [
        'id',
    ];

    public function product_category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }
}
