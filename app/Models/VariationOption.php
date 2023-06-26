<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariationOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'variations_options';

    protected $guarded  = [
        'id',
    ];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }

    //  table: product_category_variations | mid table between product_categories (subcategories) and variations
    // public function subcategories(): HasMany
    // {
    //     return $this->hasMany(SubcategoryVariation::class, 'variation_id', 'id');
    // }
}
