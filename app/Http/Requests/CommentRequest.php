<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|string|max:200',
        ];
    }
    //同じカラム名でも、モデル毎に呼び名を変更したい場合は、各モデルのフォームリクエストにattributesメソッドを追加して上書きします。
    public function attributes()
    {
        return [
            'body' => 'コメント',
        ];
    }
}
