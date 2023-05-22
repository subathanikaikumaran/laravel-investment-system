<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerBonusDetails extends Model
{ 
    protected $table = 'customer_bonus_details';

    protected $fillable = [
        'user_id',
        'level',
        'bonus_id',
        'month',
        'year',
        'amount',
        'last_update_at',
        'created_at',
        'updated_at'
    ];
    
}
