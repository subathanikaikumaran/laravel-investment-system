<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonusRequest;
use App\Models\Payment;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Auditlogs;
use App\Models\BonusCategory;
use App\Models\Customer;
use App\Models\CustomerBonus;
use App\Models\CustomerBonusCalculation;
use App\Models\CustomerBonusDetails;
use Carbon\Carbon;

class CustomerBonusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }

    public function index(Request $request)
    {
        $userId = 29;
        $level = 1;
        $customerBonus = new CustomerBonusCalculation();
        $isCustomer = $customerBonus->isThisCustomer($userId);
        $bonusDetailID = $customerBonus->getCustomerBonusId($userId, $level);

        if ($isCustomer) {
            $isCustomerHasBonusData = $customerBonus->isCustomerHasBonusRecords($userId, $bonusDetailID, $level);
            if ($isCustomerHasBonusData) {

                $isBonusUptoDate = $customerBonus->isBonusUptoDate($userId, $bonusDetailID, $level);
                if ($isBonusUptoDate) {
                    return 'Display bonus';
                } else {
                    return 'error'; //TODO Need to update Data
                }
            } else {

                $isPayActive =  $customerBonus->isPaymentStatusActive($userId, $level);

                if ($isPayActive) {
                    // team active ?
                    $isTeamActive = $customerBonus->isTeamActive($userId);

                    if ($isTeamActive) {
                        // bonus active ?                        
                        $isBonusActive =  $customerBonus->isBonusStatusActive($userId,$level); // Done

                        if ($isBonusActive) {
                            // Then Add
                            $addBonus = $customerBonus->bonusAdd($userId, $level, $bonusDetailID);                           
                        } else {
                            // Then update
                            $updateBonusActive = $customerBonus->bonusStatusUpdate($userId); // Done
                            $addBonus = $customerBonus->bonusAdd($userId, $level, $bonusDetailID);
                        }
                    } else {
                        return 'error'; //Team inactive
                    }
                } else {
                    return 'error'; //Pay status inactive
                }

                return 'error'; // No Data
            }
        } else {
            return 'error'; // un registerd customer
        }

        // print_r($isCustomerHasBonusData);
       // exit;
    }

    // public function index1(Request $request)
    // {

    //     $userId = 29;


    //     // $addBonus = $this->bonusAdd($userId);
    //     // print_r($addBonus);
    //     // exit;



    //     $isThisCustomer = $this->isThisCustomer($userId);

    //     if ($isThisCustomer) {

    //         $checkIsBonusAdded = $this->isBonusAdded($userId); // Done

    //         if ($checkIsBonusAdded) {
    //             // Added 
    //             $checkIsBonusUptoDate = $this->isBonusUptoDate($userId); // Done
    //             // print_r($checkIsBonusUptoDate ); exit;

    //             if ($checkIsBonusUptoDate) {
    //                 // Display
    //                 echo 'Display bonus';
    //             } else {
    //                 echo 'Then update';
    //                 // Then update
    //                 $bonusUpdate = $this->bonusUpdate($userId);
    //             }
    //         } else {

    //             // payment status active ?
    //             $checkIsPayActive =  $this->isPaymentStatusActive($userId); // Done

    //             if ($checkIsPayActive) {

    //                 // team active ?
    //                 $checkIsTeamActive = $this->isTeamActive($userId); // Done

    //                 if ($checkIsTeamActive) {

    //                     // bonus active ?                        
    //                     $checkIsBonusActive =  $this->isBonusStatusActive($userId); // Done

    //                     if ($checkIsBonusActive) {
    //                         // Then Add
    //                         //echo 'Then Add';
    //                         $addBonus = $this->bonusAdd($userId);
    //                         print_r($addBonus);
    //                         exit;
    //                     } else {

    //                         // Then update
    //                         $updateBonusActive = $this->bonusStatusUpdate($userId); // Done
    //                         $addBonus = $this->bonusAdd($userId);
    //                     }
    //                 } else {
    //                     // Display - Team is not active
    //                     echo 'Team is not active'; // Done
    //                 }
    //             } else {
    //                 // Display - Payment is not complete
    //                 echo 'Payment is not complete'; // Done
    //             }
    //         }
    //     } else {
    //         // Display - Payment is not complete
    //         echo 'This Id is not customer'; // Done
    //     }
    // }



    // public function isThisCustomer($userId)
    // {
    //     $userCount = 0;
    //     $userCount = User::where('id', '=', $userId)->where('is_admin', '=', 2)->count();
    //     if ($userCount != "" && $userCount != 0) {
    //         return true;
    //     }
    //     return false;
    // }


    // public function getCustomerBonusId($userId)
    // {
    //     $bonusId = 0;
    //     $customerBonus = CustomerBonus::where('user_id', $userId)->first();
    //     $bonusId = isset($customerBonus->id) ? $customerBonus->id : 0;
    //     return $bonusId;
    // }


    // public function getBonusDetails($bonusId)
    // {
    //     $arr = [];
    //     $arr = BonusCategory::find($bonusId);
    //     return $arr;
    // }





    // /** 
    //  * 
    //  * check customer bonus details up to date 
    //  * 
    //  * calculation
    //  * - from bonus active date 
    //  * - every 30 days
    //  * 
    //  * */
    // public function isBonusUptoDate($userId)
    // {
    //     $days = -1;
    //     $bonusId = $this->getCustomerBonusId($userId);
    //     if ($bonusId != 0) {
    //         $bonus = CustomerBonusDetails::where('bonus_id', '=', $bonusId)
    //             ->orderBy('last_update_at', 'DESC')->first();
    //         $fromDate = $bonus->last_update_at;
    //         $today = Carbon::now()->format('Y-m-d H:i:s');
    //         $days = $this->getBetweenDays($fromDate, $today);

    //         if ($days != -1 && $days == 0) {
    //             return true;
    //         } elseif ($days != -1 && $days < 31) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }



    // /** 
    //  * 
    //  * add customer bonus details up to date  
    //  * 
    //  * */
    // public function bonusAdd($userId)
    // {



    //     // $month =  $this->getLastMonth(3, 1);
    //     // print_r($month);
    //     // exit;
    //     // customer_bonus, bonus_category
    //     $bonus = $this->getCustomerBonusDetails($userId);
    //     // print_r($bonus);
    //     // exit;
    //     // $bonus1 = $this->calculateAllBonus($bonus);
    //     // print_r( $bonus1); exit;

    //     $bonus3 = $this->calculateAllBonus($bonus, (int)3);
    //     $bonus4 = $this->addMultipleBonusRecords($bonus, $bonus3);
    //     print_r($bonus4);
    //     exit;

    //     if (!empty($bonus)) {
    //         $isEligible = $this->isEligibleForNextBonus($userId, 30);

    //         if ($isEligible) {
    //             // Calculation
    //             $isFirstBonus = $this->isFirstBonus($userId);

    //             if ($isFirstBonus) {

    //                 $days = $this->getNoOfDaysForFirstBounus($userId);
    //                 $num = $days / 30;
    //                 $loop = (int)$num;

    //                 if ($loop == 1) {
    //                     $totalBonus = $this->firstBonus($bonus);
    //                     $month = 1;
    //                     $this->addBonusRecords($bonus, $totalBonus, $month);
    //                 }
    //                 /** this case - many bonus did not update, more than 1 month bonus */
    //                 else {
    //                     $bonus = $this->calculateAllBonus($bonus, $loop);
    //                 }


    //                 // print_r($totalBonus);exit;
    //             } else {
    //                 $bonus = $this->normalBonus($bonus);
    //             }
    //         }
    //     }

    //     return false;
    // }

    // public function addBonusRecords($bonus, $totalBonus, $month)
    // {
    //     $currentYear = Carbon::now()->format('Y');
    //     $today = Carbon::now()->format('Y-m-d H:i:s');
    //     $req = array(
    //         'bonus_id' => $bonus->id,
    //         'month' =>  $month,
    //         'year' => $currentYear,
    //         'amount' => $totalBonus,
    //         'last_update_at' => $today,
    //     );
    //     return CustomerBonusDetails::create($req);
    // }


    // public function addMultipleBonusRecords($bonus, $totalBonus)
    // {
    //     $req = [];
    //     $insertReq = [];
    //     $level = 1;
    //     $currentYear = Carbon::now()->format('Y');
    //     $today = Carbon::now()->format('Y-m-d H:i:s');
    //     $month =  $this->getLastMonth($bonus->id, $level);
    //     foreach ($totalBonus as $key => $value) {
    //         $month = $month + 1;
    //         $req = array(
    //             'bonus_id' => $bonus->id,
    //             'month' => $month,
    //             'year' => $currentYear,
    //             'amount' => $totalBonus,
    //             'last_update_at' => $today,
    //         );
    //         array_push($insertReq, $req);
    //     }
    //     print_r($insertReq);
    //     exit;

    //     // return CustomerBonusDetails::create($req);
    //     return CustomerBonusDetails::insert($insertReq);
    // }

    // public function firstBonus($bonus)
    // {
    //     $basicBonus = $bonus->basic_bonus;
    //     $payAmount = $bonus->amount;
    //     $firstBonus = (float)$basicBonus / 100 * (float)$payAmount;
    //     return  round($firstBonus, 2);
    // }

    // public function calculateAllBonus($bonus, $loop)
    // {
    //     $bonusArr = [];
    //     $monthlyBonus =  $bonus->monthly_bonus;
    //     $totalBonus = $this->getAllBonusAmount($bonus->id);
    //     $payment = new Payment();
    //     $withDraw = $payment->getWithdrawPaymentByUserId($bonus->user_id);
    //     $balanceBonus =  $totalBonus -  (float)$withDraw;

    //     $a = 0;
    //     while ($a < $loop) {
    //         $a = $a + 1;
    //         $bonusAmount = (float)$monthlyBonus / 100 * (float)$balanceBonus;
    //         $balanceBonus = $balanceBonus + $bonusAmount;
    //         $bonusArr[$a] = round($bonusAmount, 2);
    //     }
    //     return  $bonusArr;
    // }

    // public function normalBonus($bonus)
    // {
    //     $monthlyBonus =  $bonus->monthly_bonus;
    //     $totalBonus = $this->getAllBonusAmount($bonus->id);
    //     $payment = new Payment();
    //     $withDraw = $payment->getWithdrawPaymentByUserId($bonus->user_id);

    //     $balanceBonus =  $totalBonus -  (float)$withDraw;
    //     $bonusAmount = (float)$monthlyBonus / 100 * (float)$balanceBonus;
    //     return  round($bonusAmount, 2);
    // }




    // public function getAllBonusAmount($bonus_id)
    // {
    //     $amount = 0;
    //     $result = DB::table('customer_bonus_details')
    //         ->select(DB::raw('SUM(bonus_amount) as bonus_total_amount'))
    //         ->where("bonus_id", $bonus_id)
    //         ->get()->toarray();
    //     if (isset($result[0]->bonus_total_amount)) {
    //         $amount = $result[0]->bonus_total_amount;
    //     }
    //     return $amount;
    // }

    // public function getLastMonth($bonus_id, $level)
    // {
    //     $month = 0;
    //     $custom = DB::table('customer_bonus')
    //         ->leftjoin('customer_bonus_details', 'customer_bonus.id', '=', 'customer_bonus_details.bonus_id')
    //         ->select('customer_bonus.*', 'customer_bonus_details.*')
    //         ->where("customer_bonus_details.bonus_id", $bonus_id)
    //         ->where("customer_bonus.level", $level)
    //         ->orderBy('customer_bonus_details.month', 'DESC')->first();
    //     if (isset($custom->month)) {
    //         $month = $custom->month;
    //     }
    //     return $month;
    // }


    // public function isFirstBonus($userId)
    // {
    //     $count = 0;
    //     $bonusId = $this->getCustomerBonusId($userId);
    //     if ($bonusId != 0) {
    //         $count = CustomerBonusDetails::where('bonus_id', '=', $bonusId)->count();
    //         // print_r( $count); exit;
    //         if ($count != "" && $count != 0) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }


    // public function getCustomerBonusDetails($userId)
    // {
    //     $bonus = [];
    //     $bonus = DB::table('bonus_category')
    //         ->leftjoin('customer_bonus', 'bonus_category.id', '=', 'customer_bonus.bonus_type')
    //         ->select('bonus_category.*', 'customer_bonus.*')
    //         ->where("customer_bonus.user_id", $userId)
    //         ->get()->toarray();
    //     if (isset($bonus[0])) {
    //         $bonus = $bonus[0];
    //     }
    //     return $bonus;
    // }




    // /** 
    //  * 
    //  * update customer bonus details up to date  
    //  * 
    //  * */
    // public function bonusUpdate($userId)
    // {
    //     $bonusId = $this->getCustomerBonusId($userId);
    //     $bonusDetail = $this->getBonusDetails($bonusId);
    //     // Calculation
    // }



    // /** 
    //  * 
    //  * check bonus status already updated
    //  * (if customer collect 6 people and 
    //  * they also pay active, 
    //  * then need to active bonus) 
    //  * 
    //  * */
    // public function isBonusStatusActive($userId)
    // {
    //     $userCount = 0;
    //     $userCount = Customer::where('user_id', '=', $userId)->where('is_bonus_active', '=', 1)->count();
    //     if ($userCount != "" && $userCount != 0) {
    //         return true;
    //     }
    //     return false;
    // }

    // /** 
    //  * 
    //  * is customer paid initial payment
    //  *  
    //  * */
    // public function isPaymentStatusActive($userId)
    // {
    //     $userCount = 0;
    //     $userCount = Customer::where('user_id', '=', $userId)->where('pay_active', '=', 1)->count();
    //     if ($userCount != "" && $userCount != 0) {
    //         return true;
    //     }
    //     return false;
    // }

    // /** 
    //  * 
    //  * customer collect 6 people and 
    //  * they also pay active
    //  *  
    //  * */
    // public function isTeamActive($userId)
    // {
    //     $count = 0;
    //     $myTeam = DB::table('users')
    //         ->leftjoin('customers_details', 'users.id', '=', 'customers_details.user_id')
    //         ->select('users.*', 'customers_details.*')
    //         ->where("users.is_admin", 2)
    //         ->where("customers_details.pay_active", 1)
    //         ->where("users.invited_by", $userId);
    //     $count = $myTeam->count();

    //     if ($count != "" && $count > 5) {
    //         return true;
    //     }
    //     return false;
    // }

    // /** 
    //  * 
    //  * if customer collect 6 people and 
    //  * they also pay active, 
    //  * then need to active bonus 
    //  * 
    //  * get activated date
    //  * it should activate - payment deposite
    //  * */
    // public function bonusStatusUpdate($userId)
    // {
    //     $date = $this->getLastTeamAccountPayActiveDate($userId);

    //     $update = Customer::where('user_id', $userId)->where('is_bonus_active', 0)->update(
    //         [
    //             'is_bonus_active' => 1,
    //             'bonus_active_date' => $date
    //         ]
    //     );
    //     if ($update) {
    //         return true;
    //     }
    //     return false;
    // }



    // public function getLastTeamAccountPayActiveDate($userId)
    // {
    //     $date = Carbon::now()->format('Y-m-d H:i:s');
    //     $myTeam = DB::table('users')
    //         ->leftjoin('customers_details', 'users.id', '=', 'customers_details.user_id')
    //         ->select('users.*', 'customers_details.*')
    //         ->where("users.is_admin", 2)
    //         ->where("customers_details.pay_active", 1)
    //         ->where("users.invited_by", $userId)
    //         ->orderBy('customers_details.pay_active_date', 'DESC')->first();
    //     if (isset($myTeam->pay_active_date)) {
    //         $date = $myTeam->pay_active_date;
    //     }
    //     return $date;
    // }


    // public function getNoOfDaysForFirstBounus($userId)
    // {
    //     $dayCount = 0;
    //     $today = Carbon::now()->format('Y-m-d H:i:s');
    //     $customer = Customer::where('user_id', $userId)->where('is_bonus_active', 1)->first();
    //     $actDate = isset($customer->bonus_active_date) ? $customer->bonus_active_date : 0;
    //     $datetime1 = strtotime($actDate);
    //     $datetime2 = strtotime($today);
    //     $dayCount = (int)(($datetime2 - $datetime1) / 86400);

    //     return $dayCount;
    // }


    // public function getBetweenDays($fromDate, $toDate)
    // {
    //     $days = 0;
    //     $datetime1 = strtotime($fromDate); // convert to timestamps
    //     $datetime2 = strtotime($toDate); // convert to timestamps
    //     $days = (int)(($datetime2 - $datetime1) / 86400);
    //     return $days;
    // }


    // public function isEligibleForNextBonus($userId, $days)
    // {
    //     $today = Carbon::now()->format('Y-m-d H:i:s');
    //     $customer = Customer::where('user_id', $userId)->where('is_bonus_active', 1)->first();
    //     $actDate = isset($customer->bonus_active_date) ? $customer->bonus_active_date : 0;
    //     $dayCount = $this->getBetweenDays($actDate, $today);
    //     if ($dayCount >= $days) {
    //         return true;
    //     }
    //     return false;
    // }
}
