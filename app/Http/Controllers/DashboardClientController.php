<?php

namespace App\Http\Controllers;

use App\Models\CustomerBonusCalculation;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data = array();
        $arr = array();
        $paymentObj = new Payment();
        $bonusObj = new CustomerBonusCalculation();

        $user = Auth::user();
        $userData = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.pay_active', 'customers_details.pay_active_date', 'customers_details.current_level', 'customers_details.pay_last_date')
            ->where("users.is_admin", 2)
            ->where("users.id", $user->id)->get()->toarray();

        $data['invidedBy'] = "My Self";
        if (isset($user->invited_by) &&  $user->invited_by != 0) {
            $invitedByUser = User::find($user->invited_by);
            $data['invidedBy'] = isset($invitedByUser->first_name) ? $invitedByUser->first_name : "";
        }

        $myTeam = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.pay_active', 'customers_details.pay_active_date', 'customers_details.current_level', 'customers_details.pay_last_date','customers_details.is_bonus_active', 'customers_details.bonus_active_date')
            // ->where("users.is_admin", 2)
            ->where("users.invited_by", $user->id);
        $arr1 = $myTeam->get()->toarray();

        foreach ($arr1 as $key => $value) {

            $arr[$key]['id'] = isset($value->id) ? $value->id : "";
            $title = isset($value->title) ? $value->title : "";

            $firstName = isset($value->first_name) ? $value->first_name : "";
            $lastName = isset($value->last_name) ? $value->last_name : "";
            $arr[$key]['name'] = $title.' '.$firstName . " " . $lastName;


            if (isset($value->created_at) && $value->created_at != "") {
                $arr[$key]['regAt'] = date("d-M-Y", strtotime($value->created_at));
            } else {
                $arr[$key]['regAt'] = "0";
            }
            $arr[$key]['phone'] = isset($value->phone) ? $value->phone : "";

            $payActive = "Inactive";
            if (isset($value->pay_active) && $value->pay_active == 1) {
                $payActive = "Active";
            }
            $arr[$key]['payActive'] = $payActive;
            $arr[$key]['gender'] = $value->gender;
        }

        $data['myTeamCount'] = $myTeam->count();
        $data['myTeam'] = $arr;

        $data['bonusFrom'] = 0;
        $data['isBonusActive'] = "Inactive";
        $data['payActive'] = "Inactive";

        if (isset($userData[0]->pay_active)) {
            if ($userData[0]->pay_active == 1) {
                $data['payActive'] = "Active";
            }
        }
        $data['payActiveFrom'] = 0;
        if (isset($userData[0]->pay_active_date) && $userData[0]->pay_active_date != "") {
            $data['payActiveFrom'] = date("M-Y", strtotime($userData[0]->pay_active_date));
        }

        $data['currentLevel'] = isset($userData[0]->current_level) ? $userData[0]->current_level : "0";

        $data['payLast'] = "0";
        if (isset($userData[0]->pay_last_date) && $userData[0]->pay_last_date != "") {
            $data['payLast'] = date("M-Y", strtotime($userData[0]->pay_last_date));
        }

        if (isset($userData[0]->is_bonus_active)) {
            if ($userData[0]->is_bonus_active == 1) {
                $data['isBonusActive'] = "Active";
            }
        }

        if (isset($userData[0]->bonus_active_date) && $userData[0]->bonus_active_date != "") {
            $data['bonusFrom'] = date("M-Y", strtotime($userData[0]->bonus_active_date));
        }

        $widraw = 0;
        $bonus = 0;
        $initialAmount = 0;
        $initialAmount = $paymentObj->getPaymentAmountByTypeUserId($user->id, 1);
        //print_r($initialAmount); exit;
        $widraw = $paymentObj->getPaymentAmountByTypeUserId($user->id, 2);
        $bonus = $bonusObj->getAllBonusByUser($user->id);

        //TODO
        $anyOtherBonus=0;
        if ($user->temp_bonus== 1) {
            $bonus=$bonus+10;
        }

        $data['totalPay'] = $initialAmount;
        $data['totalWithdraw'] = $widraw; 
        $data['totalBonus'] = $bonus ;
        $data['balanceBonus'] = $bonus - $widraw;

        return view('clients.home.dashboard', compact('data'));
    }
}
