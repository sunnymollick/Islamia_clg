<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category'];

    public function author()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
