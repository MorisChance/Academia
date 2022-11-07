<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;
    public function user()
    {
    return $this->belongsTo(User::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
