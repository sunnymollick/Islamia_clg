<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EducationalFee;

class IncomeHead extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function educationalFees()
    {
        return $this->hasMany(EducationalFee::class);
    }

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }
}
