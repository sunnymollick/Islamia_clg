<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'std_code',
        'dob',
        'gender',
        'religion',
        'blood_group',
        'address',
        'phone',
        'email',
        'year',
        'password',
        'file_path',
        'uploaded_by'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function stdParent()
    {
        return $this->hasMany(StdParent::class, 'student_id');
    }


    public function bills()
    {
        return $this->hasMany(Bill::class, 'student_id');
    }

}
