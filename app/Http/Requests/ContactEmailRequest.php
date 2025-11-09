<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:80',
            'email' => 'required|email:rfc,dns,spoof,filter,strict',
            'phone' => 'nullable|numeric|digits:10',
            'message' => 'required|string|min:30|max:4096',
            'g-recaptcha-response' => 'required|recaptchav3:contact,0.5',
        ];
    }
}
