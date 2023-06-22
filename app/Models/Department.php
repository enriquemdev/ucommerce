<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cat_departments';

    protected $guarded  = [
        'id',
    ];

    public function company_branches(): HasMany
    {
        return $this->hasMany(CompanyBranch::class, 'cat_department_id', 'id');
    }

    public function shipping_rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class, 'destiny_department_id', 'id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(AddressUser::class, 'department_id', 'id');
    }
}
