<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PaymentClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {        
        $fdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $tdate = ($request->input('tdate')) ? $request->input('tdate') : 0;
        return view('clients.payment.clientindex', compact( 'fdate', 'tdate'));
    }

    




    public function getPaymentList(Request $request)
    {
        $frmdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $todate = ($request->input('tdate')) ? $request->input('tdate') : 0;
        $user = Auth::user();
        $req = Payment::select(['id','amount', 'type','date','description','is_initial'])
        ->where('user_id','=',$user->id) ->where('type','=',1)->orderBy('id', 'DESC');
        
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
                return "$ ".number_format($req->amount, 2, ".", ",");
            })
            ->editColumn('date', function ($req) {
                return date('Y-m-d', strtotime($req->date));
            })
            ->editColumn('description', function ($req) {
                return isset($req->description)?$req->description:"N/A";
            })
            ->editColumn('is_initial', function ($req) {
                if ($req->is_initial == 1) {
                    return $req->is_initial = '<span class="label label-success">Initial</span>';
                } else {
                    return $req->is_initial = '<span class="label label-primary">Not Initial</span>';
                }
                // return $req->is_initial;
            })
            ->rawColumns(['is_initial','amount','date','description'])->make(true);

            
    }


}
