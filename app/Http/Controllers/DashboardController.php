<?php

namespace App\Http\Controllers;

use App\Models\CustomerBonusCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Payment;
use DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        date_default_timezone_set('Asia/Colombo');
        $currentMonth  = date('m');
        $currentYear  = date('Y');
        $today = date('Y-m-d');
        $currency = 2;

        $paymentObj = new Payment();
        $bonusCalculation = new CustomerBonusCalculation();


        $team = $this->getTeamCount();
        $individual = $this->getIndividualCount();

        $user = $this->getUsers();
        $userStatus = $this->getUsersByStatus($currency);
        $payment = $this->getcurrentmounthUser($currentMonth, $currentYear, $currency);

        $income = $this->getPayment(1, $currency);
        $outcome = $this->getPayment(2, $currency);
        $totalWithdraw = $paymentObj->getWithdrawPayment();
        $totalBonus = $bonusCalculation->getAllBonus();


        $userCurrentMonth = $this->getcurrentmounthUser($currentMonth, $currentYear, $currency);

        $dailyIncomePayment = $this->getDailyPayment($today, 1, $currency);
        $dailyOutcomePayment = $this->getDailyPayment($today, 2, $currency);

        $monthlyIncomePayment = $this->getMonthlyPayment($currentMonth, $currentYear, 1, $currency);
        $monthlyOutcomePayment = $this->getMonthlyPayment($currentMonth, $currentYear, 2, $currency);

        $yearlyIncomePayment = $this->getYearlyPayment($currentYear, 1, $currency);
        $yearlyOutcomePayment = $this->getYearlyPayment($currentYear, 2, $currency);


        return view('home.dashboard', compact(
            'team',
            'individual',
            'currency',
            'user',
            'payment',
            'totalWithdraw',
            'totalBonus',
            'income',
            'outcome',
            'userStatus',
            'userCurrentMonth',
            'dailyIncomePayment',
            'dailyOutcomePayment',
            'monthlyIncomePayment',
            'monthlyOutcomePayment',
            'yearlyIncomePayment',
            'yearlyOutcomePayment'
        ));
    }


    public function getUsers()
    {
        $tActive = 0;
        $tInactive = 0;
        $tPayInactive = 0;
        $tPayActive = 0;
        $tUsers = 0;
        $userData = array();
        $userStatus = array();
        // $users = User::where('is_admin', '=', 2);
        // $userData = $users->get()->toarray();

        $userData = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.*')
            ->where("users.is_admin", 2)
            ->get()->toarray();


        foreach ($userData as $key => $value) {
            $tUsers = $tUsers + 1;
            if (isset($value->active)) {
                if ($value->active == 1) {
                    $tActive =  $tActive + 1;
                } else {
                    $tInactive = $tInactive + 1;
                }
            }
            if (isset($value->pay_active)) {
                if ($value->pay_active == 1) {
                    $tPayActive =  $tPayActive + 1;
                } else {
                    $tPayInactive = $tPayInactive + 1;
                }
            }
        }
        $userStatus['totalUser'] = $tUsers;
        $userStatus['totalActive'] = $tActive;
        $userStatus['totalInActive'] = $tInactive;
        $userStatus['totalPayActive'] = $tPayActive;
        $userStatus['totalPayInActive'] = $tPayInactive;
        return $userStatus;
    }



    public function getTeamCount()
    {
        $user = DB::table('users')->where('is_admin', '=', 2)
            ->where('invited_by', '<>', 0)->distinct('invited_by')->count('invited_by');
        return $user;
    }

    public function getIndividualCount()
    {
        $user = DB::table('users')->where('is_admin', '=', 2)
            ->where('invited_by', '=', 0)->count('invited_by');
        return $user;
    }





    public function getPayment($type, $currency)
    {
        $payment = array();
        $paymentArr = array();
        $arrValue = DB::table('payments')
            ->select(DB::raw('sum(amount) as totalAmount, count(id) as totalCount'))
            ->where('type', '=', $type)
            // ->where('currency', '=', $currency)
            ->get()->toarray();

        $paymentArr = json_decode(json_encode($arrValue), true);
        $payment['totalAmount'] = isset($paymentArr[0]['totalAmount']) ? $paymentArr[0]['totalAmount'] : 0;
        $payment['totalCount'] = isset($paymentArr[0]['totalCount']) ? $paymentArr[0]['totalCount'] : 0;
        return $payment;
    }

    public function getUsersByStatus($currency)
    {
        $tActive = 0;
        $tInactive = 0;
        $tPayInactive = 0;
        $tPayActive = 0;
        $tUsers = 0;
        $userData = array();
        $userStatus = array();
        // $users = User::where('is_admin', '=', 2); //->where('currency', '=', $currency);
        // $userData = $users->get()->toarray();

        $userData = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.*')
            ->where("users.is_admin", 2)
            ->get()->toarray();

        foreach ($userData as $key => $value) {
            $tUsers = $tUsers + 1;

            if (isset($value->active)) {
                if ($value->active == 1) {
                    $tActive =  $tActive + 1;
                } else {
                    $tInactive = $tInactive + 1;
                }
            }
            if (isset($value->pay_active)) {
                if ($value->pay_active == 1) {
                    $tPayActive =  $tPayActive + 1;
                } else {
                    $tPayInactive = $tPayInactive + 1;
                }
            }
        }
        $userStatus['totalUser'] = $tUsers;
        $userStatus['totalActive'] = $tActive;
        $userStatus['totalInActive'] = $tInactive;
        $userStatus['totalPayActive'] = $tPayActive;
        $userStatus['totalPayInActive'] = $tPayInactive;
        return $userStatus;
    }



    public function getcurrentmounthUser($currentMonth, $currentYear, $currency)
    {
        $cmNewUser = 0;
        $cmActiveUser = 0;
        $cmInActiveUser = 0;
        $cmPayActiveUser = 0;
        $cmPayInActiveUser = 0;

        $userData = array();
        $userCurrentMonth = array();
        // $users = User::where('is_admin', '=', 2)
        //     //->where('currency', '=', $currency)
        //     ->whereMonth('created_at',  $currentMonth)
        //     ->whereYear('created_at',  $currentYear);
        // $userData = $users->get()->toarray();

        $userData = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.*')
            ->where("users.is_admin", 2)
            ->whereMonth('users.created_at',  $currentMonth)
            ->whereYear('users.created_at',  $currentYear)
            ->get()->toarray();

        foreach ($userData as $key => $value) {
            $cmNewUser = $cmNewUser + 1;
            if (isset($value->active)) {
                if ($value->active == 1) {
                    $cmActiveUser = $cmActiveUser + 1;
                } else {
                    $cmInActiveUser = $cmInActiveUser + 1;
                }
            }
            if (isset($value->pay_active)) {
                if ($value->pay_active == 1) {
                    $cmPayActiveUser = $cmPayActiveUser + 1;
                } else {
                    $cmPayInActiveUser = $cmPayInActiveUser + 1;
                }
            }
        }
        $userCurrentMonth['cmNewUser'] = $cmNewUser;
        $userCurrentMonth['cmActiveUser'] = $cmActiveUser;
        $userCurrentMonth['cmInActiveUser'] = $cmInActiveUser;
        $userCurrentMonth['cmPayActiveUser'] = $cmPayActiveUser;
        $userCurrentMonth['cmPayInActiveUser'] = $cmPayInActiveUser;

        return $userCurrentMonth;
    }





    public function getDailyPayment($today, $type, $currency)
    {
        $payment = array();
        $paymentArr = array();
        $arrValue = DB::table('payments')
            ->select(DB::raw('sum(amount) as totalAmount, count(id) as totalCount'))
            ->where('type', '=', $type)
            // ->where('currency', '=', $currency)
            ->whereDate('date', '=', $today)
            ->get()->toarray();

        $paymentArr = json_decode(json_encode($arrValue), true);
        $payment['totalAmount'] = isset($paymentArr[0]['totalAmount']) ? $paymentArr[0]['totalAmount'] : 0;
        $payment['totalCount'] = isset($paymentArr[0]['totalCount']) ? $paymentArr[0]['totalCount'] : 0;
        return $payment;
    }



    public function getMonthlyPayment($currentMonth, $currentYear, $type, $currency)
    {
        $payment = array();
        $paymentArr = array();
        $arrValue = DB::table('payments')
            ->select(DB::raw('sum(amount) as totalAmount, count(id) as totalCount'))
            ->where('type', '=', $type)
            //->where('currency', '=', $currency)
            ->whereMonth('date',  $currentMonth)
            ->whereYear('date',  $currentYear)
            ->get()->toarray();

        $paymentArr = json_decode(json_encode($arrValue), true);

        $payment['totalAmount'] = isset($paymentArr[0]['totalAmount']) ? $paymentArr[0]['totalAmount'] : 0;
        $payment['totalCount'] = isset($paymentArr[0]['totalCount']) ? $paymentArr[0]['totalCount'] : 0;
        return $payment;
    }


    public function getYearlyPayment($currentYear, $type, $currency)
    {
        $payment = array();
        $paymentArr = array();
        $arrValue = DB::table('payments')
            ->select(DB::raw('sum(amount) as totalAmount, count(id) as totalCount'))
            ->where('type', '=', $type)
            //->where('currency', '=', $currency)
            ->whereYear('date',  $currentYear)
            ->get()->toarray();

        $paymentArr = json_decode(json_encode($arrValue), true);

        $payment['totalAmount'] = isset($paymentArr[0]['totalAmount']) ? $paymentArr[0]['totalAmount'] : 0;
        $payment['totalCount'] = isset($paymentArr[0]['totalCount']) ? $paymentArr[0]['totalCount'] : 0;
        return $payment;
    }


    // public function getYearlyPayment($currentYear)
    // {
    //     $payment = array();
    //     $paymentArr = array();
    //     $arrValue = DB::table('payments')
    //         ->select(DB::raw('sum(amount) as totalAmount, count(id) as totalCount, type,currency'))
    //         // ->where('type', '=', $type)
    //         ->whereYear('date',  $currentYear)
    //         ->groupBy('type', 'currency')
    //         ->get()->toarray();

    //     $paymentArr = json_decode(json_encode($arrValue), true);
    //     foreach ($paymentArr as $key => $value) {
    //         if (isset($value['type']) && isset($value['currency'])) {
    //             if ($value['type'] == 1 && $value['currency'] == 1) { // income lkr
    //                 $payment['inTotalAmountLkr'] = isset($value['totalAmount']) ? $value['totalAmount'] : 0;
    //                 $payment['inTotalCountLkr'] = isset($value['totalCount']) ? $value['totalCount'] : 0;
    //             } 
    //             else if ($value['type'] == 1 && $value['currency'] == 2) { // income usd
    //                 $payment['inTotalAmountUsd'] = isset($value['totalAmount']) ? $value['totalAmount'] : 0;
    //                 $payment['inTotalCountUsd'] = isset($value['totalCount']) ? $value['totalCount'] : 0;
    //             } 

    //             else if ($value['type'] == 2 && $value['currency'] == 1) { // outcome lkr
    //                 $payment['outTotalAmountLkr'] = isset($value['totalAmount']) ? $value['totalAmount'] : 0;
    //                 $payment['outTotalCountLkr'] = isset($value['totalCount']) ? $value['totalCount'] : 0;
    //             } 
    //             else if ($value['type'] == 2 && $value['currency'] == 2) { // outcome usd
    //                 $payment['outTotalAmountUsd'] = isset($value['totalAmount']) ? $value['totalAmount'] : 0;
    //                 $payment['outTotalCountUsd'] = isset($value['totalCount']) ? $value['totalCount'] : 0;
    //             }
    //         }
    //     }        
    //     return $payment;
    // }
}
