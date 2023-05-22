<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id', 'amount',  'type', 'date', 'description', 'user_by', 'is_initial'
    ];


    public function getPayment($id)
    {
        $payment = array();
        $payment = DB::table('payments')
            ->select(DB::raw('sum(amount) as total'), 'type')
            ->where([
                ['user_id', $id]
            ])
            ->groupBy('user_id', 'type')
            ->get()->toarray();
        return $payment;
    }

    
    public function isNotEligibleForSecondPayment($id)
    {
        $count = 0; 
        $count = Customer::where('user_id', '=', $id)
        ->where('pay_active', 1)
        ->where('is_active_now', 1)
        ->count();
        if ($count == 0) {
            return true;
        }
        return false;
    }



    public function getPaymentAmountByTypeUserId($id,$type)
    {
        $amount = 0;
        $payment = DB::table('payments')
            ->select(DB::raw('SUM(amount) as total'))
            ->where([
                ['user_id', $id],
                ['type', $type]
            ])
            ->groupBy('user_id', 'type')
            ->get()->toarray();
        if (isset($payment[0]->total)) {
            $amount = $payment[0]->total;
        }

        return $amount;
    }

    public function getPaymentCountByUserId($id)
    {
        $count = 0;
        $payment = DB::table('payments')
            ->select(DB::raw('count(amount) as total'))
            ->where([
                ['user_id', $id],
                ['type', 1]
            ])
            ->groupBy('user_id', 'type')
            ->get()->toarray();
        if (isset($payment[0]->total)) {
            $count = $payment[0]->total;
        }

        return $count;
    }


    public function getWithdrawPaymentByUserId($userId)
    {
        $amount = 0;
        $payment = DB::table('payments')
            ->select(DB::raw('sum(amount) as total'))
            ->where([
                ['user_id', $userId],
                ['type', 2]
            ])
            ->groupBy('user_id', 'type')
            ->get()->toarray();
        if (isset($payment[0]->total)) {
            $amount = $payment[0]->total;
        }
        return $amount;
    }


    public function getWithdrawPayment()
    {
        $amount = 0;
        $payment = DB::table('payments')
            ->select(DB::raw('sum(amount) as total'))
            ->where([
                ['type', 2]
            ])
            ->groupBy('type')
            ->get()->toarray();
        if (isset($payment[0]->total)) {
            $amount = $payment[0]->total;
        }
        return $amount;
    }




    public function getMyWallet($id)
    {
        $arr = array();
        $payment = array();
        $arr['deposite'] = 0;
        $arr['withdraw'] = 0;
        $arr['bonus'] = 0;
        $arr['totalBalance'] = 0;
        $arr['availableBalance'] = 0;
        $arr['availablewithdraw'] = 0;
        $bonus = 0;
        $anyOtherBonus = 0;
        $payment = $this->getPayment($id);

        $bonusObj = new CustomerBonusCalculation();
        $bonus = $bonusObj->getAllBonusByUser($id);
        if (!empty($payment)) {
            foreach ($payment as $key => $value) {
                if ($value->type == 1) {
                    $arr['deposite'] = $value->total;
                } else {
                    $arr['withdraw'] = $value->total;
                }
            }
        }
        
        $userCount = User::where('id', '=', $id)->where('temp_bonus', '=', 1)->count();
        if ($userCount != "" && $userCount != 0) {
            $anyOtherBonus=10;
        }

        $iniPayment = $arr['deposite'];
        $totalWidraw = $arr['withdraw'];
        $totalBonus = $bonus;
        $allBonus = $bonus + $anyOtherBonus;
        $totalBalance = $allBonus - $totalWidraw;

        $arr['bonus'] = $totalBonus;

        $arr['totalBalance'] =  $anyOtherBonus;
        $arr['availableBalance'] = $allBonus;

        $arr['availablewithdraw'] = $totalBalance;
        return  $arr;
    }
}
