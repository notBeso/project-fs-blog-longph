<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title'         => 'required|string|min:10|max:100',
            'des'           => 'required|string|min:10|max:250',
            'detail'        => 'required|string|min:10|max:250',
            'category'      => 'required|string',
            'public'        => 'required|string',
            'data_public'   => 'required|string',
            'position'      => 'required|array|min:1',
            'thumbs'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ];
    }
}
