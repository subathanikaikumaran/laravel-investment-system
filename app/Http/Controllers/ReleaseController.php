<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config; 
class ReleaseController extends Controller
{
  public function index(){
    $data=array();
    $data['sprint']="1";

    $data['date']="DEC 04, 2020 20:00";
    $data['version']="v1.0.0.0.7L";
    $data['gittag']="v1.0.0.0.7L";
    $data['gittagurl']="";

    $data['note']="Initial release";
    

    $data['api']=Config::get('api-config.api.Client');

    return view('release.index', compact('data'));
  }
}
