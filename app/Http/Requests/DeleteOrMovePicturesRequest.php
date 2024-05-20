<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteOrMovePicturesRequest extends FormRequest
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
            'action' => 'required|string|in:delete,move',
            'target_album_id' => 'nullable|integer|exists:albums,id',
        ];
    }
    public function messages()
    {
        return [
            'action.required' => 'The action field is required.',
            'action.in' => 'The action must be either delete or move.',
            'target_album_id.integer' => 'The target album ID must be an integer.',
            'target_album_id.exists' => 'The selected target album ID does not exist.',
        ];
    }
}
