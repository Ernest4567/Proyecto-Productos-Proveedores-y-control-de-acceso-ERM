<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    return true; // route middleware already guarantees an authenticated user
}

public function rules(): array
{
    return [
        'title'        => ['required', 'string', 'max:255'],
        'content'      => ['required', 'string'],
        'is_published' => ['sometimes', 'boolean'],
    ];
}
}
