<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Password;
use App\Models\Auditlogs;
use Carbon\Carbon;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ClientChangePasswordRequest;
use App\Models\User;
class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }

    public function index()
    {
        return view('changepassword.index');
    }

    public function update(ChangePasswordRequest $request)
    {

        $input = $request->all();
        $user_id = Auth::user()->id;
        $isAdmin = Auth::user()->is_admin;
        $newpassword = $input['user_password'];
        $confirmpassword = $input['confirm_password'];

        if ((Hash::check($newpassword, Auth::user()->password))) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New password cannot be same as your current password. Please choose a different password.");
        }

        //check if last 4 passwords are same as new password.This can be checked using password_history table
        $last4_paasswords = Password::where('user_id', $user_id)->orderBy('id', 'desc')->limit(4)->get();
        $passwords = $last4_paasswords->toArray();
        if (!empty($passwords)) {
            foreach ($passwords as $password) {
                if ((Hash::check($newpassword, $password["password"]))) {
                    return redirect()->back()->with("error", "New password cannot be same as the last four passwords used. Please choose a different password.");
                }
            }
        }
        
        $user = User::find($user_id);
        $req= array();
        $req['password'] = bcrypt($newpassword);
        $req['pwd_changed'] = 1;
        $req['password_chng_date'] = Carbon::now()->format('Y-m-d H:i:s');
        
        $updatePwd = $user->update($req);
       
        //save last edited password into password_history table
        $password = new \App\Models\Password();
        $password->user_id = $user->id;
        $password->password = bcrypt($newpassword);
        $password->save();

        $activity = 'Password change';
        $this->alog->insert_auditlogs( $activity, "user account", "user","U","",null, null,null); 

        if($isAdmin==1){
            return redirect()->route('home')->with('success', 'Password successfully changed.');
        }
        return redirect()->route('dashboard')->with('success', 'Password successfully changed.');
    }


    public function cusromerUpdate(ClientChangePasswordRequest $request)
    {

        $input = $request->all();
        $user_id = Auth::user()->id;
        $isAdmin = Auth::user()->is_admin;
        $currentPwd = $input['user_current_password'];
        $newpassword = $input['user_password'];
        $confirmpassword = $input['confirm_password'];


        if (!(Hash::check($currentPwd, Auth::user()->password))) {
            // The passwords matches
            return redirect()->action('ProfileClientController@changePwd')->with('error', "Your current password does not matches with the password you provided. Please try again.")->withInput();
            // return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }


        if ((Hash::check($newpassword, Auth::user()->password))) {
            //Current password and new password are same
            return redirect()->action('ProfileClientController@changePwd')->with('error', "New password cannot be same as your current password. Please choose a different password..")->withInput();
            // return redirect()->back()->with("error", "New password cannot be same as your current password. Please choose a different password.");
        }

        //check if last 4 passwords are same as new password.This can be checked using password_history table
        $last4_paasswords = Password::where('user_id', $user_id)->orderBy('id', 'desc')->limit(4)->get();
        $passwords = $last4_paasswords->toArray();
        if (!empty($passwords)) {
            foreach ($passwords as $password) {
                if ((Hash::check($newpassword, $password["password"]))) {
                    return redirect()->action('ProfileClientController@changePwd')->with('error', "New password cannot be same as the last four passwords used. Please choose a different password.")->withInput();
                    // return redirect()->back()->with("error", "New password cannot be same as the last four passwords used. Please choose a different password.");
                }
            }
        }
        
        $user = User::find($user_id);
        $req= array();
        $req['password'] = bcrypt($newpassword);
        $req['pwd_changed'] = 1;
        $req['password_chng_date'] = Carbon::now()->format('Y-m-d H:i:s');
        
        $updatePwd = $user->update($req);
       
        
        $password = new \App\Models\Password();
        $password->user_id = $user->id;
        $password->password = bcrypt($newpassword);
        $password->save();
        return redirect()->action('ProfileClientController@index')->with('success', 'User account password successfully updated.');
        
    }
}
