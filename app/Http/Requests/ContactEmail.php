<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactEmail extends FormRequest
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
            'name' => 'required|string|max:80',
            'email' => 'required|email:rfc,dns,spoof,filter,strict',
            'phone' => 'nullable|string|max:10',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|recaptchav3:contact,0.5',
        ];
    }
}
