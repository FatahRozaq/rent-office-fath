<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeSpaceBenefit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'office_space_id',
    ];

    public function officeSpace()
    {
        return $this->belongsTo(OfficeSpace::class);
    }
}
