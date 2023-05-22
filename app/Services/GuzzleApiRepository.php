<?php

namespace App\Services;

use App\Services\HttpConnection;
use Illuminate\Support\Facades\Config;
use App\Services\ApiFieldList;
use Illuminate\Support\Facades\Session;

class GuzzleApiRepository implements ApiRepositoryInterface
{
    public $appUserId = "";
    public $appUserName = "";


    public $epLogin="MPOSLightPortalLogin/apicall/portal/csuser/login";
    public $epMrchtList="MPOSLightPortal/apicall/portal/merchant/search";



    public function getAllMerchants($data)
    {
        return $this->getResponse($this->epMrchtList, $data);
    }




    public function getResponse($endpoint, $request,$type=NULL)
    {
        if($type=="add"){            
            $request['reqType'] = 1; 
        } 
        elseif($type=="edit"){
            $request['reqType'] = 1;  
        }
        elseif($type=="view"){
            $request['reqType'] = 1;  
        }

        $responseData = array();  
        $response = $this->execute($endpoint, $request);       
        if (isset($response["response"])) {
            $responseData = $response['response'];
        }elseif (isset($response["error"])) {
            $responseData = $response;
        }
        return $responseData;
    }



    public function loginExecute($action, $data)
    {
        $api = new HttpConnection();
        return $api->loginApiConnection($action, $data);
    }

    public function execute($action, $data)
    {
        $api = new HttpConnection();
        return $api->apiConnection($action, $data);
    }

   
    public function appAuth($userName, $password,$mrchtIp){
        $data= array();
        $data['username']=$userName;
        $data['pwd']= $password;
        $data['srcIp']= $mrchtIp;
        
        $response = array();
        $auth = $this->loginExecute($this->epLogin,$data);
        // print_r($response); exit;
        if (isset($auth["response"])) {
            $response = $auth['response'];
            $response=$this->authSession($response);
           
        }
        if (isset($auth["error"])) {
            $response = false;
        }
        return $response;
        
    }


    public function authSession($response)
    {
       
        if (!empty($response)) {
            $auth['USER_ID'] = isset($response['id'])?$response['id']:"";
            $auth['TOKEN'] = isset($response['token'])?$response['token']:"";
            $auth['EXPIRE'] = isset($response['exp'])?$response['exp']:"";
            $auth['USERNAME'] = isset($response['username'])?$response['username']:"";
            $auth['USER_ROLE_ID'] = isset($response['userRoleId'])?$response['userRoleId']:"";
            $auth['USER_ROLE_NAME'] = isset($response['userRoleName'])?$response['userRoleName']:"";
            // liCsUserRolePrimaryPermission
            $auth['STATUS'] = 0;
            if($auth['TOKEN'] !=""){
                $auth['STATUS'] = 1;
                $auth['CREATED_AT']= time(); 
                Session::put('auth', $auth);
                return true;
            } else{
                return false;
            }           
            
        } else{
            return false;
        } 
    }



}
