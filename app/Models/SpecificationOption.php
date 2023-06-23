<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecificationOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'specification_options';

    protected $guarded  = [
        'id',
    ];

    public function specification(): BelongsTo
    {
        return $this->belongsTo(Specification::class, 'specification_id', 'id');
    }

    // public function shipping_rates(): HasMany
    // {
    //     return $this->hasMany(ShippingRate::class, 'company_branch_id', 'id');
    // }
}
