<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'presentation' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'number'],
            'tag' => ['required', 'string'],
        ];
    }
}
