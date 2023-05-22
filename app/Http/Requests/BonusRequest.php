<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BonusRequest extends FormRequest
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
            'type' => 'required|max:30|unique:bonus_category,type',
            'amount' => 'required|numeric',
            'isMonthly' => 'not_in:0|in:1,2,3,4,5,6',
            'basic_bonus' => 'required|numeric|max:100|regex:/^\d*(\.\d{1,2})?$/',
            'monthly_bonus' => 'required|numeric|max:100|regex:/^\d*(\.\d{1,2})?$/',
            'level' => 'not_in:0|in:1,2,3,4,5,6',
            // 'date' => '',
            'description' => 'nullable|max:200|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
        ];

        return $rules;
    }

    public function updateRules()
    {
        $rules = [
            //'type' => 'required|max:30|unique:bonus_category,type',
            'amount' => 'required|numeric',
            'isMonthly' => 'not_in:0|in:1,2,3,4,5,6',
            'basic_bonus' => 'required|numeric|max:100|regex:/^\d*(\.\d{1,2})?$/',
            'monthly_bonus' => 'required|numeric|max:100|regex:/^\d*(\.\d{1,2})?$/',
            'level' => 'not_in:0|in:1,2,3,4,5,6',
            // 'date' => '',
            'description' => 'nullable|max:200|regex:/^[a-zA-Z0-9\s.,_&()\/#-]+$/',
        ];
        if ($this->post('id')) {
            $rules1 = [
                'type' => 'required|max:30|unique:bonus_category,type,'.$this->post('id'),
            ];
            $rules = array_merge($rules, $rules1);
        }

        return $rules;
    }


    // public function messages(){

    // }

    public function filters()
    {
        return [
            'type' => 'trim|escape',
            'amount' => 'trim|escape',
            'isMonthly' => 'trim|escape',
            'basic_bonus' => 'trim|escape',
            'monthly_bonus' => 'trim|escape',
            'level' => 'trim|escape',
            'date' => 'trim|escape',
            'description' => 'trim|escape'
        ];
    }
}
