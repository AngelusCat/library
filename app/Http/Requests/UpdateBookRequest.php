<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
/*    public function authorize(): bool
    {
        return false;
    }*/

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|regex:/^[a-zа-яё0-9\-\.: ,]{1,120}$/ui',
            'originalOrModifiedAuthors' => "string|regex:/^[a-zа-яё' \(\)\-,]*$/ui",
            'newAuthors' => "string|regex:/^[a-zа-яё' \(\)\-,]*$/ui|nullable",
            'deletedAuthors' => "string|regex:/^[a-zа-яё' \(\)\-,]*$/ui|nullable",
            'description' => 'nullable|string',
            'year_of_publication' => 'required|integer|regex:/^-?[1-9]{1}[0-9]{2,3}$/|min:-600|max:' . date('Y')
        ];
    }
}
