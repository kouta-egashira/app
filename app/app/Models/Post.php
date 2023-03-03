<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    // controllerでRequestメソッドを使う際は、Modelで下記設定が必要
    protected $guarded = ['id'];  // id以外は要素を入れる

    // リレーション子モデル
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
