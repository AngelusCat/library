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
            'year_of_publication' => 'required|integer|regex:/^-?[1-9]{1}[0-9]{2,3}$/|min:-500|max:' . date('Y')
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле "название книги" обязательно для заполнения.',
            'title.regex' => 'В названии книги можно использовать следующие символы: '
                . 'заглавные и строчные буквы английского и русского алфавитов, арабские цифры, тире, точку, двоеточие, пробел, запятую.',
            'originalOrModifiedAuthors.required' => 'Поле "авторы" обязательно для заполнения',
            'originalOrModifiedAuthors.regex' => 'В поле "автора" можно использовать следующие символы: '
                . 'заглавные и строчные буквы английского и русского алфавитов, апостроф, пробел, круглые скобки, тире, запятую.',
            'newAuthors.regex' => 'В поле "авторы для добавления" можно использовать следующие символы: '
                . 'заглавные и строчные буквы английского и русского алфавитов, апостроф, пробел, круглые скобки, тире, запятую.',
            'deletedAuthors.regex' => 'В поле "авторы на удаление" можно использовать следующие символы: '
                . 'заглавные и строчные буквы английского и русского алфавитов, апостроф, пробел, круглые скобки, тире, запятую.',
            'year_of_publication.required' => 'Поле "год публикации" обязательно для заполнения.',
            'year_of_publication.integer' => 'Год публикации обязан быть числом.',
            'year_of_publication.min' => 'Минимальный год, который можно указать: -500 (VI век до н.э.)',
            'year_of_publication.max' => 'Максимальный год, который можно указать: ' . date('Y'),
            'year_of_publication.regex' => 'Первая цифры года не может быть 0. Количество используемых символов должно быть не больше 4.'
        ];
    }
}
