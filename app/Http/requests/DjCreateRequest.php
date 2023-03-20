<?php

namespace App\Http\Requests;

use App\Models\Dj;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DjCreateRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique(Dj::class)],
            'style' => ['required', 'string'],
            'presentation' => ['required', 'string'],
            'date_entrance' => ['required', 'date'],
        ];
    }
}
