<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountVerifyRequest extends FormRequest
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
            'ques1' => 'required|not_in:0|in:1,2,3',
            'ques2' => 'required|not_in:0|in:1,2,3|different:ques1',
            'answer1' => 'required|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'answer2' => 'required|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/'
           
        ];

        return $rules;
    }

    public function updateRules()
    {
        $rules = [
            'ques1' => 'required|not_in:0|in:1,2,3',
            'ques2' => 'required|not_in:0|in:1,2,3|different:ques1',
            'answer1' => 'required|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
            'answer2' => 'required|string|max:100|min:5|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/'
            
        ];
       
        return $rules;
    }

    public function messages()
    {
        return [
            'ques1.not_in' => 'Please select the Question 1.',
            'ques2.not_in' => 'Please select the Question 1.',
            'ques2.different' => 'The Question 1 And Question 2 can not be same. Please select the different Question.'
        ];
    }

    public function filters()
    {
        return [
            'ques1' => 'trim|escape',
            'ques2' => 'trim|escape',
            'answer1' => 'trim|escape',
            'answer2' => 'trim|escape'            
            
        ];
    }
}
