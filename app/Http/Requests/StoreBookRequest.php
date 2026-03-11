<?php

namespace App\Http\Requests;

use App\Models\Author;
use App\Rules\NoHtmlTags;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:2', 'max:255', new NoHtmlTags],
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'authors_ids' => [
                $this->getAuthorsRequiredRules(),
                'array',
                'min:1'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле обязательно для заполнения',
            'title.min' => 'Навзание должно состоять минимум из 2 символов',
            'title.max' => 'Навзание должно состоять максимум из 255 символов',
            'year.required' => 'Поле обязательно для заполнения',
            'year.integer' => 'Поле должно содержать только буквы',
            'year.min' => 'Год издания джолжен быть не раньше 1000',
            'year.max' => 'Год издания должен быть не позднее текущего',
            'authors_ids.required' => 'Выберите хотя бы одного автора',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'название книги',
        ];
    }

    private function getAuthorsRequiredRules(): string
    {
        if (Author::exists()) {
            return 'required';
        }

        return 'nullable';
    }
}
