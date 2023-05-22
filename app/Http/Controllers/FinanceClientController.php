<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FinanceClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data = array();
        $arr = array();

        $user = Auth::user();
        $paymet= new Payment();
        $mypayment= $paymet->getMyWallet($user->id);    
         
        return view('clients.finances.summary', compact('mypayment', 'arr'));
    }
}
