<?php

namespace App\Http\Requests;

use App\Models\Commentaire;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CommentHostCreateRequest extends FormRequest
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
            'title' => ['required', 'string', Rule::unique(Commentaire::class)],
            'content' => [ 'string', Rule::unique(Commentaire::class)],
        ];
    }
}
