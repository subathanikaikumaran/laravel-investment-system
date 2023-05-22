<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Session;
class Auditlogs extends Model
{
     protected $table = 'auditlogs';
    
    public function get_auditlog_count($sWhere){
        if($sWhere==""){            
            $audit = \DB::select("Select count(email) as c from auditlogs");
        } else {            
            $audit = \DB::select("Select count(email) as c from auditlogs WHERE ". $sWhere);
        }
        return $audit[0]->c;
    }
    
    
    public function get_auditlog_by_limit($sLimit,$sWhere,$order){
        if($sWhere==""){
            $audit = \DB::select("Select * from auditlogs $order $sLimit ");
        }
        else {
            $audit = \DB::select("Select * from auditlogs WHERE $sWhere $order $sLimit");
        }
        return $audit;
    }
    
    
    public function insert_auditlogs( $activity, $category,$tablename=null,
            $accesstype=null,$effectedid =null,$fieldname=null, $oldvalue=null,$newvalue=null){
        
        $current = Carbon::now();
        $current = new Carbon();
        $today1 =$current->toDateTimeString();
                
        $ip = $this->get_client_ip_env();        
        $browser = $this->getBrowser();        
        $browser_full_details = $browser['name']."|".$browser['version']."|".$browser['platform'];
        
        $logged_user= Auth::user();        
        $userid = $logged_user->id;
        $email=$logged_user->email;
        
        $data = array(
            'email' => $email,
            'userid' => $userid,            
            'activity' => $activity,
            'effectedid' => $effectedid,
            'tablename' => $tablename,
            'fieldname' => $fieldname,
            'accesstype' => $accesstype,
            'oldvalue' => $oldvalue,
            'newvalue' => $newvalue,
            'ipaddress' => $ip,
            'browser' => $browser_full_details,
            'category' => $category,            
            'logtime' => $today1
        );
        return DB::table('auditlogs')->insert($data);
    }
    
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')){
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }else if (getenv('HTTP_X_FORWARDED_FOR')){
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        }else if (getenv('HTTP_X_FORWARDED')){
            $ipaddress = getenv('HTTP_X_FORWARDED');
        }else if (getenv('HTTP_FORWARDED_FOR')){
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        }else if (getenv('HTTP_FORWARDED')){
            $ipaddress = getenv('HTTP_FORWARDED');
        }else if (getenv('REMOTE_ADDR')){
            $ipaddress = getenv('REMOTE_ADDR');
        }else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }
    
   
    function getBrowser() { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    } 
    
    
    
    
    public function insert_audit_log($userid, $activity, $category, $email=null,$tablename=null,
            $accesstype=null,$effectedid =null,$fieldname=null, $oldvalue=null,$newvalue=null
            ){
        
        $current = Carbon::now();
        $current = new Carbon();
        $today1 =$current->toDateTimeString();
        
        $ip = $this->get_client_ip_env();        
        $browser = $this->getBrowser();        
        $browser_full_details = $browser['name']."|".$browser['version']."|".$browser['platform'];
        
        $data = array(
            'email' => $email,
            'userid' => $userid,
            
            'activity' => $activity,
            'effectedid' => $effectedid,
            'tablename' => $tablename,
            'fieldname' => $fieldname,
            'accesstype' => $accesstype,
            'oldvalue' => $oldvalue,
            'newvalue' => $newvalue,
            'ipaddress' => $ip,
            'browser' => $browser_full_details,
            'category' => $category,
            'logtime' => $today1
        );
       return DB::table('auditlogs')->insert($data);
    }
}