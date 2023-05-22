<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\AccountVerify;
use App\Models\Question;
use App\Models\Payment;
use App\Http\Requests\UserRegisterRequest;
use Carbon\Carbon;
use App\Http\Requests\ClientChangePasswordRequest;
use Illuminate\Support\Facades\Config;

class ProfileClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $shareUrl = "";
        $data = array();
        $arr = array();

        $baseUrl = Config::get('api-config.baseurl');

        
        $user = Auth::user();
        $id = $user->id;

        $data['shareUrl'] =$baseUrl."register/new/".base64_encode(json_encode($id));


        $userData = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.*')
            ->where("users.is_admin", 2)
            ->where("users.id", $id)->get()->toarray();

        

        $data['user'] = $user;

        if (isset($user->invited_by) &&  $user->invited_by != 0) {
            $invitedByUser = User::find($user->invited_by);
            $data['invidedBy'] = isset($invitedByUser->first_name) ? $invitedByUser->first_name : "";
        } else {
            $data['invidedBy'] = "My Self";
        }
        $data['gender'] = "-";
        switch ($user->gender) {
            case '1':
                $data['gender'] = "Female";
                break;
            case '2':
                $data['gender'] = "Male";
                break;

            default:
                $data['gender'] = "-";
                break;
        }
        $myTeam = User::where('invited_by', '=', $user->id);
        $arr1 = $myTeam->get()->toarray();

        // foreach ($arr1 as $key => $value) {
        //     $arr[$key]['id'] = isset($value['id']) ? $value['id'] : "";
        //     $firstName = isset($value['first_name']) ? $value['first_name'] : "";
        //     $lastName = isset($value['last_name']) ? $value['last_name'] : "";
        //     $arr[$key]['name'] = $firstName . " " . $lastName;

        //     if (isset($value['created_at']) && $value['created_at'] != "") {
        //         $arr[$key]['regAt'] = date("d-M-Y", strtotime($value['created_at']));
        //     } else {
        //         $arr[$key]['regAt'] = "0";
        //     }
        //     $arr[$key]['phone'] = isset($value['phone']) ? $value['phone'] : "";

        //     $payActive = "Inactive";
        //     if (isset($value['pay_active']) && $value['pay_active'] == 1) {
        //         $payActive = "Active";
        //     }
        //     $arr[$key]['payActive'] = $payActive;
        //     $arr[$key]['gender'] = $value['gender'];
        // }

        $data['myTeamCount'] = $myTeam->count();
        $data['myTeam'] = $arr;
        $data['payActive'] = "Inactive";
        $data['active'] = "Inactive";
        $data['currency'] = "USD";

        if (isset($user->active)) {
            if ($user->active == 1) {
                $data['active'] = "Active";
            }
        }
        if (isset($userData[0]->pay_active)) {
            if ($userData[0]->pay_active == 1) {
                $data['payActive'] = "Active";
            }
        }
        $data['payActiveFrom'] = "0";
        if (isset($userData[0]->pay_active_date) && $userData[0]->pay_active_date != "") {
            $data['payActiveFrom'] = date("d-M-Y", strtotime($userData[0]->pay_active_date));
        }


        $data['currentLevel'] = isset($userData[0]->current_level) ? $userData[0]->current_level : "0";

        $data['payLast'] = "0";
        if (isset($userData[0]->pay_last_date) && $userData[0]->pay_last_date != "") {
            $data['payLast'] = date("d-M-Y", strtotime($userData[0]->pay_last_date));
        }

        $data['isBonusActive'] = "Inactive";
            if (isset($userData[0]->is_bonus_active)) {
                if ($userData[0]->is_bonus_active == 1) {
                    $data['isBonusActive'] = "Active";
                }
            }
            $data['bonusFrom'] ="0";
            if (isset($userData[0]->bonus_active_date) && $userData[0]->bonus_active_date != "") {
                $data['bonusFrom'] = date("d-M-Y", strtotime($userData[0]->bonus_active_date));
            }
        return view('clients.profiles.index', compact('user', 'data'));
    }




    public function edit()
    {
        $user = Auth::user();
        return view('clients.profiles.edit', compact('user'));
    }

    public function update(UserRegisterRequest $request)
    {
        $authUser = Auth::user();
        $input = $request->all();

        $req = array();

        $req['first_name'] = $input['first_name'];
        $req['last_name'] = $input['last_name'];
        // $req['email'] = $input['email'];
        $req['phone'] = $input['phone'];
        $req['gender'] = $input['gender'];
        $req['title']=$input['title'];
        $req['dob'] = $input['dob'];
        $req['nic'] = $input['nic'];

        $req['address_street_1'] = $input['address_street_1'];
        $req['address_street_2'] = $input['address_street_2'];
        $req['city'] = $input['city'];
        $req['province'] = $input['province'];
        $req['country'] = $input['country'];
        $req['postalcode'] = $input['postalcode'];

        $user = User::find($authUser->id);
        $addUser = $user->update($req);

        if ($addUser) {
            return redirect()->action('ProfileClientController@index')->with('success', 'Personal details successfully updated.');
        } else {
            return redirect()->action('ProfileClientController@edit')->with('error', "Invalid Request.")->withInput();
        }
    }



    public function changePwd()
    {
        return view('clients.profiles.changepwd');
    }




    public function updateCustomerPassword(ClientChangePasswordRequest $request)
    {
        $authUser = Auth::user();
        $currentPwd = $authUser->password;
        //print_r($currentPwd ); exit;
        $input = $request->all();
        $req = array();
        $id = $authUser->id;
        if ($id == "" || $id == "") {
            return redirect()->action('ProfileClientController@index')->with('error', "Invalid Request.")->withInput();
        }
        $userCurrentPassword = bcrypt($input['user_current_password']);
        // echo $currentPwd;
        // echo '<br/>';
        // echo $userCurrentPassword;
        // echo '<br/>';
        // echo bcrypt('test123');
        // exit;
        $req['password'] = bcrypt($input['user_password']);
        $req['pwd_changed'] = 1;
        $req['password_chng_date'] = Carbon::now()->format('Y-m-d H:i:s');

        if ($userCurrentPassword != $currentPwd) {
            return redirect()->action('ProfileClientController@changePwd')->with('error', "Invalid Current Password.")->withInput();
        }
        $user = User::find($id);
        $addUser = $user->update($req);
        if ($addUser) {
            return redirect()->action('ProfileClientController@index')->with('success', 'User account password successfully updated.');
        } else {
            return redirect()->action('ProfileClientController@changePwd')->with('error', "Invalid Request.")->withInput();
        }
    }
}
