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
            'name' => 'required',
            'material' => 'required|in:other,office,guide',
            'fileUpload' => 'required_if:link,""',
            'link' => 'required_if:fileUpload,""',
        ];
    }
}
