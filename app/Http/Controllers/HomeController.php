<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Auditlogs;
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog=new Auditlogs();
    }


    public function index()
    {
        $this->alog->insert_auditlogs("test", "Home", "home","V","",null, null,null);
        return view('home.index');
    }

    

    public function clientHome()
    {
        return view('home.index');
    }
}
