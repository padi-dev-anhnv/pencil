<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFile extends FormRequest
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
            // 'office' => 'required',
            // 'user' => 'required',
            // 'number' => 'required_if:id,!=,""',
            // 'name' => 'required',
            'material' => 'required|in:other,office,guide',
            'link' => 'required',
        ];
    }
}
