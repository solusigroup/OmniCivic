<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Asset extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'branch_id',
        'asset_code',
        'name',
        'category',
        'purchase_date',
        'purchase_price',
        'condition',
        'notes',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
