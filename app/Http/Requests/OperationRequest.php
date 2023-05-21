<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount'=>['required','numeric','gt:0'],
            'remark'=>['max:135'],
            'category_id'=>['required','integer'],
        ];
    }
    public function attributes()
{
    return [
        'category_id' => 'category',
    ];
}
}
