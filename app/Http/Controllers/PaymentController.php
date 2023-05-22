<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Auditlogs;
use App\Models\BonusCategory;
use App\Models\Customer;
use App\Models\CustomerBonus;
use DB;
use App\Models\Withdraw;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }


    public function indexDeposit(Request $request, $id = null)
    {
        $search_value = ($request->input('search_value')) ? $request->input('search_value') : "";
        $fdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $tdate = ($request->input('tdate')) ? $request->input('tdate') : 0;

        return view('finances.deposit.index', compact('search_value', 'fdate', 'tdate', 'id'));
    }





    public function createDeposit()
    {
        return view('finances.deposit.add');
    }


    public function createInitialDeposit($id = null)
    {

        $isInitial = 1;
        $bonusCount = 0;
        $bonus = BonusCategory::all();
        $bonusCount = $bonus->count();
        if ($bonusCount == 0) {
            if ($id != null) {
                return redirect()->action('CustomerController@view', $id)->with('error', "The System have not any bonus details. Please create the bonus details and try again.");
            } else {
                return redirect()->action('PaymentController@indexDeposit')->with('error', "The System have not any bonus details. Please create the bonus details and try again.");
            }
        }
        return view('finances.deposit.add', compact('isInitial', 'bonus', 'id'));
    }




    public function createCustomerDeposit($id = null)
    {
        if ($id != null) {
            $paymentObj = new Payment();
            $isNotEligible = $paymentObj->isNotEligibleForSecondPayment($id);
            if ($isNotEligible) {
                return redirect()->action('CustomerController@view', $id)->with('error', "This User have not pay initial payment. Please add initial payment.");
            }
        }
        return view('finances.deposit.add', compact('id'));
    }




    public function editDeposit($id)
    {
        $payment = Payment::find($id);
        $bonus = BonusCategory::all();

        $customerBonus = CustomerBonus::where('user_id', $payment->user_id)->first();
        $bonusType = isset($customerBonus->bonus_type) ? $customerBonus->bonus_type : 0;
        //print_r($customerBonus->bonus_type); exit;
        return view('finances.deposit.edit', compact('payment', 'bonus', 'bonusType'));
    }





    public function storeDeposit(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();

        $isSubdir = isset($input['isSubdir']) ? $input['isSubdir'] : 0;
        $isInitial = isset($input['initial']) ? $input['initial'] : 0;


        $req = array();
        if (!$this->isValidUserId($input['user_id'])) {
            if ($isInitial == 1) {
                return redirect()->action('PaymentController@createInitialDeposit')->with('error', "Unregisterd user ID.")->withInput();
            }
            return redirect()->action('PaymentController@createDeposit')->with('error', "Unregisterd user ID.")->withInput();
        }
        if (!$this->isThisCustomer($input['user_id'])) {
            if ($isInitial == 1) {
                return redirect()->action('PaymentController@createInitialDeposit')->with('error', "Unregisterd user ID.")->withInput();
            }
            return redirect()->action('PaymentController@createDeposit')->with('error', "Unregisterd user ID.")->withInput();
        }

        $req['user_id'] = $input['user_id'];
        $req['user_by'] = $user->id;
        $req['amount'] = $input['amount'];
        $req['description'] = $input['description'];
        // $req['currency']  = $input['currency'];
        if ($input['date'] == "" || $input['date'] == 0) {
            date_default_timezone_set('Asia/Colombo');
            $req['date']  = date('Y-m-d');
        } else {
            $req['date']  = $input['date'];
        }
        $req['type']  = 1;


        if ($isInitial == 1) {
            $req['is_initial']  = 1;

            $requestBonus['user_id'] = $input['user_id'];
            $requestBonus['bonus_type'] = $input['bonus_type'];
            $requestBonus['amount'] = $input['amount'];
            $requestBonus['level'] = 1; // TODO Need to get 
            $requestBonus['user_by'] = $user->id;
        } else {
            $req['is_initial']  = 0;
        }

        // print_r($req); exit;
        $payment = Payment::create($req);
        $this->isItFirstPayment($input['user_id'], $req['date'] . " 00:00:00");
        $this->isEligibleBonus($input['user_id'], $req['date'] . " 00:00:00");
        if ($isInitial == 1) {
            $customerBouns = CustomerBonus::create($requestBonus);
        }

        if ($payment) {
            $activity = "Deposit payment added. user - " . $input['user_id'];
            $this->alog->insert_auditlogs($activity, "Payment", "Payment", "A", "", null, null, null);

            if ($isSubdir != 0 &&  $isSubdir != "") {
                return redirect()->action('CustomerController@view', $isSubdir)->with('success', 'Deposit payment successfully added.');
            }
            return redirect()->route('admin-deposit')->with('success', 'Deposit payment successfully added.');
        } else {
            if ($isInitial == 1) {
                return redirect()->action('PaymentController@createInitialDeposit')->with('error', "Invalid Request.")->withInput();
            }
            return redirect()->action('PaymentController@createDeposit')->with('error', "Invalid Request.")->withInput();
        }
    }






    public function updateDeposit(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        $id = $input['id'];

        $isInitial = isset($input['initial']) ? $input['initial'] : 0;

        if (!$this->isValidUserId($input['user_id'])) {
            return redirect()->action('PaymentController@editDeposit', $id)->with('error', "Unregisterd user ID.")->withInput();
        }
        if (!$this->isThisCustomer($input['user_id'])) {
            return redirect()->action('PaymentController@editDeposit', $id)->with('error', "Unregisterd user ID.")->withInput();
        }
        $req['user_by'] = $user->id;
        $req['user_id'] = $input['user_id'];
        $req['amount'] = $input['amount'];
        $req['description'] = $input['description'];
        // $req['currency']  = $input['currency'];
        if ($input['date'] == "" || $input['date'] == 0) {
            date_default_timezone_set('Asia/Colombo');
            $req['date']  = date('Y-m-d');
        } else {
            $req['date']  = $input['date'];
        }

        if ($isInitial == 1) {
            $req['is_initial']  = 1;
        } else {
            $req['is_initial']  = 0;
        }

        $payment = Payment::find($id);
        $pay = $payment->update($req);
        $this->updateUserLastPayment($input['user_id'], $req['date'] . " 00:00:00");
        $this->isEligibleBonus($input['user_id'], $req['date'] . " 00:00:00");
        if ($isInitial == 1) {
            $customerBouns = CustomerBonus::where('user_id', $input['user_id'])->update(
                [
                    'bonus_type' => $input['bonus_type'],
                    'amount' => $input['amount'],
                    'user_by' => $user->id
                ]
            );
        }

        if ($pay) {
            $activity = "Deposit payment updated. user - " . $input['user_id'] . ' Payment - ' . $id;
            $this->alog->insert_auditlogs($activity, "Payment", "Payment", "U", "", null, null, null);
            return redirect()->route('admin-deposit')->with('success', 'Deposit payment successfully updated.');
        } else {
            return redirect()->action('PaymentController@editDeposit', $id)->with('error', "Invalid Request.")->withInput();
        }
    }







    public function getDepositPaymentList(Request $request)
    {
        $txtsearch = ($request->input('search_value')) ? $request->input('search_value') : "";
        $frmdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $todate = ($request->input('tdate')) ? $request->input('tdate') : 0;

        $req = Payment::join("users", "users.id", "=", "payments.user_id")
            ->select([
                'users.first_name',
                'users.last_name',
                'payments.user_id',
                'payments.id',
                'payments.amount',
                'payments.type',
                'payments.is_initial',
                'payments.date' //,
                //'users.currency'
            ])
            ->where('payments.type', 1)
            ->orderBy('payments.id', 'DESC');
        if (isset($txtsearch) && $txtsearch != "" && is_numeric($txtsearch)) {
            $req->where('payments.user_id', $txtsearch);
            $txtsearch = "";
        }

        return Datatables::of($req)->addIndexColumn()
            ->filter(function ($query) use ($request, $txtsearch, $frmdate, $todate) {
                if (isset($frmdate) && $frmdate != "0") {
                    $Fdate = date('Y-m-d', strtotime($frmdate)) . " 00:00:00";
                    $query->where('date', '>', $Fdate);
                }
                if (isset($todate) && $todate != "0") {
                    $Tdate = date('Y-m-d', strtotime($todate)) . " 23:59:59";
                    $query->where('date', '<=', $Tdate);
                }
                if (isset($txtsearch) && $txtsearch != "") {
                    $query->where('users.first_name', 'like', "%{$txtsearch}%")
                        ->orwhere('users.last_name', 'like', "%{$txtsearch}%");
                }
            })
            ->editColumn('amount', function ($req) {
                $crncy = "";
                $amount = 0;
                switch ($req->currency) {
                    case '1':
                        $crncy = "LKR";
                        break;
                    case '2':
                        $crncy = "$";
                        break;
                    case '3':
                        $crncy = "GBP";
                        break;
                    case '4':
                        $crncy = "EUR";
                        break;
                    default:
                        $crncy = "";
                        break;
                }
                $amount = $crncy . " " . number_format($req->amount, 2, ".", ",");

                return  $amount;
            })
            ->editColumn('date', function ($req) {
                return date('Y-m-d', strtotime($req->date));
            })
            ->editColumn('is_initial', function ($req) {
                if ($req->is_initial == '1') {
                    return $req->is_initial = '<span class="label label-success">Initial</span>';
                } else {
                    return $req->is_initial = '<span class="label label-primary">Not Initial</span>';
                }
                return $req->is_initial;
            })



            ->addColumn('action', function ($req) {
                $action = '';
                $action .= '<a data-toggle="tooltip" title="Payment Edit" href="admin-deposit/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                return $action;
            })

            ->rawColumns(['is_initial', 'amount', 'action'])->make(true);
    }


    /****
     * 
     * Withdraw
     * 
     * 
     ****/


    public function indexWithdraw(Request $request)
    {
        $search_value = ($request->input('search_value')) ? $request->input('search_value') : "";
        $fdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $tdate = ($request->input('tdate')) ? $request->input('tdate') : 0;
        return view('finances.withdraw.index', compact('search_value', 'fdate', 'tdate'));
    }





    public function createWithdraw()
    {
        return view('finances.withdraw.add');
    }





    public function editWithdraw($id)
    {
        $payment = Payment::find($id);
        return view('finances.withdraw.edit', compact('payment'));
    }





    public function storeWithdraw(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        if (!$this->isValidUserId($input['user_id'])) {
            return redirect()->action('PaymentController@createWithdraw')->with('error', "Unregisterd user ID.")->withInput();
        }
        if (!$this->isThisCustomer($input['user_id'])) {
            return redirect()->action('PaymentController@createWithdraw')->with('error', "Unregisterd user ID.")->withInput();
        }

        if ($this->hasRequest($input['user_id'])) {
            return redirect()->action('PaymentController@indexWithdraw')->with('error', 'This customer already has a withdraw request. Please check it.');
        } else if (!$this->hasAvailableWithdraw($input['amount'], $input['user_id'])) {
            return redirect()->action('PaymentController@createWithdraw')->with('error', 'Given Amount is not under customer available bonus amount.')->withInput();
        } else if ($this->isMiniAmount($input['amount'])) {
            return redirect()->action('PaymentController@createWithdraw')->with('error', 'The amount should be greater than 50')->withInput();
        } else if ($this->isMaxAmount($input['amount'])) {
            return redirect()->action('PaymentController@createWithdraw')->with('error', 'The amount should be less than 10000')->withInput();
        } else {
            $req['user_id'] = $input['user_id'];
            $req['user_by'] = $user->id;
            $req['amount'] = $input['amount'];
            $req['description'] = $input['description'];
            // $req['currency']  = $input['currency'];
            if ($input['date'] == "" || $input['date'] == 0) {
                date_default_timezone_set('Asia/Colombo');
                $req['date']  = date('Y-m-d');
            } else {
                $req['date']  = $input['date'];
            }
            $req['type']  = 2;
            $payment = Payment::create($req);

            if ($payment) {

                $activity = "Withdraw payment added. user - " . $input['user_id'];
                $this->alog->insert_auditlogs($activity, "Payment", "Payment", "A", "", null, null, null);

                return redirect()->route('admin-withdraw')->with('success', 'Withdraw payment successfully added.');
            } else {
                return redirect()->action('PaymentController@indexWithdraw')->with('error', "Invalid Request.")->withInput();
            }
        }
    }






    public function updateWithdraw(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        $id = $input['id'];
        if (!$this->isValidUserId($input['user_id'])) {
            return redirect()->action('PaymentController@editWithdraw', $id)->with('error', "Unregisterd user ID.")->withInput();
        }
        if (!$this->isThisCustomer($input['user_id'])) {
            return redirect()->action('PaymentController@editWithdraw', $id)->with('error', "Unregisterd user ID.")->withInput();
        }
        $req['user_by'] = $user->id;
        $req['user_id'] = $input['user_id'];
        $req['amount'] = $input['amount'];
        $req['description'] = $input['description'];
        // $req['currency']  = $input['currency'];
        if ($input['date'] == "" || $input['date'] == 0) {
            date_default_timezone_set('Asia/Colombo');
            $req['date']  = date('Y-m-d');
        } else {
            $req['date']  = $input['date'];
        }

        $payment = Payment::find($id);
        $pay = $payment->update($req);

        if ($pay) {
            $activity = "Withdraw payment updated. user - " . $input['user_id'] . ' payment - ' . $id;
            $this->alog->insert_auditlogs($activity, "Payment", "Payment", "U", "", null, null, null);

            return redirect()->route('admin-withdraw')->with('success', 'Withdraw payment successfully updated.');
        } else {
            return redirect()->action('PaymentController@indexWithdraw', $id)->with('error', "Invalid Request.")->withInput();
        }
    }




    public function getWithdrawPaymentList(Request $request)
    {
        $txtsearch = ($request->input('search_value')) ? $request->input('search_value') : "";
        $frmdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $todate = ($request->input('tdate')) ? $request->input('tdate') : 0;

        $req = Payment::join("users", "users.id", "=", "payments.user_id")
            ->select([
                'users.first_name',
                'users.last_name',
                'payments.user_id',
                'payments.id',
                'payments.amount',
                'payments.type',
                'payments.date' //,
                //'users.currency'
            ])
            ->where('payments.type', 2)
            ->orderBy('payments.id', 'DESC');
        if (isset($txtsearch) && $txtsearch != "" && is_numeric($txtsearch)) {
            $req->where('payments.user_id', $txtsearch);
            $txtsearch = "";
        }

        return Datatables::of($req)->addIndexColumn()
            ->filter(function ($query) use ($request, $txtsearch, $frmdate, $todate) {
                if (isset($frmdate) && $frmdate != "0") {
                    $Fdate = date('Y-m-d', strtotime($frmdate)) . " 00:00:00";
                    $query->where('date', '>', $Fdate);
                }
                if (isset($todate) && $todate != "0") {
                    $Tdate = date('Y-m-d', strtotime($todate)) . " 23:59:59";
                    $query->where('date', '<=', $Tdate);
                }
                if (isset($txtsearch) && $txtsearch != "") {
                    $query->where('users.first_name', 'like', "%{$txtsearch}%")
                        ->orwhere('users.last_name', 'like', "%{$txtsearch}%");
                }
            })
            ->editColumn('amount', function ($req) {
                $crncy = "";
                $amount = 0;
                switch ($req->currency) {
                    case '1':
                        $crncy = "LKR";
                        break;
                    case '2':
                        $crncy = "$";
                        break;
                    case '3':
                        $crncy = "GBP";
                        break;
                    case '4':
                        $crncy = "EUR";
                        break;
                    default:
                        $crncy = "";
                        break;
                }
                $amount = $crncy . " " . number_format($req->amount, 2, ".", ",");

                return  $amount;
            })
            ->editColumn('date', function ($req) {
                return date('Y-m-d', strtotime($req->date));
            })
            ->addColumn('action', function ($req) {
                $action = '';
                $action .= '<a data-toggle="tooltip" title="Payment Edit" href="admin-withdraw/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                return $action;
            })

            ->rawColumns(['amount', 'action'])->make(true);
    }










    private function isValidUserId($userId)
    {
        $userCount = 0;
        $userCount = User::where('id', '=', $userId)->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
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





    private function updateUserLastPayment($userId, $date = null)
    {
        $updateDate = Carbon::now()->format('Y-m-d H:i:s');
        if ($date != "" || $date != null) {
            $updateDate = $date;
        }
        // $user = Customer::find($userId);
        // $user->pay_last_date = $updateDate;
        // return $user->update();

        $update = Customer::where('user_id', $userId)->update(
            ['pay_last_date' => $updateDate]
        );
        return $update;
    }





    private function isItFirstPayment($userId, $date = null)
    {
        $updateDate = Carbon::now()->format('Y-m-d H:i:s');
        if ($date != "" || $date != null) {
            $updateDate = $date;
        }
        // $user = Customer::find($userId);
        $update = Customer::where('user_id', $userId)->where('pay_active', 0)->update(
            [
                'pay_active' => 1,
                'pay_active_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'current_level' => 1,
                'level_started' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );

        $update = Customer::where('user_id', $userId)->where('pay_active', 1)->update(
            ['pay_last_date' => $updateDate]
        );
        return $update;

        // $active=$user->pay_active;
        // if(!$active){
        //     $user->pay_active=1;
        //     $user->pay_active_date = Carbon::now()->format('Y-m-d H:i:s');
        //     $user->current_level = 1;           
        // }
        // $user->pay_last_date = $updateDate;
        // return $user->update();        
    }



    private function isEligibleBonus($userId, $date = null)
    {
        $teamCount = 0;
        $update = "";
        $teamLeadId = User::find($userId);
        $teamCount = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.*', 'customers_details.*')
            ->where("customers_details.pay_active", 1)
            ->where("users.is_admin", 2)
            ->where("users.invited_by", $teamLeadId->invited_by)->count();

        $teamLead = User::find($teamLeadId->invited_by);
        if ($teamLead) {
            if ($teamLead->is_admin == 2) {
                if ($teamCount > 5) {
                    $updateDate = Carbon::now()->format('Y-m-d H:i:s');
                    if ($date != "" || $date != null) {
                        $updateDate = $date;
                    }
                    $update = Customer::where('user_id', $teamLeadId->invited_by)
                        ->where('pay_active', 1)
                        ->where('is_bonus_active', 0)->update(
                            [
                                'bonus_active_date' => $updateDate,
                                'is_bonus_active' => 1
                            ]
                        );
                }
            }
        }
        return $update;
    }




    private function hasAvailableWithdraw($input, $userid)
    {
        $balance = 0;
        $paymet = new Payment();
        $mypayment = $paymet->getMyWallet($userid);
        $balance = isset($mypayment['availablewithdraw']) ? $mypayment['availablewithdraw'] : 0;
        if ($balance > $input) {
            return true;
        } else if ($balance == $input) {
            return true;
        }
        return false;
    }

    private function isMiniAmount($input)
    {
        $minAmount = 50; // TODO
        if ($input < $minAmount) {
            return true;
        }
        return false;
    }

    private function isMaxAmount($input)
    {
        $maxAmount = 10000; // TODO
        if ($input > $maxAmount) {
            return true;
        }
        return false;
    }

    private function hasRequest($userid)
    {
        $getReqCount = 0;
        $getReqCount = Withdraw::where('status', '=', 1)->where('user_id', '=', $userid)->count();
        if ($getReqCount != "" && $getReqCount != 0) {
            return true;
        }
        return false;
    }
}
