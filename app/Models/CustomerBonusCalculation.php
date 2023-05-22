<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;


class CustomerBonusCalculation extends Model
{

    public function getAllBonus()
    {
        $amount = 0;
        $result = DB::table('customer_bonus_details')
            ->join('customers_details', 'customer_bonus_details.user_id', '=', 'customers_details.user_id')
            ->select(DB::raw('SUM(customer_bonus_details.bonus_amount) as bonus_total_amount'))
            ->where("customers_details.is_active_now", 1)
            ->get()->toarray();
        if (isset($result[0]->bonus_total_amount)) {
            $amount = $result[0]->bonus_total_amount;
        }
        return $amount;
    }



    public function getAllBonusByUser($userId)
    {
        $amount = 0;
        $result = DB::table('customer_bonus_details')
            ->join('customers_details', 'customer_bonus_details.user_id', '=', 'customers_details.user_id')
            ->select(DB::raw('SUM(customer_bonus_details.bonus_amount) as bonus_total_amount'))
            ->where("customers_details.is_active_now", 1)
            ->where("customers_details.user_id", $userId)
            ->get()->toarray();
        if (isset($result[0]->bonus_total_amount)) {
            $amount = $result[0]->bonus_total_amount;
        }
        return $amount;
    }


    public function getAllPayment()
    {

        $arr = [];
        $payment = DB::table('payments')
            ->join('customers_details', 'payments.user_id', '=', 'customers_details.user_id')
            ->select(DB::raw('SUM(payments.amount) as total'), 'type')
            ->where("customers_details.is_active_now", 1)
            ->where("payments.level", 1)
            ->groupBy('user_id', 'type')
            //->where("customers_details.user_id", $userId)
            ->get()->toarray();

            if(!empty($payment)){
                foreach ($payment as $key => $value) {
                    if ($value->type == 1) {
                        $arr['deposite'] = $value->total;
                    } else {
                        $arr['withdraw'] = $value->total;
                    }
                }
            }        
        return $arr;
    }



    public function getAllPaymentByUserId($userId)
    {

        $arr = [];
        $result = DB::table('payments')
            ->join('customers_details', 'payments.user_id', '=', 'customers_details.user_id')
            ->select(DB::raw('SUM(payments.amount) as total'), 'type')
            ->where("customers_details.is_active_now", 1)
            ->where("payments.level", 1)
            ->groupBy('user_id', 'type')
            ->where("customers_details.user_id", $userId)
            ->get()->toarray();

            if(!empty($payment)){
                foreach ($payment as $key => $value) {
                    if ($value->type == 1) {
                        $arr['deposite'] = $value->total;
                    } else {
                        $arr['withdraw'] = $value->total;
                    }
                }
            }        
        return $arr;
    }





    public function addMultipleBonusRecords($bonus, $totalBonus)
    {
        $req = [];
        $insertReq = [];
        $level = 1;
        $currentYear = Carbon::now()->format('Y');
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $month =  $this->getLastMonth($bonus->id, $level);
        foreach ($totalBonus as $key => $value) {
            $month = $month + 1;
            $req = array(
                'bonus_id' => $bonus->id,
                'month' => $month,
                'year' => $currentYear,
                'amount' => $totalBonus,
                'last_update_at' => $today,
            );
            array_push($insertReq, $req);
        }
        // print_r($insertReq);
        // exit;

        // return CustomerBonusDetails::create($req);
        return CustomerBonusDetails::insert($insertReq);
    }

    public function firstBonus($bonus)
    {
        $basicBonus = $bonus->basic_bonus;
        $payAmount = $bonus->amount;
        $firstBonus = (float)$basicBonus / 100 * (float)$payAmount;
        return  round($firstBonus, 2);
    }

    public function calculateAllBonus($bonus, $loop, $level)
    {
        $firstBonus = $this->firstBonus($bonus);
        $bonusArr = [];
        $monthlyBonus =  $bonus->monthly_bonus;
        $totalBonus = $this->getAllBonusAmount($bonus->id, $level);
        $payment = new Payment();
        $withDraw = $payment->getWithdrawPaymentByUserId($bonus->user_id);
        $balanceBonus =  $totalBonus -  (float)$withDraw;

        $a = 0;
        while ($a < $loop) {
            $a = $a + 1;
            $bonusAmount = (float)$monthlyBonus / 100 * (float)$balanceBonus;
            $firstBonus = $firstBonus + $firstBonus;
            $balanceBonus = $balanceBonus + $bonusAmount;
            $bonusArr[$a] = round($bonusAmount, 2);
        }
        return  $bonusArr;
    }

    public function normalBonus($bonus, $level)
    {
        $monthlyBonus =  $bonus->monthly_bonus;
        $totalBonus = $this->getAllBonusAmount($bonus->id, $level);
        $payment = new Payment();
        $withDraw = $payment->getWithdrawPaymentByUserId($bonus->user_id);

        $balanceBonus =  $totalBonus -  (float)$withDraw;
        $bonusAmount = (float)$monthlyBonus / 100 * (float)$balanceBonus;
        return  round($bonusAmount, 2);
    }
    /** 
     * 
     * add customer bonus details up to date  
     * 
     * */
    public function bonusAdd($userId, $level, $bonusId)
    {
        $bonus = $this->getCustomerBonusDetails($userId, $level);
        // $bonus3 = $this->calculateAllBonus($bonus, (int)3);
        // $bonus4 = $this->addMultipleBonusRecords($bonus, $bonus3);
        // print_r($bonus4);
        // exit;

        if (!empty($bonus)) {
            $isEligible = $this->isEligibleForNextBonus($userId, $level, 30);

            if ($isEligible) {
                // Calculation
                $isFirstBonus = $this->isFirstBonus($userId, $bonusId);

                if ($isFirstBonus) {

                    $days = $this->getNoOfDaysForFirstBounus($userId, $level);
                    $num = $days / 30;
                    $loop = (int)$num;

                    if ($loop == 1) {
                        $totalBonus = $this->firstBonus($bonus);
                        $month = 1;
                        $this->addBonusRecords($bonus, $totalBonus, $month);
                    }
                    /** this case - many bonus did not update, more than 1 month bonus */
                    else {
                        $bonus = $this->calculateAllBonus($bonus, $loop, $level);
                    }


                    // print_r($totalBonus);exit;
                } else {
                    $bonus = $this->normalBonus($bonus, $level);
                }
            }
        }

        return false;
    }






    public function getAllBonusAmount($bonus_id, $level)
    {
        $amount = 0;
        $result = DB::table('customer_bonus_details')
            ->select(DB::raw('SUM(bonus_amount) as bonus_total_amount'))
            ->where("bonus_id", $bonus_id)
            ->where("level", $level)
            ->get()->toarray();
        if (isset($result[0]->bonus_total_amount)) {
            $amount = $result[0]->bonus_total_amount;
        }
        return $amount;
    }

    public function getLastMonth($bonus_id, $level)
    {
        $month = 0;
        $custom = DB::table('customer_bonus')
            ->join('customer_bonus_details', 'customer_bonus.id', '=', 'customer_bonus_details.bonus_id')
            ->select('customer_bonus.*', 'customer_bonus_details.*')
            ->where("customer_bonus_details.bonus_id", $bonus_id)
            ->where("customer_bonus.level", $level)
            ->orderBy('customer_bonus_details.month', 'DESC')->first();
        if (isset($custom->month)) {
            $month = $custom->month;
        }
        return $month;
    }


    public function addBonusRecords($bonus, $totalBonus, $month)
    {
        $currentYear = Carbon::now()->format('Y');
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $req = array(
            'bonus_id' => $bonus->id,
            'month' =>  $month,
            'year' => $currentYear,
            'amount' => $totalBonus,
            'last_update_at' => $today,
        );
        return CustomerBonusDetails::create($req);
    }










    public function getNoOfDaysForFirstBounus($userId, $level)
    {
        $dayCount = 0;
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $customer = Customer::where('user_id', $userId)
            ->where('level', $level)
            ->where('is_bonus_active', 1)->first();
        $actDate = isset($customer->bonus_active_date) ? $customer->bonus_active_date : 0;
        $datetime1 = strtotime($actDate);
        $datetime2 = strtotime($today);
        $dayCount = (int)(($datetime2 - $datetime1) / 86400);

        return $dayCount;
    }





    public function isFirstBonus($userId, $bonusId)
    {
        $count = 0;
        $count = CustomerBonusDetails::where('bonus_id', '=', $bonusId)->count();
        if ($count != "" && $count != 0) {
            return false;
        }

        return true;
    }





    public function getCustomerBonusDetails($userId, $level)
    {
        $bonus = [];
        $bonus = DB::table('bonus_category')
            ->join('customer_bonus', 'bonus_category.id', '=', 'customer_bonus.bonus_type')
            ->select('bonus_category.*', 'customer_bonus.*')
            ->where("customer_bonus.user_id", $userId)
            ->where("customer_bonus.level", $level)
            ->get()->toarray();
        if (isset($bonus[0])) {
            $bonus = $bonus[0];
        }
        return $bonus;
    }



    public function isEligibleForNextBonus($userId, $level, $days)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $customer = Customer::where('user_id', $userId)
            ->where('level', $level)
            ->where('is_bonus_active', 1)->first();
        $actDate = isset($customer->bonus_active_date) ? $customer->bonus_active_date : 0;
        $dayCount = $this->getBetweenDays($actDate, $today);
        if ($dayCount >= $days) {
            return true;
        }
        return false;
    }




    public function isThisCustomer($userId)
    {
        $userCount = 0;
        $userCount = User::where('id', $userId)->where('is_admin', 2)->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
    }

    /** 
     * 
     * check customer bonus details added / not  
     * 
     * */
    public function isCustomerHasBonusRecords($userId, $bonusId, $level)
    {
        $count = 0;
        $count = CustomerBonusDetails::where('user_id', $userId)
            ->where('bonus_id', $bonusId)
            ->where('level', $level)
            ->count();
        if ($count != "" && $count != 0) {
            return true;
        }
        return false;
    }




    /** 
     * 
     * check customer bonus details up to date 
     * 
     * calculation
     * - from bonus active date 
     * - every 30 days
     * 
     * */
    public function isBonusUptoDate($userId, $bonusId, $level)
    {
        $days = -1;

        $bonus = CustomerBonusDetails::where('user_id', '=', $userId)
            ->where('bonus_id', $bonusId)
            ->where('level', $level)
            ->orderBy('last_update_at', 'DESC')->first();
        $fromDate = $bonus->last_update_at;
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $days = $this->getBetweenDays($fromDate, $today);

        if ($days != -1 && $days == 0) {
            return true;
        } elseif ($days != -1 && $days < 31) {
            return true;
        }

        return false;
    }


    public function getCustomerBonusId($userId, $level)
    {
        $bonusId = 0;
        $customerBonus = CustomerBonus::where('user_id', $userId)->where('level', $level)->first();
        $bonusId = isset($customerBonus->id) ? $customerBonus->id : 0;
        return $bonusId;
    }


    /** 
     * 
     * is customer paid initial payment
     *  
     * */
    public function isPaymentStatusActive($userId, $level)
    {
        $userCount = 0;
        $userCount = Customer::where('user_id', '=', $userId)
            ->where('pay_active', '=', 1)
            ->where('level', $level)->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
    }



    /** 
     * 
     * customer collect 6 people and 
     * they also pay active
     *  
     * */
    public function isTeamActive($userId)
    {
        $count = 0;
        $myTeam = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.*')
            ->where("users.is_admin", 2)
            ->where("customers_details.pay_active", 1)
            ->where("users.invited_by", $userId);
        $count = $myTeam->count();

        if ($count != "" && $count > 5) {
            return true;
        }
        return false;
    }


    /** 
     * 
     * check bonus status already updated
     * (if customer collect 6 people and 
     * they also pay active, 
     * then need to active bonus) 
     * 
     * */
    public function isBonusStatusActive($userId, $level)
    {
        $userCount = 0;
        $userCount = Customer::where('user_id', '=', $userId)
            ->where('is_bonus_active', '=', 1)
            ->where('level', $level)
            ->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
    }


    public function getBetweenDays($fromDate, $toDate)
    {
        $days = 0;
        $datetime1 = strtotime($fromDate); // convert to timestamps
        $datetime2 = strtotime($toDate); // convert to timestamps
        $days = (int)(($datetime2 - $datetime1) / 86400);
        return $days;
    }
}
