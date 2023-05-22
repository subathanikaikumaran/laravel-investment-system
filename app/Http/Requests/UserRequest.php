<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }


    public function createRules()
    {
        $rules = [
            'first_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z0-9\s-]+$/',
            'last_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z0-9\s-]+$/',
            'email' => 'required|max:40|email:rfc,filter|unique:users,email',
            'user_password' => 'required|min:7|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/',
            'confirm_password' => 'required|same:user_password',
            'phone' => 'required|min:10|regex:/^[0-9]+$/'
            
           
        ];

        return $rules;
    }

    public function updateRules()
    {
        $rules = [
            'first_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z0-9\s-]+$/',
            'last_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z0-9\s-]+$/',            
            'phone' => 'required|min:10|regex:/^[0-9]+$/'
            
            
        ];
        if ($this->post('id')) {
            $rules1 = [
                'email' => 'required|max:40|email:rfc,filter|unique:users,email,'.$this->post('id'),
            ];
            $rules = array_merge($rules, $rules1);
        }
        
        if ($this->post('change_pwd') == "on") {
            $rules2 = [
                'password' => 'required|min:7|regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/',
                'confirm_password' => 'required|same:password'
            ];
            $rules = array_merge($rules, $rules2);
        }

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function filters()
    {
        return [
            'first_name' => 'trim|escape',
            'last_name' => 'trim|escape',
            'email' => 'trim|escape',
            'phone' => 'trim|escape',            
            'password' => 'trim|escape',
            'confirm_password' => 'trim|escape'
            
        ];
    }
}
