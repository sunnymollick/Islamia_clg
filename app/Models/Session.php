<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public function stdClass()
    {
        return $this->hasMany(StdClass::class, 'session_id');
    }

}
