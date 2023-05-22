<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        $rules= [
            'user_by' => 'required',
            // 'currency' => 'required',
            'amount' => 'required|numeric',
            'description' => 'max:200'  
        ];
        
        return $rules;
    }


    // public function messages(){
        
    // }

    public function filters()
    {               
        return [
            'user_by' => 'trim|escape',
            // 'currency' => 'trim|escape',
            'amount' => 'trim|escape',
            'description' => 'trim|escape'
        ];
    }
}
