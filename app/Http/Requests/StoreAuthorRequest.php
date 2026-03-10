<?php

namespace App\Http\Requests;

use App\Rules\NoHtmlTags;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:authors', new NoHtmlTags()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name.min' => 'Имя автора должно состоять минимум из 2 символов',
            'name.max' => 'Имя автора должно состоять максимум из 255 символов',
            'name.regex' => 'HTML-теги запрещены',
            'name.unique' => 'Такой автор уже существует',
        ];
    }


    public function attributes(): array
    {
        return [
            'name' => 'имя автора',
        ];
    }
}
