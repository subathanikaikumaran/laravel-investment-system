<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB; 
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'username', 'email', 'password','active','pwd_changed','phone','gender','dob'
        'first_name','last_name','nic','address', 'email', 'password',
        'active','is_admin','pwd_changed','phone','gender','dob','password_chng_date',
        'title','account_verify',
        'address_street_1',
        'address_street_2',
        'city',
        'province',
        'country',
        'postalcode',
        'invited_by'
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


   
  
    
}