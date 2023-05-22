<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AccountVerify extends Model
{
    protected $table = 'account_verify';

    protected $fillable = [
        'user_id',
        'ques_id',
        'answer'
    ];


    public function letsVerifyTheUserAccount($id)
    {
        $answer = array();
        $ans = DB::table('account_verify')
            ->select("*")
            ->where('user_id', $id)
            ->orderBy('ques_id', 'ASC')
            ->get()
            ->toArray();
        
        foreach ($ans as $value) {
            $id = isset($value->ques_id) ? $value->ques_id : "";
            $answer[$id] = isset($value->answer) ? $value->answer : "";           
        }
        return $answer;
    }


    public function letsCheckUserhasAnswer($id)
    {
        $count=0;
        $ans = DB::table('account_verify')
            ->select("*")
            ->where('user_id', $id)
            ->orderBy('ques_id', 'ASC');
            // ->get()
            // ->toArray();
            $count= $ans->count();
       
        return $count;
    }
}
