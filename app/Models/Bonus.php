<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Bonus extends Model
{
    protected $table = 'bonus';//bonus_category

    protected $fillable = [
        'user_id', 'amount',  'last_update', 'level'
    ];


    public function checkBonus($id,$level)
    {
        $bonus = array();
        $arr = array();
        $arrValue=array();
        $arrValue = DB::table('bonus')
            ->select(DB::raw('sum(amount) as total, count(id) as count'))
            ->where([
                ['user_id', $id]  ,
                ['level', $level]             
            ])
            ->groupBy('user_id', 'level')
            ->get()->toarray();
        
        $arr = json_decode(json_encode($arrValue), true);
        if(empty($arr)){
            $test = $this->generateBonus($id,$level);
            
        } 
        $bonus=$arr;
        return $bonus;
    }



    public function generateBonus($id,$level)
    {
        

    }


    


    
}
