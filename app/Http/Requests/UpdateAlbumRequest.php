<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'existing_pictures' => 'array',
            'existing_pictures.*.name' => 'required|string|max:255',
            'existing_pictures.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'pictures' => 'array',
            'pictures.*.name' => 'nullable|string|max:255',
            'pictures.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
