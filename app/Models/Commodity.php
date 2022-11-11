<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    public function getImagePathAttribute()
    {
        return 'images/commodities/' . $this->image;
    }
    //画像のパスは、モデルのインスタンス(照会画面でいうところの$commodity)が保持しているので、Storage::url()にimageカラムの値(パス)を入れたimage_urlというインスタンスメソッドを追加します。
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

        public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['faculty_id'])) {
            $query->where('faculty_id', $params['faculty_id']);
        }
        return $query;
    }
}
