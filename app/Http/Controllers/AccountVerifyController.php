<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountVerifyRequest;
use App\Models\AccountVerify;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Password;
use App\Models\Auditlogs;
use App\Models\Question;
use Carbon\Carbon;
use App\Models\User;

class AccountVerifyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->alog = new Auditlogs();
    }

    public function index()
    {
        $user = Auth::user();
        $id = $user->id;
        $quesArr = [];
        $count = 0;
        $ans = new AccountVerify();
        $que = Question::get();
        if (isset($que)) {
            foreach ($que as $ques) {
                $qArr['id'] = isset($ques->id) ? $ques->id : "";
                $qArr['name'] = isset($ques->name) ? $ques->name : "";
                $qArr['description'] = isset($ques->description) ? $ques->description : "";
                $quesArr[] = $qArr;
            }
        }
        //$count = $ans->letsCheckUserhasAnswer($id);
        if ($user->account_verify==1) {
            return redirect()->action('DashboardClientController@index');
        }

        return view('accountverify.index', compact('quesArr', 'count', 'id'));
    }


    public function store(AccountVerifyRequest $request)
    {
        $input = $request->all();
        $req = array();

        $data = [
            ['user_id' => $input['id'], 'ques_id' => $input['ques1'], 'answer' => $input['answer1']],
            ['user_id' => $input['id'], 'ques_id' => $input['ques2'], 'answer' => $input['answer2']]
        ];

        $save = AccountVerify::insert($data);
        
        if ($save) {
            $update = User::where('id', $input['id'])->update(
                ['account_verify' => 1]
            );
            if ($update) {
                return redirect()->action('DashboardClientController@index');
            } else {
                return redirect()->action('AccountVerifyController@index')->with('error', "Invalid Request.")->withInput();
            }
        }else {
            return redirect()->action('AccountVerifyController@index')->with('error', "Invalid Request.")->withInput();
        }

        
    }
}
