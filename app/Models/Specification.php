<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Specification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'specifications';

    protected $guarded  = [
        'id',
    ];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_added', 'id');
    // }

    public function specification_options(): HasMany
    {
        return $this->hasMany(SpecificationOption::class, 'specification_id', 'id');
    }
}
