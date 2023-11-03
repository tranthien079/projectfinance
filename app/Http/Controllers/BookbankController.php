<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BookbankController extends Controller
{
    public function index() {
        $title = 'Quản lí sổ tiết kiệm';
        $user= Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $bookbanks = DB::table('bookbank')->where('user', $user->id)->where('status', 'notyet')->orderByDesc("id")->get();
        $bookbankSettled = DB::table('bookbank')->where('user', $user->id)->where('status', 'settled')->orderByDesc("id")->get();
        return view('bookbank.index',compact('title','user','accounts','bookbanks','bookbankSettled'));
    }

    public function balance($accountId, $amount, $action) {
        $account = DB::table('accounts')->where('id', $accountId)->first();
        $balance = ($action == "plus") ? $account->balance + $amount : $account->balance - $amount;
        DB::table('accounts')->where('id', $accountId)->update(["balance" => $balance]);
        return true;
    }


    public function add() {
        $user = Auth::user();
        if(request('description') == null) {
            $description = '';
        } else {
            $description = request('description');
        }
        if(request('term') == null) {
            $term = request('termTemp');
        } else {
            $term = request('term');;
        }

        $data = [
            'namebb' => request('namebb'),
            'amount' => request('amount'),
            'namebank' => request('namebank'),
            'senddate' => date('Y-m-d', strtotime(request('senddate'))),
            'term' => $term,
            'interest' => request('interest'),
            'nonterminterest' => request('nonterminterest'),
            'numberdaysinterest' => request('numberdaysinterest'),
            'payinterest' => request('payinterest'),
            'finalizefund' => request('finalizefund'),
            'account' => request('account'),
            'user' => $user->id,
            'description' => $description,
            'status' => 'notyet'
        ];

         DB::table('bookbank')->insertGetId($data);

         if (request('account') != "00") {
            $this->balance(request('account'), request('amount'), "minus");
        }

        return redirect()->route('bookbank.index')->with('success','Thêm sổ tiết kiệm thành công.');
    }

    public function edit(Request $request, $id) {
        $title = 'Quản lí sổ tiết kiệm';
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $bookbank = DB::table('bookbank')->where('id', $id)->first();
       
        return view('/bookbank/edit', compact("bookbank", "accounts", 'title'));
    }


    public function update(Request $request) {
    
    }

    public function destroy() {
    
    }


}
