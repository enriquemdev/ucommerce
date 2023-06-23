<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'parent_product_categories';

    protected $guarded  = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_added', 'id');
    }

    // public function shipping_rates(): HasMany
    // {
    //     return $this->hasMany(ShippingRate::class, 'company_branch_id', 'id');
    // }
}
