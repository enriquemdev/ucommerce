<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


//  mid table between product_categories )subcategories) and specifications

class CategoriesSpecifications extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories_specifications';

    protected $guarded  = [
        'id',
    ];

    public function product_category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'prod_category_id', 'id');
    }

    public function specification(): BelongsTo
    {
        return $this->belongsTo(Specification::class, 'specification_id', 'id');
    }
}
