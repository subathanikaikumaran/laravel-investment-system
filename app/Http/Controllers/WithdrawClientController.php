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


class WithdrawClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $fdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $tdate = ($request->input('tdate')) ? $request->input('tdate') : 0;
        return view('clients.withdraw.clientindex', compact('fdate', 'tdate'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($this->hasRequest($user->id)) {
            return redirect()->action('FinanceClientController@index')->with('error', 'You have already sent the withdraw request. You may able to change the amount.');
        }        
        return view('clients.withdraw.clientadd');
    }

    public function edit($id)
    {    
        $withdraw = Withdraw::find($id);          
        return view('clients.withdraw.clientedit', compact('withdraw'));
    }


    public function store(WithdrawManagementRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        $req['user_id'] = $user->id;
        $req['amount'] = $input['amount'];
        $req['status'] = 1;

        if (!$this->hasAvailableWithdraw($input['amount'], $user->id)) {
            return redirect()->action('WithdrawClientController@create')->with('error', 'Given Amount is not under your available bonus amount.')->withInput();
        }
        else if ($this->isMiniAmount($input['amount'])) {
            return redirect()->action('WithdrawClientController@create')->with('error', 'The amount should be greater than 50')->withInput();
        } 
        else if ($this->isMaxAmount($input['amount'])) {
            return redirect()->action('WithdrawClientController@create')->with('error', 'The amount should be less than 10000')->withInput();
        }
        else {
            $withdraw = Withdraw::create($req);
            return redirect()->route('withdraw')->with('success', 'Request successfully created. You will get the response very soon.');
        }
    }

    public function update(WithdrawManagementRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();

        $id = $input['id'];
        $old_amount = $input['old_amount'];

        $req['user_id'] = $user->id;      
        $req['amount'] = $input['amount'];
        $req['status'] = 1;

        if($old_amount == $input['amount']){
            return redirect()->action('WithdrawClientController@edit',$id)->with('error', 'Old amount can not be current amount. Please try with different amount.')->withInput();
        }
        else if (!$this->hasAvailableWithdraw($input['amount'], $user->id)) {
            return redirect()->action('WithdrawClientController@edit',$id)->with('error', 'Given Amount is not under your available bonus amount.')->withInput();
        }
        else if ($this->isMiniAmount($input['amount'])) {
            return redirect()->action('WithdrawClientController@edit',$id)->with('error', 'The amount should be greater than 50')->withInput();
        } 
        else if ($this->isMaxAmount($input['amount'])) {
            return redirect()->action('WithdrawClientController@edit',$id)->with('error', 'The amount should be less than 10000')->withInput();
        }
        else {
            
            $withdraw = Withdraw::find($id);
            $withdraw->update($req);
            return redirect()->route('withdraw')->with('success', 'Request successfully updated.');
        }
    }

    




    public function getReqList(Request $request)
    {
        $frmdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $todate = ($request->input('tdate')) ? $request->input('tdate') : 0;

        $user = Auth::user();
        $req = Withdraw::select(['id', 'amount', 'status', 'date', 'description'])
            ->where('user_id', '=', $user->id)->orderBy('id', 'DESC');

        return Datatables::of($req)->addIndexColumn()
            ->filter(function ($query) use ($request, $frmdate, $todate) {
                if (isset($frmdate) && $frmdate != "0") {
                    $Fdate = date('Y-m-d', strtotime($frmdate)) . " 00:00:00";
                    $query->where('date', '>', $Fdate);
                }
                if (isset($todate) && $todate != "0") {
                    $Tdate = date('Y-m-d', strtotime($todate)) . " 23:59:59";
                    $query->where('date', '<=', $Tdate);
                }
            })
            ->editColumn('amount', function ($req) {
                return "$ " . number_format($req->amount, 2, ".", ",");
            })
            ->editColumn('status', function ($req) {
                if ($req->status == 1) {
                    $req->status = '<span class="label label-info">Processing</span>';
                } else if ($req->status == 2) {
                    $req->status = '<span class="label label-success">Completed</span>';
                } else if ($req->status == 3) {
                    $req->status = '<span class="label label-danger">Rejected</span>';
                }
                return $req->status;
            })
            ->editColumn('date', function ($req) {
                return date('Y-m-d', strtotime($req->date));
            })
            ->editColumn('description', function ($req) {
                return isset($req->description)?$req->description:'N/A';
            })
            ->addColumn('action', function ($req) {
                $action = '';
                if($req->status == 1){
                    $action .= '<a data-toggle="tooltip" title="Payment Edit" href="withdraw/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                } else {
                    $action .= '-';
                }
                return $action;
            })
            
            // ->addColumn('action', function ($req) {
            //     $action = '';              
            //     $action .= '&nbsp;<form disable method="POST" action="withdraw/' . $req->id . '" accept-charset="UTF-8" style="display:inline" id="del_frm" ">
            //                     <input name="_method" type="hidden" value="DELETE">
            //                     <input name="_token" type="hidden" value="' . csrf_token() . '">          
            //                     <button type="submit" style="padding:0" class="btn btn-blue-gray waves-effect waves-light" data-toggle="tooltip" data-placement="top" data-original-title="Delete">
            //                     <i class="icofont icofont-garbage"></i></button>
            //                     </form>';

            //     return $action;
            // })
            ->rawColumns(['amount', 'status', 'date','description','action'])->make(true);
    }


    public function destroy($id)
    {
        Withdraw::where('status', '=', 1)->where('id', '=', $id)->delete();
        return redirect()->route('withdraw')
            ->with('success', 'Record successfully deleted.');
    }









    private function hasAvailableWithdraw($input, $userid)
    {
        $balance = 0;
        $paymet = new Payment();
        $mypayment = $paymet->getMyWallet($userid);
        $balance = isset($mypayment['availablewithdraw']) ? $mypayment['availablewithdraw'] : 0;
        if($balance > $input){
            return true;
        }else if($balance == $input){
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
