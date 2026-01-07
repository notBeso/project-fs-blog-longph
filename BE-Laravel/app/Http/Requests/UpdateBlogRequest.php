<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|text|min:10|max:100',
            'des'           => 'required|text|min:10|max:250',
            'detail'        => 'required|text|min:10|max:250',
            'category'      => 'required|string',
            'public'        => 'required|boolean',
            'data_public'   => 'required|string|min:1',
            'position'      => 'required|text',
            'thumbs'        => 'nullable|text',
        ];
    }
}
