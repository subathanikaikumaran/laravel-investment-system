<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Session;

class HttpConnection
{

    public function loginApiConnection($action, $data)
    {
        $client = new Client();
        $arrayResponse = array();
        try {
            $userAgent=Config::get('api-config.headers.User-Agent');
            $portalAuth=Config::get('api-config.headers.Portal-Auth');
           
            $response = $client->post(Config::get('api-config.api.Client') . $action, [
                'json' => $data,
                'verify' => false,
                'headers' => [
                    'User-Agent' => $userAgent,
                    'Portal-Auth' => $portalAuth
                ]
            ]);

            $dataJson = mb_convert_encoding($response->getBody()->getContents(), 'UTF-8', 'UTF-8');
            $arrayResponse["response"] = json_decode($dataJson, true);
            
        } catch (\GuzzleHttp\Exception\ConnectException $e) {

            $arrayResponse["error"] = "There is server connection issue.";

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $execptionJson = $e->getResponse()->getBody()->getContents();
            // print_r($execptionJson); exit;
            $err = json_decode($execptionJson);
            // print_r($err); exit;
            if(isset($err) && !empty($err)){
                $arrayResponse["error"] = $err->{'err-message'} ;
            } else if ($e->getResponse()->getStatusCode() == '400') {
                $arrayResponse["error"] = "Error Code 400";
            } else {
                $arrayResponse["error"] = "Invalid..";
            }
        }catch(Exception $e){
            $arrayResponse["error"] = $e->getMessage();
         }
        return $arrayResponse;
    }



    public function apiConnection($action, $data)
    {
        $client = new Client();
        $arrayResponse = array();
        try {
            $appToken=$this->getToken();
            // print_r($appToken); exit;
            $userAgent=Config::get('api-config.headers.User-Agent');
            $portalAuth=Config::get('api-config.headers.Portal-Auth');
           
            $response = $client->post(Config::get('api-config.api.Client') . $action, [
                'json' => $data,
                'verify' => false,
                'headers' => [
                    'User-Agent' => $userAgent,
                    'Portal-Auth' => $portalAuth,
                    'gttoken' => $appToken
                ]
            ]);

            $dataJson = mb_convert_encoding($response->getBody()->getContents(), 'UTF-8', 'UTF-8');
            $arrayResponse["response"] = json_decode($dataJson, true);
            
        } catch (\GuzzleHttp\Exception\ConnectException $e) {

            $arrayResponse["error"] = "There is server connection issue.";

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $execptionJson = $e->getResponse()->getBody()->getContents();
            // print_r($execptionJson); exit;
            $err = json_decode($execptionJson);
            // print_r($err); exit;
            if(isset($err) && !empty($err)){
                $arrayResponse["error"] = $err->{'err-message'} ;
            } else if ($e->getResponse()->getStatusCode() == '400') {
                $arrayResponse["error"] = "Error Code 400";
            } else {
                $arrayResponse["error"] = "Invalid..";
            }
        }catch(Exception $e){
            $arrayResponse["error"] = $e->getMessage();
         }
        return $arrayResponse;
    }

    public function getToken()
    {
        $token="";
        if(Session::get('auth')){
            $auth= Session::get('auth');
            $token=$auth['TOKEN'];
        }
        return $token;
    }
}
