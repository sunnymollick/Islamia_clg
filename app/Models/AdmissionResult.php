<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionResult extends Model
{
    use HasFactory;
    protected $fillable = ['file_path'];

    public function stdclass()
    {
        return $this->belongsTo(StdClass::class, 'class_id');
    }
}
