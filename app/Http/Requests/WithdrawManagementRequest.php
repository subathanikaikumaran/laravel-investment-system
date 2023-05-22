<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawManagementRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        $rules= [
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
            'amount' => 'trim|escape',
            'description' => 'trim|escape'
        ];
    }
}
