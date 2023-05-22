<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Withdraw extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'amount', 'user_id', 'description', 'status', 'date'
    ];
}
