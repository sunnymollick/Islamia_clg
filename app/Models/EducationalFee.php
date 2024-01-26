<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalFee extends Model
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


    public function incomeHead()
    {
        return $this->belongsTo(IncomeHead::class);
    }

    public function stdClass()
    {
        return $this->belongsTo(StdClass::class);
    }
}
