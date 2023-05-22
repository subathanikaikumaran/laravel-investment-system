<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonusRequest;
use App\Models\Payment;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Auditlogs;
use App\Models\BonusCategory;
use App\Models\CustomerBonus;


class BonusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }


    public function index(Request $request)
    {
        $type = ($request->input('type')) ? $request->input('type') : 0;
        return view('bonus.index', compact('type'));
    }




    public function create()
    {
        return view('bonus.add');
    }



    public function edit($id)
    {
        $exitCount = 0;
        $exitCount = CustomerBonus::where('bonus_type', $id)->count();
        if ($exitCount > 0) {
            return redirect()->action('BonusController@index')->with('error', "This Bonus is under customer payment process. You can not Edit.");
        }
        
        $bonus = BonusCategory::find($id);
        return view('bonus.edit', compact('bonus'));
    }



    public function store(BonusRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();

        $req['user_by'] = $user->id;
        $req['level'] = $input['level'];
        $req['type'] = $input['type'];
        $req['basic_bonus'] = $input['basic_bonus'];
        $req['monthly_bonus'] = $input['monthly_bonus'];
        $req['description'] = $input['description'];
        $req['is_monthy_bonus'] = $input['isMonthly'];
        // $req['date']=$input['date'];
        $req['ini_amount'] = $input['amount'];


        if ($input['date'] == "" || $input['date'] == 0) {
            date_default_timezone_set('Asia/Colombo');
            $req['date']  = date('Y-m-d');
        } else {
            $req['date']  = $input['date'];
        }

        $bonus = BonusCategory::create($req);

        if ($bonus) {

            $activity = "Bonus Category details added - " . $input['type'];
            $this->alog->insert_auditlogs($activity, "Bonus Category", "Bonus Category", "A", "", null, null, null);

            return redirect()->route('admin-bonus')->with('success', 'Bonus Category successfully added.');
        } else {
            return redirect()->action('BonusController@create')->with('error', "Invalid Request.")->withInput();
        }
    }




    public function update(BonusRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $req = array();
        $id = $input['id'];
        $req['user_by'] = $user->id;
        $req['level'] = $input['level'];
        $req['type'] = $input['type'];
        $req['basic_bonus'] = $input['basic_bonus'];
        $req['monthly_bonus'] = $input['monthly_bonus'];
        $req['description'] = $input['description'];
        $req['is_monthy_bonus'] = $input['isMonthly'];
        // $req['date']=$input['date'];
        $req['ini_amount'] = $input['amount'];


        if ($input['date'] == "" || $input['date'] == 0) {
            date_default_timezone_set('Asia/Colombo');
            $req['date']  = date('Y-m-d');
        } else {
            $req['date']  = $input['date'];
        }

        $bonusval = BonusCategory::find($id);
        $bonus = $bonusval->update($req);

        if ($bonus) {
            $activity = "Bonus Category details updated - " . $id;
            $this->alog->insert_auditlogs($activity, "Bonus Category", "Bonus Category", "U", "", null, null, null);

            return redirect()->route('admin-bonus')->with('success', 'Bonus Category successfully updated.');
        } else {
            return redirect()->action('BonusController@index', $id)->with('error', "Invalid Request.")->withInput();
        }
    }




    public function getBonusList(Request $request)
    {

        $type = ($request->input('type')) ? $request->input('type') : 0;

        $req = BonusCategory::join("users", "users.id", "=", "bonus_category.user_by")
            ->select([
                'users.first_name',
                'users.last_name',
                'bonus_category.id',
                'bonus_category.user_by',
                'bonus_category.level',
                'bonus_category.type',
                'bonus_category.description',
                'bonus_category.basic_bonus',
                'bonus_category.monthly_bonus',
                'bonus_category.is_monthy_bonus',
                'bonus_category.date',
                'bonus_category.last_update',
                'bonus_category.ini_amount'
            ])
            ->orderBy('bonus_category.id', 'DESC');
        if (isset($type) && $type != "" && is_numeric($type)) {
            $req->where('bonus_category.level', $type);
        }

        return Datatables::of($req)->addIndexColumn()

            ->editColumn('ini_amount', function ($req) {
                $crncy = "$";
                $amount = 0;
                $amount = $crncy . " " . number_format($req->ini_amount, 2, ".", ",");
                return  $amount;
            })
            ->editColumn('date', function ($req) {
                if (isset($req->date) && $req->date != "") {
                    return date('Y-m-d', strtotime($req->date));
                }
                return '-';
            })
            ->editColumn('level', function ($req) {
                $level = "";
                if (isset($req->level) && $req->level != "") {
                    switch ($req->level) {
                        case '1':
                            $level = "Ring 1";
                            break;
                        case '2':
                            $level = "Ring 2";
                            break;
                        case '3':
                            $level = "Ring 3";
                            break;
                        case '4':
                            $level = "Ring 4";
                            break;
                        default:
                            $level = "";
                            break;
                    }
                }
                return $level;
            })
            ->editColumn('basic_bonus', function ($req) {
                if (isset($req->basic_bonus) && $req->basic_bonus != "") {
                    return $req->basic_bonus . ' %';
                }
                return '-';
            })
            ->editColumn('monthly_bonus', function ($req) {
                if (isset($req->monthly_bonus) && $req->monthly_bonus != "") {
                    return $req->monthly_bonus . ' %';
                }
                return '-';
            })

            ->editColumn('isMonthly', function ($req) {
                $isMonthly = "";
                if (isset($req->is_monthy_bonus) && $req->is_monthy_bonus != "") {
                    switch ($req->is_monthy_bonus) {
                        case '1':
                            $isMonthly = "Monthly";
                            break;
                        case '2':
                            $isMonthly = "Yearly";
                            break;
                        default:
                            $isMonthly = "";
                            break;
                    }
                }
                return $isMonthly;
            })
            ->addColumn('action', function ($req) {
                $action = '';
                $action .= '<a data-toggle="tooltip" title="Payment Edit" href="admin-bonus/edit/' . $req->id . '"><i class="icofont icofont-edit-alt"></i></a> ';
                return $action;
            })
            ->addColumn('addedBy', function ($req) {
                $name = "";
                if (isset($req->first_name) && $req->first_name != "") {
                    $name .= $req->first_name;
                }
                if (isset($req->last_name) && $req->last_name != "") {
                    $name .= $req->last_name;
                }
                return $name;
            })


            ->rawColumns(['action', 'addedBy', 'isMonthly'])->make(true);
    }






    public function destroy($id)
    {
        Withdraw::where('id', '=', $id)->delete();
        return redirect()->route('withdraw')
            ->with('success', 'Record successfully deleted.');
    }




    private function isValidUserId($userId)
    {
        $userCount = 0;
        $userCount = User::where('id', '=', $userId)->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
    }


    private function isThisCustomer($userId)
    {
        $userCount = 0;
        $userCount = User::where('id', '=', $userId)->where('is_admin', '=', 2)->count();
        if ($userCount != "" && $userCount != 0) {
            return true;
        }
        return false;
    }





    private function hasAvailableWithdraw($input, $userid)
    {
        $paymet = new Payment();
        $mypayment = $paymet->getMyWallet($userid);
        if (isset($mypayment['availablewithdraw']) && ($mypayment['availablewithdraw'] > $input || $mypayment['availablewithdraw'] = $input)) {
            return true;
        }
        return false;
    }

    private function isMiniAmount($input)
    {
        $minAmount = 50; // TODO
        if ($input < $minAmount) {
            return true;
        }
        return false;
    }

    private function isMaxAmount($input)
    {
        $maxAmount = 10000; // TODO
        if ($input > $maxAmount) {
            return true;
        }
        return false;
    }

    private function hasRequest($userid)
    {
        $getReqCount = 0;
        $getReqCount = Withdraw::where('status', '=', 1)->where('user_id', '=', $userid)->count();
        if ($getReqCount != "" && $getReqCount != 0) {
            return true;
        }
        return false;
    }
}
