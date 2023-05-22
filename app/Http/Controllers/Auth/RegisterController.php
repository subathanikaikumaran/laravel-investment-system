<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\User;
use Spatie\Permission\Models\Role;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function show($id=null)
    {
        return view('auth.register', compact('id'));
    }



    public function store(UserRegisterRequest $request)
    {
        $input = $request->all();
        $req=array();
        $req['first_name']=$input['first_name'];
        $req['last_name']=$input['last_name'];
        $req['email']=$input['email'];
        $req['phone']=$input['phone'];
        $req['nic']=$input['nic'];
        $req['gender']=$input['gender'];
        $req['title']=$input['title'];
        $req['country']=$input['country'];
        // $req['dob']=$input['dob'];
        $req['password']= bcrypt($input['user_password']);
        $req['active']=1;
        $req['pwd_changed']=1;
        $req['is_admin']=2;
        $req['invited_by']=0; 

        if($input['id']!=""){
            $req['invited_by']=json_decode(base64_decode($input['id']), true);;
        }
        // print_r($req); exit;
        $user = User::create($req);
        if( isset($user->id)){
            $detail['user_id']=$user->id;
            $detail['current_level']=1;
            Customer::create($detail);
        }   
        
       // $user->assignRole(2);
        return redirect()->route('login')
            ->with('success', 'User successfully created.');
    }

}
