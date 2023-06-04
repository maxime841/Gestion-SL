<?php

namespace App\Http\Requests;

use App\Models\Land;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LandCreateRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique(Land::class)],
            'owner' => '',
            'presentation' => ['required', 'string'],
            'description' => ['required', 'string'],
            'group' => ['required', 'string', Rule::unique(Land::class)],
            'prims' => ['required'],
            'remaining_prims' => ['required'],
            'date_buy' => ['required', 'date']
        ];
    }
}
