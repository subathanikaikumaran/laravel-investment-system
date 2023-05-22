<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MerchantMcc;

class Custom extends Model
{
     
     public function getCurrency($value)
     {
          $type = "";
          switch ($value) {
               case '1':
                    $type = "LKR";
                    break;
               case '2':
                    $type = "$";
                    break;
               case '3':
                    $type = "GBP";
                    break;
               case '4':
                    $type = "EUR";
                    break;
               default:
                    $type = "";
                    break;
          }
          return $type;
     }



     
}
