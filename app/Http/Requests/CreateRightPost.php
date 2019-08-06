<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRightPost extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'right_name' => ['required', 'string', 'max:255'],
            'right_value' => ['required', 'string', 'max:255'],
            'right_path' => ['required', 'string', 'max:255'],
        ];
    }
}
