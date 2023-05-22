<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawManagementRequest;
use App\Models\Payment;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Auditlogs;


class WithdrawController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }


    public function index(Request $request)
    {
        $search_value = ($request->input('search_value')) ? $request->input('search_value') : "";
        $status = ($request->input('status')) ? $request->input('status') : 0;
        return view('managerequests.index', compact('search_value', 'status'));
    }




    public function create()
    {
        return view('managerequests.add');
    }



    public function edit($id)
    {
        $payment = Withdraw::find($id);
        return view('managerequests.edit', compact('payment'));
    }



    public function store(WithdrawManagementRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        if (!$this->isValidUserId($input['user_id'])) {
            return redirect()->action('WithdrawController@create')->with('error', "Unregisterd user ID.")->withInput();
        }
        if (!$this->isThisCustomer($input['user_id'])) {
            return redirect()->action('WithdrawController@create')->with('error', "Unregisterd user ID.")->withInput();
        }
        if ($this->hasRequest($input['user_id'])) {
            return redirect()->action('WithdrawController@index')->with('error', 'This customer already has a withdraw request. Please check it.');
        } else if (!$this->hasAvailableWithdraw($input['amount'], $input['user_id'])) {
            return redirect()->action('WithdrawController@create')->with('error', 'Given Amount is not under customer available bonus amount.')->withInput();
        } else if ($this->isMiniAmount($input['amount'])) {
            return redirect()->action('WithdrawController@create')->with('error', 'The amount should be greater than 50')->withInput();
        } else if ($this->isMaxAmount($input['amount'])) {
            return redirect()->action('WithdrawController@create')->with('error', 'The amount should be less than 10000')->withInput();
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
            $req['status']  = 1;
            $payment = Withdraw::create($req);

            if ($payment) {

                $activity = "Withdraw request details added - " . $input['user_id'];
                $this->alog->insert_auditlogs($activity, "Payment", "Payment", "A", "", null, null, null);

                return redirect()->route('manage-payreq')->with('success', 'Withdraw request successfully added.');
            } else {
                return redirect()->action('WithdrawController@create')->with('error', "Invalid Request.")->withInput();
            }
        }
    }




    public function update(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        $id = $input['id'];
        $req['user_by'] = $user->id;
        $req['status']  = $input['status'];
        $req['description'] = $input['description'];
        $payment = Withdraw::find($id);
        $pay = $payment->update($req);

        $payment = json_decode(json_encode($payment), true);
        if ($input['status'] == 2) {
            $pay = array();
            $pay['user_id'] = isset($payment['user_id']) ? $payment['user_id'] : '';
            $pay['user_by'] = $user->id;
            $pay['amount'] = isset($payment['amount']) ? $payment['amount'] : '';
            $pay['description'] = isset($payment['description']) ? $payment['description'] : '';
            $pay['is_initial'] = 0;

            date_default_timezone_set('Asia/Colombo');
            $pay['date']  = date('Y-m-d');
            $pay['type']  = 2;
            $payment = Payment::create($pay);
        }
        if ($pay) {

            $activity = "Withdraw request details updated - " . $id;
            $this->alog->insert_auditlogs($activity, "Payment", "Payment", "U", "", null, null, null);

            return redirect()->route('manage-payreq')->with('success', 'Withdraw request successfully updated.');
        } else {
            return redirect()->action('WithdrawController@index', $id)->with('error', "Invalid Request.")->withInput();
        }
    }




    public function getManageReqList(Request $request)
    {
        $txtsearch = ($request->input('search_value')) ? $request->input('search_value') : "";
        $status = ($request->input('status')) ? $request->input('status') : 0;

        $req = Withdraw::join("users", "users.id", "=", "requests.user_id")
            ->select([
                'users.first_name',
                'users.last_name',
                'requests.user_id',
                'requests.id',
                'requests.amount',
                'requests.status',
                'requests.date' //,
                // 'users.currency'
            ])
            ->orderBy('requests.id', 'DESC');
        if (isset($txtsearch) && $txtsearch != "" && is_numeric($txtsearch)) {
            $req->where('requests.user_id', $txtsearch);
            $txtsearch = "";
        }

        return Datatables::of($req)->addIndexColumn()
            ->filter(function ($query) use ($request, $txtsearch, $status) {
                if (isset($status) && $status != "") {
                    $query->where('requests.status', $status);
                }
                if (isset($txtsearch) && $txtsearch != "") {
                    $query->where('users.first_name', 'like', "%{$txtsearch}%")
                        ->orwhere('users.last_name', 'like', "%{$txtsearch}%");
                }
            })
            ->editColumn('status', function ($req) {
                if ($req->status == 1) {
                    $req->status = '<span class="label label-primary">Pending</span>';
                } else if ($req->status == 2) {
                    $req->status = '<span class="label label-success">Completed</span>';
                } else if ($req->status == 3) {
                    $req->status = '<span class="label label-danger">Rejected</span>';
                }
                return $req->status;
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
                if (isset($req->date) && $req->date != "") {
                    return date('Y-m-d', strtotime($req->date));
                }
                return '-';
            })
            ->addColumn('action', function ($req) {
                $action = '';
                if ($req->status == 1) {
                    $action .= '<a data-toggle="tooltip" title="Payment Edit" href="manage-payreq/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                } else {
                    $action = '-';
                }
                return $action;
            })

            ->rawColumns(['status', 'amount', 'action'])->make(true);
    }






    public function destroy($id)
    {
        Withdraw::where('id', '=', $id)->delete();
        return redirect()->route('withdraw')
            ->with('success', 'Record successfully deleted.');
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
