<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientChangePasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [    
            'user_current_password' => 'required|min:7|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/',               
            'user_password' => 'required|min:7|different:user_current_password|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/',
            'confirm_password' => 'required|same:user_password',
        ];

        return $rules;
    }



    public function messages()
    {
        return [];
    }

    public function filters()
    {
        return [
            
            'user_current_password' => 'trim|escape',
            'user_password' => 'trim|escape',
            'confirm_password' => 'trim|escape'
        ];
    }
}
