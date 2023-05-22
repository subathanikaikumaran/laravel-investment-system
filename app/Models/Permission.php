<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Permission extends Model
{

    public function get_permission_groups() {
        $result = DB::table('permissions')
            ->select("type")
            ->groupBy('type')
            ->orderBy('type','ASC')
            ->get()
            ->toArray();
        $resultarr= array();
        foreach ($result as $value){ 
            $resultarr[] = $value->type;
        }
        return $resultarr;
    }


    public function allpermission(){
        $arr=array();
        $result = $this->get_permission_groups();         
        foreach ($result as $t){
            $get = DB::table('permissions')->select("*")->where('type',$t )->orderBy('id','ASC')->get()->toArray();
            $c=0;
             foreach ($get as $n){
               $arr[$t][$c]['name'] = $n->name;
               $arr[$t][$c]['dis_name'] = $n->display_name;
               $arr[$t][$c]['id'] = $n->id;
               $c++;
             }
        }
       return $arr;
   }
   
}