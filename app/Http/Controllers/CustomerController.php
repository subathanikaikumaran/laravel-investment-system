<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Payment;
use App\Models\AccountVerify;
use App\Models\Bonus;
use App\Models\Question;
use Carbon\Carbon;
use DB;
use App\Models\Auditlogs;
use App\Models\Customer;
use Auth;




class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }


    public function index(Request $request)
    {
        $search_value = ($request->input('search_value')) ? $request->input('search_value') : "";
        $active_status = ($request->input('active_status')) ? $request->input('active_status') : 0;
        $pay_status = ($request->input('pay_status')) ? $request->input('pay_status') : 0;
        return view('customers.index', compact('search_value', 'active_status', 'pay_status'));
    }




    public function create()
    {
        return view('customers.add');
    }



    public function edit($id)
    {
        $user = User::find($id);
        return view('customers.edit', compact('user'));
    }



    public function changePwd($id)
    {
        return view('customers.changepwd', compact('id'));
    }





    public function view($id)
    {
        $questions = [];
        $qArr = [];
        $answers = [];
        if ($this->isThisCustomer($id)) {

            $que = Question::get();
            if (isset($que)) {
                foreach ($que as $ques) {
                    $qArr['id'] = isset($ques->id) ? $ques->id : "";
                    $qArr['name'] = isset($ques->name) ? $ques->name : "";
                    $qArr['description'] = isset($ques->description) ? $ques->description : "";
                    $questions[] = $qArr;
                }
            }

            $accountVerify = new AccountVerify();
            $answers = $accountVerify->letsVerifyTheUserAccount($id);


            $paymet = new Payment();
            $mypayment = $paymet->getMyWallet($id);
            // print_r($mypayment); exit;

            // $bonus= new Bonus();
            // $mypayment= $bonus->checkBonus($id,1);



            $user = User::find($id);

            $data = array();
            $arr = array();

            $data['bank'] = [];
            $data['user'] = $user;
            $data['invidedBy'] = "My Self";
            if (isset($user->invited_by) &&  $user->invited_by != 0) {
                $invitedByUser = User::find($user->invited_by);
                $data['invidedBy'] = isset($invitedByUser->first_name) ? $invitedByUser->first_name : "";
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
            // $myTeam = User::where('invited_by', '=', $user->id);
            // $arr1 = $myTeam->get()->toarray();

            $myTeam = DB::table('users')
                ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
                ->select('users.*', 'customers_details.pay_active', 'customers_details.pay_active_date', 'customers_details.current_level', 'customers_details.pay_last_date', 'customers_details.is_bonus_active', 'customers_details.bonus_active_date')
                ->where("users.is_admin", 2)
                ->where("users.invited_by", $user->id);

            $arr1 = $myTeam->get()->toarray();


            foreach ($arr1 as $key => $value) {
                $arr[$key]['id'] = isset($value->id) ? $value->id : "";
                $title = isset($value->title) ? $value->title : "";

                $firstName = isset($value->first_name) ? $value->first_name : "";
                $lastName = isset($value->last_name) ? $value->last_name : "";
                $arr[$key]['name'] = $title . ' ' . $firstName . " " . $lastName;

                if (isset($value->created_at) && $value->created_at != "" && $value->created_at != 0) {
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
            $data['totalPay'] = 0;
            $data['totalWithdraw'] = 0;
            $data['payActive'] = "Inactive";
            $data['active'] = "Inactive";
            $data['currency'] = "USD"; // TODO




            if (isset($user->active)) {
                if ($user->active == 1) {
                    $data['active'] = "Active";
                }
            }
            /***** Customer details ***/
            $customer = Customer::where('user_id', $id)->first();
            // print_r( $customer->pay_active) ; exit;
            if (isset($customer->pay_active)) {
                if ($customer->pay_active == 1) {
                    $data['payActive'] = "Active";
                }
            }
            $data['payActiveFrom'] = $customer->pay_active_date;
            if (isset($customer->pay_active_date) && $customer->pay_active_date != "" && $customer->pay_active_date != 0) {
                $data['payActiveFrom'] = date("d-M-Y", strtotime($customer->pay_active_date));
            }

            $data['currentLevel'] = isset($customer->current_level) ? $customer->current_level : "0";

            $data['payLast'] = "0";
            if (isset($customer->pay_last_date) && $customer->pay_last_date != "" && $customer->pay_last_date != 0) {
                $data['payLast'] = date("d-M-Y", strtotime($customer->pay_last_date));
            }
            $data['isBonusActive'] = "Inactive";
            if (isset($customer->is_bonus_active)) {
                if ($customer->is_bonus_active == 1) {
                    $data['isBonusActive'] = "Active";
                }
            }
            $data['bonusFrom'] = "0";
            if (isset($customer->bonus_active_date) && $customer->bonus_active_date != "") {
                $data['bonusFrom'] = date("d-M-Y", strtotime($customer->bonus_active_date));
            }
        }



        return view('customers.view', compact('user', 'data', 'mypayment', 'id', 'questions', 'answers'));
    }



    public function store(CustomerRequest $request)
    {
        $authUser = Auth::user();
        $input = $request->all();

        $req = array();
        $req['first_name'] = $input['first_name'];
        $req['last_name'] = $input['last_name'];
        $req['email'] = $input['email'];
        $req['phone'] = $input['phone'];
        $req['gender'] = $input['gender'];
        $req['title'] = $input['title'];
        $req['dob'] = $input['dob'];
        $req['nic'] = $input['nic'];
        $req['invited_by'] = $authUser->id;
        $req['address_street_1'] = $input['address_street_1'];
        $req['address_street_2'] = $input['address_street_2'];
        $req['city'] = $input['city'];
        $req['province'] = $input['province'];
        $req['country'] = $input['country'];
        $req['postalcode'] = $input['postalcode'];

        $req['password'] = bcrypt($input['user_password']);
        $req['active'] = 1;
        $req['is_admin'] = 2;
        $user = User::create($req);

        if (isset($user->id)) {
            $detail['user_id'] = $user->id;
            $detail['current_level'] = 1;
            Customer::create($detail);
        }

        //$user->assignRole(2);
        if ($user) {
            $activity = "Customer details added - " . $input['email'];
            $this->alog->insert_auditlogs($activity, "Customer", "User", "A", "", null, null, null);
            return redirect()->action('CustomerController@index')->with('success', 'Customer details successfully added.');
        } else {
            return redirect()->action('CustomerController@create')->with('error', "Invalid Request.")->withInput();
        }
    }




    public function update(CustomerRequest $request)
    {
        $input = $request->all();

        $req = array();
        $id = $input['id'];
        $req['first_name'] = $input['first_name'];
        $req['last_name'] = $input['last_name'];
        $req['email'] = $input['email'];
        $req['phone'] = $input['phone'];
        $req['gender'] = $input['gender'];
        $req['title'] = $input['title'];
        $req['dob'] = $input['dob'];
        $req['nic'] = $input['nic'];

        $req['address_street_1'] = $input['address_street_1'];
        $req['address_street_2'] = $input['address_street_2'];
        $req['city'] = $input['city'];
        $req['province'] = $input['province'];
        $req['country'] = $input['country'];
        $req['postalcode'] = $input['postalcode'];

        $req['active'] = $input['active'];

        $user = User::find($id);
        $addUser = $user->update($req);
        if ($addUser) {
            $activity = "Customer details updated - " . $id;
            $this->alog->insert_auditlogs($activity, "Customer", "User", "U", "", null, null, null);
            return redirect()->action('CustomerController@index')->with('success', 'Customer details successfully updated.');
        } else {
            return redirect()->action('CustomerController@edit', $id)->with('error', "Invalid Request.")->withInput();
        }
    }



    public function updateCustomerPassword(ChangePasswordRequest $request)
    {
        $input = $request->all();
        $req = array();
        $id = $input['id'];
        if ($id == "" || $id == "") {
            return redirect()->action('CustomerController@index')->with('error', "Invalid Request.")->withInput();
        }
        $req['password'] = bcrypt($input['user_password']);
        $req['pwd_changed'] = 0;
        $req['password_chng_date'] = Carbon::now()->format('Y-m-d H:i:s');

        $user = User::find($id);
        $addUser = $user->update($req);
        if ($addUser) {
            $activity = "Customer password changed - " . $id;
            $this->alog->insert_auditlogs($activity, "Customer", "User", "U", "", null, null, null);
            return redirect()->action('CustomerController@view', $id)->with('success', 'Customer account password successfully updated.');
        } else {
            return redirect()->action('CustomerController@changePwd', $id)->with('error', "Invalid Request.")->withInput();
        }
    }




    public function allClientUserList(Request $request)
    {
        $txtsearch = ($request->input('search_value')) ? $request->input('search_value') : "";
        $payStatus = ($request->input('pay_status')) ? $request->input('pay_status') : 0;
        $activeStatus = ($request->input('active_status')) ? $request->input('active_status') : 0;

        // $req = User::where("is_admin", 2)
        //     ->orderBy('id', 'DESC');
        $req = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.active', 'customers_details.pay_active')
            ->where("users.is_admin", 2)
            ->orderBy('users.id', 'DESC');

        if (isset($txtsearch) && $txtsearch != "" && is_numeric($txtsearch)) {
            $req->where('users.id', $txtsearch);
            $txtsearch = "";
        }
        return Datatables::of($req)->addIndexColumn()
            ->filter(function ($query) use ($request, $payStatus, $txtsearch, $activeStatus) {
                if (isset($payStatus) && $payStatus != "0") {
                    if ($payStatus == 2) {
                        $query->where('pay_active', 0);
                    } else {
                        $query->where('pay_active', $payStatus);
                    }
                }
                if (isset($activeStatus) && $activeStatus != "0") {
                    if ($activeStatus == 2) {
                        $query->where('active', 0);
                    } else {
                        $query->where('active', $activeStatus);
                    }
                }
                if (isset($txtsearch) && $txtsearch != "") {
                    $query->where('first_name', 'like', "%{$txtsearch}%")
                        ->orwhere('last_name', 'like', "%{$txtsearch}%");
                }
            })
            ->editColumn('active_status', function ($req) {
                $active_status = "";
                if ($req->active == 1) {
                    $active_status = '<span class="label label-success">Active</span>';
                } else if ($req->active == 0) {
                    $active_status = '<span class="label label-danger">Inactive</span>';
                }
                return $active_status;
            })
            ->editColumn('pay_status', function ($req) {
                $pay_status = "";
                if ($req->pay_active == 1) {
                    $pay_status = '<span class="label label-success">Active</span>';
                } else if ($req->pay_active == 0) {
                    $pay_status = '<span class="label label-danger">Inactive</span>';
                }
                return $pay_status;
            })
            ->addColumn('team', function ($req) {
                $team = 0;
                $myTeam = DB::table('users')->where("users.is_admin", 2)
                    ->where("users.invited_by", $req->id);
                $team = $myTeam->count();
                return $team;
            })

            ->addColumn('action', function ($req) {
                $action = '';
                $action .= '<a data-toggle="tooltip" title="Customer Edit" href="client-user/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                $action .= '<a data-toggle="tooltip" title="Customer View" href="client-user/view/' .  $req->id . '"><i class="icofont icofont-sub-listing"></i></a>';
                return $action;
            })

            ->rawColumns(['active_status', 'pay_status', 'action', 'team'])->make(true);
    }


    //
    public function setTempDiscount($id)
    {
        $userCount = 0;
        $userCount = User::where('id', '=', $id)->where('temp_bonus', '=', 0)->count();
        if ($userCount != "" && $userCount != 0) {
            return view('customers.tempdiscount', compact('id'));
        } else {
            return redirect()->action('CustomerController@view', $id)->with('error', 'Already added Other Bonus.'); 
        }
        
    }
    public function setTempDiscountStore(Request $request)
    {

        $input = $request->all();
        $req = array();
        $id = $input['id'];
        $customerBouns = User::where('id', $id)->update(
            [
                'temp_bonus' => 1
            ]
        );
        if ($customerBouns) {
            $activity = "Temp Discount added - " . $id;
            $this->alog->insert_auditlogs($activity, "Customer", "User", "U", "", null, null, null);
            return redirect()->action('CustomerController@view', $id)->with('success', 'Other Bonus Added.');
        } else {
            return redirect()->action('CustomerController@setTempDiscount', $id)->with('error', "Invalid Request.")->withInput();
        }
    }


    private function isThisCustomer($userId)
    {
        $userCount = 0;
        $userCount = User::where('id', '=', $userId)->where('is_admin', '=', 2)->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
    }
}
