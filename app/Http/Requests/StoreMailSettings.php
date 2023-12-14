<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMailSettings extends FormRequest
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
            'mail_username' => 'bail|max:50',
            'mail_password' => 'bail|max:50',
            'from_address' => 'bail|max:150|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mail_template' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'mail_username.max' => 'The Username may not be greater than 50 characters.',
            'mail_password.max' => 'The Password may not be greater than 100 characters.',
            'from_address.max' => 'The from_address may not be greater than 100 characters.',
            'from_address.regex' => 'The From Address must be type of Email',
        ];
    }
}
