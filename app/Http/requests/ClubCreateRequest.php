<?php

namespace App\Http\Requests;

use App\Models\Club;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClubCreateRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique(Club::class)],
            'owner' => ['required', 'string'],
            'presentation' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }
}
