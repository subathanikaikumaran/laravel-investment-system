<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerBonus extends Model
{ 
    protected $table = 'customer_bonus';//customer_bonus_details

    protected $fillable = [
        'user_id',
        'bonus_type',
        'amount',
        'level',
        'user_by'
    ];
    
}
