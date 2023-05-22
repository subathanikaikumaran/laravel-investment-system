<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use DateTime;
use App\Models\Auditlogs;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        define("LOGIN_ATTEMPTS",6);
        $this->middleware('guest')->except('logout');
        $this->alog=new Auditlogs();
    }

    public function login(Request $request){
        $username=$request->email;
        $password=$request->password;
        $password_first = substr($password, 0, 1);

        if ($password == "" && $username == ""  ) {
            return redirect('login')->withErrors(['field' => 'Enter an email and password.']);
        }

        if ($password != "" && $username == ""  ) {
            return redirect('login')->withErrors(['field' => 'Enter an email.']);
        }

        if ($password == "" && $username != ""  ) {
            return redirect('login')->withErrors(['field' => 'Enter a password.']);
        }

        if(!$this->isValidEmail($username)) {
            return redirect('login')->withErrors(['field' => 'Invalid user credentials.']);// Invalid username.
        }

        if ($password_first == " ") {
            return redirect('login')->withErrors(['field' => 'Invalid user credentials.']);
        }

        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $login=false;
        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt(['email' => $username, 'password' => $password,'active' => 1])) {
                $login=true;
            }
        }
        if ($login) {
            $userData = User::where(['email' => $username])->get()->toArray();
            /*** to check whether this user already login or not ***/
            // if((time()-$userData[0]['LoggedInLiveTime']) <= 3 ){
            //     $this->guard()->logout();
            //     return redirect('login')->withErrors(['field' => 'User already logged in.']);
            //     exit;
            // }
            /*** login attemps reset ***/
            $this->resetLoginattempts($username);

            /*** check whether user has changed the password ***/
            $pwdchange=$this->checkPwdChangedStatus($username);
            
            if($pwdchange){ 
                return redirect('/changepwd');
            } else {
               
               if(isset($userData[0]['is_admin']) && $userData[0]['is_admin']==1){
                $activity="User login - username : ". $username;
                $this->alog->insert_audit_log("", $activity, "login",$username,"user",
                "S",$userData[0]['id'],null, null,null);
                  return redirect()->intended(route('home'));
               } 
               else {
                if(isset($userData[0]['account_verify']) && $userData[0]['account_verify']==0){                   
                    return redirect()->intended(route('account-verify')); 
                }else {                   
                   return redirect()->intended(route('dashboard')); 
                }
                 
               }
                
            }
        }else{
            /** Login Failed */
            $login_attempts = User::where(['email' => $username])->get()->toArray();     
            if($login_attempts){
                $result_attempts =$this->updateLoginattempts($username,$login_attempts[0]["loginattempts"]);
                
                if($result_attempts){
                    $get_loginattempts=$this->get_loginattempts($username);
                    if ($get_loginattempts >= LOGIN_ATTEMPTS) {
                        $this->setActiveZero($username);
                        return redirect('login')->withErrors(['field' => 'Your account has been blocked.Please contact admin.']);
                        exit;
                    }
                } else {
                    return redirect('login')->withErrors(['field' => 'Some error occurred']);
                    exit;
                }
                /*** check login attempts **/
                if (count($login_attempts)) {
                    $this->updateLoginattempts($username,$login_attempts[0]["loginattempts"]);
                    if ($login_attempts[0]["loginattempts"] >= LOGIN_ATTEMPTS) {
                        $this->setActiveZero($username);
                        return redirect('login')->withErrors(['field' => 'Your account has been blocked.Please contact admin.']);
                        exit;
                    }
                }

                /*** Your account has been deactivated ***/
                if($login_attempts[0]["active"]==0){
                  return redirect('login')->withErrors(['field' => 'Your account has been deactivated.']);
                  exit;
                }               
                return redirect('login')->withErrors(['field' => 'Invalid user credentials.']);
            } else{
                return redirect('login')->withErrors(['field' => 'Invalid user credentials.']);
            }

        }
    }



    public function logout(Request $request) {
        $userdata = Auth::user();
        $this->guard()->logout();        
        return redirect('/login');
    }








    public function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) 
        && preg_match('/@.+\./', $email);
    }

    private function updateLoginattempts($email,$count){
      $update = User::where(['email' => $email])->update(['loginattempts' => ($count + 1)]);
      if($update){
          return true;
      }else{
          return false;
      }
    }

    private function setActiveZero($email){
        return User::where(['email' => $email])->update(['active' => 0]);
    }

    private function resetLoginattempts($email){
        $update= User::where(['email' => $email])->update(['loginattempts' => 0]); 
        if($update){ return true;
        }else{return false;
        }
    }

  private function get_loginattempts($email){
    $count=0;
    $login_attempts = User::where(['email' => $email])->get()->toArray();
    if ($login_attempts) {
      $count =$login_attempts[0]["loginattempts"];
    }
    return $count;
  }


  private function checkPwdChangedStatus($email){    
    $date = Carbon::now()->format('Y-m-d');
    $pwdChangeDate = Carbon::createFromFormat('Y-m-d H:i:s', User::where(['email' => $email])->first()->password_chng_date)->format('Y-m-d');
    $date1 = new DateTime($date);
    $date2 = new DateTime($pwdChangeDate);
    $date3 = $date1->diff($date2)->days;

    if(90 < $date3){
      User::where(['email' => $email])->update(['pwd_changed' => 0]);
      return true;
    }else{
        $val= User::where(['email' => $email])->first()->pwd_changed;
        if($val!=1) {
            return true;
        }        
      return false;
    }
  }
  




}
