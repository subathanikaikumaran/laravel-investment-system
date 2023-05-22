<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\Auditlogs;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }


    public function index(Request $request)
    {
        $search_value = ($request->input('search_value')) ? $request->input('search_value') : "";
        $active_status = ($request->input('active_status')) ? $request->input('active_status') : 0;
        return view('users.index', compact('search_value', 'active_status'));
    }




    public function create()
    {
        return view('users.add');
    }



    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }



    public function store(UserRequest $request)
    {
        $input = $request->all();
        $req = array();
        $req['first_name'] = $input['first_name'];
        $req['last_name'] = $input['last_name'];
        $req['email'] = $input['email'];
        $req['phone'] = $input['phone'];
        // $req['gender'] = $input['gender'];
        // $req['dob'] = $input['dob'];
        $req['password'] = bcrypt($input['user_password']);
        $req['active'] = 1;
        $req['is_admin'] = 1;
        $user = User::create($req);
        //$user->assignRole(2);
        if ($user) {

            $activity = "Admin user details added - " . $input['email'];
            $this->alog->insert_auditlogs($activity, "User", "User", "A", "", null, null, null);
            return redirect()->action('UserController@index')->with('success', 'User details successfully added.');
        } else {
            return redirect()->action('UserController@create')->with('error', "Invalid Request.")->withInput();
        }
    }




    public function update(UserRequest $request)
    {
        $input = $request->all();

        $req = array();
        $id = $input['id'];
        $req['first_name'] = $input['first_name'];
        $req['last_name'] = $input['last_name'];
        $req['email'] = $input['email'];
        $req['phone'] = $input['phone'];
        // $req['gender'] = $input['gender'];
        // $req['dob'] = $input['dob'];

        $req['active'] = $input['active'];
        if (isset($input['change_pwd']) && $input['change_pwd'] == "on") {
            $req['password'] = bcrypt($input['user_password']);
            $req['pwd_changed'] = 0;
            $req['password_chng_date'] = Carbon::now()->format('Y-m-d H:i:s');
        }

        $user = User::find($id);
        $addUser = $user->update($req);
        if ($addUser) {

            $activity = "Admin user details updated - " . $input['email'];
            $this->alog->insert_auditlogs($activity, "User", "User", "U", "", null, null, null);

            return redirect()->action('UserController@index')->with('success', 'User details successfully updated.');
        } else {
            return redirect()->action('UserController@edit', $id)->with('error', "Invalid Request.")->withInput();
        }
    }




    public function allUserList(Request $request)
    {
        $txtsearch = ($request->input('search_value')) ? $request->input('search_value') : "";
        $activeStatus = ($request->input('active_status')) ? $request->input('active_status') : 0;

        $req = User::where("is_admin", 1)
            ->orderBy('id', 'DESC');
        if (isset($txtsearch) && $txtsearch != "" && is_numeric($txtsearch)) {
            $req->where('id', $txtsearch);
            $txtsearch = "";
        }

        return Datatables::of($req)->addIndexColumn()
            ->filter(function ($query) use ($request, $txtsearch, $activeStatus) {

                if (isset($activeStatus) && $activeStatus != "0") {
                    if ($activeStatus == 2) {
                        $query->where('active', 0);
                    } else {
                        $query->where('active', $activeStatus);
                    }
                }
                if (isset($txtsearch) && $txtsearch != "") {
                    $query->where('first_name', 'like', "%{$txtsearch}%")
                        ->orwhere('last_name', 'like', "%{$txtsearch}%");
                }
            })
            ->editColumn('active_status', function ($req) {
                $active_status = "";
                if ($req->active == 1) {
                    $active_status = '<span class="label label-success">Active</span>';
                } else if ($req->active == 0) {
                    $active_status = '<span class="label label-danger">Inactive</span>';
                }
                return $active_status;
            })

            ->addColumn('action', function ($req) {
                $action = '';
                $action .= '<a data-toggle="tooltip" title="User Edit" href="admin-user/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                return $action;
            })

            ->rawColumns(['active_status', 'action'])->make(true);
    }



    public function showUser(Request $request)
    {
        $searchword =  $request->searchWord;
        $query = User::Where('first_name', 'like', '%' . $searchword . '%')
            ->Where('last_name', 'like', '%' . $searchword . '%')
            ->orWhere('id', 'like', '%' . $searchword . '%');
        $mcc = $query->get();
        $results_arr = array();

        if ($mcc) {
            foreach ($mcc as $row) {
                if ($row->is_admin == 2) {
                    array_push(
                        $results_arr,
                        array(
                            "value" => $row->id,
                            "label" => ucfirst(strtolower($row->first_name)),
                            "label_desc" => $row->id . " , " . ucfirst(strtolower($row->first_name)) . " " . ucfirst(strtolower($row->last_name))
                        )
                    );
                }
            }
        }
        echo json_encode($results_arr);
    }




    public function showActiveUser(Request $request)
    {
        $searchword = $request->searchWord;
        $user = [];
        $results_arr = array();
        $user = DB::table('users')
            ->join('customers_details', 'users.id', '=', 'customers_details.user_id')
            ->select('users.id', 'customers_details.pay_active', 'users.first_name', 'users.last_name', 'users.is_admin')
            ->where('users.first_name', 'like', '%' . $searchword . '%')
            ->where('users.last_name', 'like', '%' . $searchword . '%')
            ->orWhere('users.id', 'like', '%' . $searchword . '%')
            ->where("users.is_admin", 2)
            ->where("customers_details.pay_active", 1)
            ->get()->toarray();
        if (!empty($user)) {
            foreach ($user as $key => $row) {

                if ($row->is_admin == 2) {
                    array_push(
                        $results_arr,
                        array(
                            "value" => $row->id,
                            "label" => ucfirst(strtolower($row->first_name)),
                            "label_desc" => $row->id . " , " . ucfirst(strtolower($row->first_name)) . " " . ucfirst(strtolower($row->last_name))
                        )
                    );
                }
            }
        }
        echo json_encode($results_arr);
    }
}
