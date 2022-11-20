<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
    public function comments(){
    return $this->hasMany(Comment::class);
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
    public function scopeMyCommodity(Builder $query, $params)
    {
        if (Auth::user()) {
            $query->latest()
            ->with(['faculty'])
                //->where('user_id', Auth::user()->user_id)ゆーざーのユーザーIDとなっていたため、反応しなかった。
            ->where('user_id', Auth::user()->id);
    }
}
}
