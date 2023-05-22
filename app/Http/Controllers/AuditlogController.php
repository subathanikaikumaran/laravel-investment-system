<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Auditlogs;

class AuditlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $search_value = ($request->input('search_value')) ? $request->input('search_value') : "";
        $fdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $tdate = ($request->input('tdate')) ? $request->input('tdate') : 0;

        $hasSearch =0; $err=array();
        if ($request->hasSearch) {
            $hasSearch = $request->hasSearch;            
        }
        if(isset($search_value)){
            $txtsearch=trim($search_value);
        }
        if (isset($fdate)) {
            $frmdate = trim($fdate);            
        }
        if (isset($tdate)) {
            $todate = trim($tdate);            
        } 
        
        /***************validation*******************/
        if(strlen($frmdate)>10 ){
            $err[0]="Invalid from date."; 
         }elseif($frmdate!="" && ($frmdate > $todate)){
            $err[1]="From date can't be future date.";
         }

         if(strlen($todate)>10 ){
            $err[2]="Invalid to date."; 
         }elseif($todate!="" && ($todate > $todate)){
             $err[3]="To date can't be future date.";
         }
         if ($frmdate === "" && $todate !== "") { 
            $err[4]="Please select the From date.";
         }
         else if ($frmdate !== "" && $todate === "") { 
            $err[5]="Please select the To date.";
         }
         if($frmdate!="" && $todate!="" && ($frmdate > $todate)){
            $err[6]="To date should be greater than From date.";
         } 
         if(strlen($txtsearch)>80){
            $err[7]="Invalid search text length."; 
        }
        return view('auditlogs.index', compact('search_value','fdate', 'tdate','err','hasSearch'));
    }


    public function getList(Request $request)
    {
        $txtsearch = ($request->input('search_value')) ? $request->input('search_value') : "";
        $frmdate = ($request->input('fdate')) ? $request->input('fdate') : 0;
        $todate = ($request->input('tdate')) ? $request->input('tdate') : 0; 
        $auditlogs=new Auditlogs();
        
        $length = $request->length;
        $start = $request->start;
        $sEcho=$request->draw;        
        
        
        
        /***************validation*******************/
        $err="";
        if(strlen($frmdate)>10 ){
            $err.="Invalid from date."; 
         }elseif($frmdate!="" && ($frmdate > $todate)){
            $err.="From date can't be future date.";
         }

         if(strlen($todate)>10 ){
            $err.="Invalid to date."; 
         }elseif($todate!="" && ($todate > $todate)){
             $err.="To date can't be future date.";
         }
         if ($frmdate === "" && $todate !== "") { 
            $err.="Please select the From date.";
         }
         else if ($frmdate !== "" && $todate === "") { 
            $err.="Please select the To date.";
         }
         if($frmdate!="" && $todate!="" && ($frmdate > $todate)){
            $err.="To date should be greater than From date.";
         } 
         if(strlen($txtsearch)>80){
            $err.="Invalid search text length."; 
          } 
          /***************END validation*******************/
        
          
        
          
        if($err==""){ 
        
            $order=$request->order;
            $orderby=""; 
            if(!empty($order)) {
                foreach($order as $o) { 
                    if($o['column']==2){
                        $orderby ="ORDER BY email ".$o['dir']; 
                    } elseif($o['column']==3){
                      $orderby ="ORDER BY logtime ".$o['dir']; 
                    }
                }
              }

            $sWhere = "";        
            if (isset($txtsearch) && $txtsearch != '') {
                if(is_numeric($txtsearch)){ $sWhere .='(effectedid ='.$txtsearch.')'; } 
                elseif($this->isValidEmail($txtsearch)) {
                $sWhere .='(email like "%'.$txtsearch.'%"  )'; } else {
                    $sWhere .='(activity like "%'.$txtsearch.'%" )'; }
            }
            if (isset($frmdate) && $frmdate != '' && isset($todate) && $todate != '' && isset($txtsearch) && $txtsearch != '') {
               $sWhere .=' AND '; 
            }
            if (isset($frmdate) && $frmdate != '' && isset($todate) && $todate != '' ) {
               $frmdate= date('Y-m-d', strtotime($frmdate))." 00:00:00";
               $todate= date('Y-m-d', strtotime($todate))." 23:59:59";
               $sWhere .=" logtime BETWEEN '".$frmdate."' AND '".$todate."' ";
            }

            $iTotal = $auditlogs->get_auditlog_count($sWhere);
            $sLimit = "";
            $iDisplayStart = $start;
            $iDisplayLength = $length;
            if (isset($iDisplayStart) && $iDisplayLength != '-1') {
                $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .intval($iDisplayLength);
            }
            $result =  $auditlogs->get_auditlog_by_limit($sLimit,$sWhere,$orderby); 
            $output = array("draw" => $sEcho,
                            "recordsTotal" => $iTotal,
                            "recordsFiltered" =>  $iTotal,
                            "data" => array());


            if(!empty($result) ){     
                foreach ($result as $aRow) {
                    $logId="";
                    if($aRow->effectedid!=0){
                        $logId=$aRow->effectedid;
                    }
                    $arr2=array(); 
                    $arr2[] = $aRow->activity;
                    // $arr2[]=$logId;
                    $arr2[]=$aRow->email;
                    $arr2[]=$aRow->userid;
                    $arr2[]=date("m/d/Y",strtotime($aRow->logtime));
                    $arr2[]= date("H:i:s",strtotime($aRow->logtime));
                    // $arr2[]=$aRow->ipaddress;
                    // $arr2[]=$aRow->browser;//$aRow->ipaddress.' '.substr($aRow->browser,0,20).'...';
                    $output['data'][]=$arr2;
                }    
                echo 'jsonCallback(' . json_encode($output) . ')';
            }else{
                $output['recordsTotal']=0;
                $output['recordsFiltered']=0;
                $output['data'][] = array('No Records', '', '', '', '');
                echo 'jsonCallback(' . json_encode($output) . ')';
            }
        }else{
            $output['recordsTotal']=0;
                $output['recordsFiltered']=0;
                $output['data'][] = array('No Records', '', '', '', '');
                echo 'jsonCallback(' . json_encode($output) . ')';
         }
            
            
    }
    
    
    public function isValidEmail($email) {
      return filter_var($email, FILTER_VALIDATE_EMAIL) 
          && preg_match('/@.+\./', $email);
    }

    
}
