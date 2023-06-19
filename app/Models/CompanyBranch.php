<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyBranch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'company_branches';

    protected $guarded  = [
        'id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'cat_department_id', 'id');
    }

    public function shipping_rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class, 'company_branch_id', 'id');
    }
}
