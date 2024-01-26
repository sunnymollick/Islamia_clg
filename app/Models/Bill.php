<?php

namespace App\Models;

use App\Models\BillDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
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


  

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class, 'bill_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'bill_id');
    }
}
