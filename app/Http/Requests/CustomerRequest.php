<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'phone' => 'required|min:10|regex:/^[0-9]+$/',
            'title' => 'required|not_in:0|string|max:100|min:2|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'nic'    => 'required',    
            'gender' => 'required|not_in:0|in:1,2',
            'address_street_1' => 'nullable|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'address_street_2' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'city' => 'nullable|string|max:100|min:3|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'province' => 'nullable|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'country' => 'nullable|string|max:100|min:2|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'postalcode' => 'nullable|string|max:100|min:4|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/'
           
        ];

        return $rules;
    }

    public function updateRules()
    {
        $rules = [
            'first_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z0-9\s-]+$/',
            'last_name' => 'required|string|max:100|min:2|regex:/^[a-zA-Z0-9\s-]+$/',            
            'phone' => 'required|min:10|regex:/^[0-9]+$/',
            'gender' => 'required|not_in:0|in:1,2',
            'title' => 'required|not_in:0|string|max:100|min:2|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'nic'    => 'required',
            'active' => 'in:0,1',
            'address_street_1' => 'nullable|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'address_street_2' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'city' => 'nullable|string|max:100|min:3|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'province' => 'nullable|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'country' => 'nullable|string|max:100|min:2|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'postalcode' => 'nullable|string|max:100|min:4|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/'
            
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
        return [
            'title.not_in' => 'Please select the title.',
            'gender.not_in' => 'Please select the gender.',
            'country.not_in' => 'Please select the country.',

            'phone.required' => 'Please enter the phone number.', 
            'phone.min' => 'The phone number cannot be less than 10 numbers.',
            'phone.max' => 'The phone number cannot be greater than 12 numbers.',
            'phone.regex' => 'The phone number format is invalid.',
        ];
    }

    public function filters()
    {
        return [
            'first_name' => 'trim|escape',
            'last_name' => 'trim|escape',
            'email' => 'trim|escape',
            'phone' => 'trim|escape',            
            'password' => 'trim|escape',
            'confirm_password' => 'trim|escape',
            'gender' => 'trim|escape',
            'dob' => 'trim|escape',
            'address_street_1' => 'trim|escape',
            'address_street_2' => 'trim|escape',
            'city' => 'trim|escape',
            'province' => 'trim|escape',
            'country' => 'trim|escape',
            'postalcode' =>'trim|escape'
        ];
    }
}
