<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Commodity extends Model
{
    use HasFactory;
        protected $fillable = [
        'title',
        'faculty_id',
        'description',
        'price',
    ];
    public function user()
    {
    return $this->belongsTo(User::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function getImageUrlAttribute()
    {
        return Storage::url('images/commodities/' . $this->image);
    }
}
