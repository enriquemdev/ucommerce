<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'shipping_rates';

    protected $guarded  = [
        'id',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'destiny_department_id', 'id');
    }

    public function company_branch(): BelongsTo
    {
        return $this->belongsTo(CompanyBranch::class, 'company_branch_id', 'id');
    }
}