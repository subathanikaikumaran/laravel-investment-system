<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BonusCategory extends Model
{ 
    protected $table = 'bonus_category';

    protected $fillable = [
        'user_by',
        'level',
        'type',
        'description',
        'basic_bonus',
        'monthly_bonus',
        'is_monthy_bonus',
        'date',
        'last_update',
        'ini_amount'
    ];
    
}
