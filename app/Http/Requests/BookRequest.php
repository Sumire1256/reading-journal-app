<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'memo' => 'nullable|string',
            'status' => 'required|integer|in:0,1,2',
            'genres' => 'required|array',
            'genres.*' => 'integer|exists:genres,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '本のタイトルが入力されていません',
            'title.max' => '本のタイトルは100文字以内で記入してください',
            'author.required' => '著者名が入力されていません',
            'author.max' => '著者名は100文字以内で記入してください',
            'status.required' => 'ステータスを選んでください',
            'genres.required' => 'ジャンルを選んでください',
        ];
    }
}
