<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Customer extends Model
{
     protected $table = 'customers_details';

     protected $fillable = [
          'user_id', 
          'pay_active', 
          'pay_active_date', 
          'pay_last_date', 
          'current_level', 
          'is_bonus_active', 
          'bonus_active_date', 
          'level_started', 
          'level_end',
      ];
     
    
}