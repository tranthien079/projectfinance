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
    public function index()
    {

        $title = 'Quản lí sổ tiết kiệm';
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $bookbanks = DB::table('bookbank')->where('user', $user->id)->where('status', 'notyet')->orderByDesc("id")->get();

        foreach ($bookbanks as $bookBank) {
            if ($bookBank->payinterest == 'monthlyperiod') {
                $sendMonth = date('m', strtotime($bookBank->senddate));
                $currentMonth = date('m');

                if ($currentMonth >= $sendMonth) {
                    // Tính toán lãi suất
                    $interest = $bookBank->amount * $bookBank->interest / 1200;

                    // Cập nhật số dư tài khoản
                    $this->balance($bookBank->account, $bookBank->amount + round($interest), "plus");

                    // Cập nhật trạng thái của bookBank
                    DB::table('bookbank')->where('id', $bookBank->id)->update(['status' => 'settled']);
                }
            }
        }
        $bookbankSettled = DB::table('bookbank')->where('user', $user->id)->where('status', 'settled')->orderByDesc("id")->get();
        return view('bookbank.index', compact('title', 'user', 'accounts', 'bookbanks', 'bookbankSettled'));
    }

    public function balance($accountId, $amount, $action)
    {
        $account = DB::table('accounts')->where('id', $accountId)->first();
        $balance = ($action == "plus") ? $account->balance + $amount : $account->balance - $amount;
        DB::table('accounts')->where('id', $accountId)->update(["balance" => $balance]);
        return true;
    }


    public function add()
    {

        $user = Auth::user();
        if (request('accountpay') == '') {
            $accountpay = '';
        } else {
            $accountpay = request('accountpay');
        }
        if (request('description') == null) {
            $description = '';
        } else {
            $description = request('description');
        }
        if (request('term') == null) {
            $term = request('termTemp');
        } else {
            $term = request('term');
            ;
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
            'status' => 'notyet',
            'settledate' => date('Y-m-d', strtotime(request('senddate') . ' + ' . $term . ' months'))

        ];
        $bookbankid = DB::table('bookbank')->insertGetId($data);

        if ($accountpay != '') {
            $interest = $data['amount'] * $data['interest'] / 1200 * $data['term'];
            $this->balance($accountpay, round($interest), "plus");
        }

        if (request('account') != "00") {
            $this->balance(request('account'), request('amount'), "minus");
        }

        return redirect()->route('bookbank.index')->with('success', 'Thêm sổ tiết kiệm thành công.');
    }

    public function edit(Request $request, $id)
    {
        $title = 'Quản lí sổ tiết kiệm';
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $bookbank = DB::table('bookbank')->where('id', $id)->first();

        return view('/bookbank/edit', compact("bookbank", "accounts", 'title'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        if ($request->input('description') == null) {
            $description = '';
        } else {
            $description = $request->input('description');
        }
        if ($request->input('term') == null) {
            $term = $request->input('termTemp');
        } else {
            $term = $request->input('term');
        }

        $data = [
            'namebb' => $request->input('namebb'),
            'amount' => $request->input('amount'),
            'namebank' => $request->input('namebank'),
            'senddate' => date('Y-m-d', strtotime($request->input('senddate'))),
            'term' => $term,
            'interest' => $request->input('interest'),
            'nonterminterest' => $request->input('nonterminterest'),
            'numberdaysinterest' => $request->input('numberdaysinterest'),
            'payinterest' => $request->input('payinterest'),
            'finalizefund' => $request->input('finalizefund'),
            'account' => $request->input('account'),
            'user' => $user->id,
            'description' => $description,
            'status' => 'notyet'
        ];

        $bookbankedit = DB::table('bookbank')->where('id', $request->input('bookbankid'))->first();
        if (request('amount') != $bookbankedit->amount && $bookbankedit->account > 0) {
            $this->balance($bookbankedit->account, $bookbankedit->amount, "plus");
            $this->balance($bookbankedit->account, request('amount'), "minus");
        }
        DB::table('bookbank')->where('id', $request->input('bookbankid'))->update($data);

        return redirect()->route('bookbank.index')->with('success', 'Cập nhật sổ tiết kiệm thành công.');
    }

    public function destroy(Request $request)
    {
        $bookbank = DB::table('bookbank')->where('id', $request->input('bookbankid'))->first();
        $settledate = $bookbank->settledate;
        $settleDay = strtotime($settledate);
        $term = $bookbank->term;
        $sendDate = $bookbank->senddate;
        $today = date('Y-m-d');
        $dueDate = strtotime("+$term months", strtotime($sendDate));

        // Tính số ngày đã trôi qua từ ngày gửi tiền
        $daysPassed = (strtotime($settleDay) - strtotime($sendDate)) / (60 * 60 * 24);

        // Kiểm tra xem ngày hiện tại có sau ngày gửi và thời hạn không
        if (strtotime($settleDay) >= $dueDate) {
            // Lãi suất theo thánng
            $interest = $bookbank->amount * $bookbank->interest / 1200 * $term;
        } elseif(strtotime($sendDate) == strtotime($today)) {
            $interest = 0 ;
        } else {
            // Lãi suất theo ngày
            $interest = $bookbank->amount * $bookbank->nonterminterest / 100 * $daysPassed / $bookbank->numberdaysinterest;
        }

        if (!empty($bookbank->account)) {
            $this->balance($bookbank->account, $bookbank->amount, "plus");
        }

        if ($bookbank->accountpay > 0) {
            $this->balance($bookbank->accountpay, round($interest), "mius");
        }

        DB::table('bookbank')->where('id', $request->input('bookbankid'))->delete();

        return redirect()->route('bookbank.index')->with('success', 'Xóa sổ tiết kiệm thành công.');
    }

    public function settle(Request $request, $id)
    {
        $title = 'Quản lí sổ tiết kiệm';
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $bookbank = DB::table('bookbank')->where('id', $id)->first();
        return view('/bookbank/settle', compact("bookbank", "accounts", 'title'));
    }


    public function updatesettle(Request $request)
    {
        $bookbank = DB::table('bookbank')->where('id', $request->input('bookbankid'))->first();
        
        $settleday = date('Y-m-d', strtotime($bookbank->settledate));
        $term = $bookbank->term;
        $sendDate = $bookbank->senddate;
        $dueDate = strtotime("+$term months", strtotime($sendDate));
        $today = date('Y-m-d');
        // Tính số ngày đã trôi qua từ ngày gửi tiền
        $daysPassed = (strtotime($today) - strtotime($sendDate)) / (60 * 60 * 24);

        // Kiểm tra xem ngày hiện tại có sau ngày gửi và thời hạn không
        if (strtotime($today) >= $dueDate) {
            // Lãi suất theo thánng
            $interest = $bookbank->amount * $bookbank->interest / 1200 * $term;
        } elseif(strtotime($sendDate) == strtotime($today)) {
            $interest = 0 ;
        } else {
            // Lãi suất theo ngày
            $interest = $bookbank->amount * $bookbank->nonterminterest / 100 * $daysPassed / $bookbank->numberdaysinterest;
        }
        $receive = $request->input('accountreceive');
       
        if ($bookbank->payinterest == 'begin' || $bookbank->payinterest == 'monthlyperiod') {

            $this->balance($receive, $request->input('amount'), "plus");
        } else {
            // Cập nhật số dư tài khoản
            $this->balance($receive, $request->input('amount') + round($interest), "plus");
        }
        // Cập nhật trạng thái sổ tiết kiệm
        DB::table('bookbank')->where('id', $request->input('bookbankid'))->update(['status' => 'settled']);

        return redirect()->route('bookbank.index')->with('success', 'Tất toán sổ tiết kiệm thành công.');
         // $data = [
        //     'receive'=> $request->input('accountreceive'),
        //     'interest'=>$interest,
        //     'amount'=> $request->input('amount'),
        //     'daysPassed' => $daysPassed,
        //     'settlee' => $settleday,
        //     'send' => $sendDate
        // ];
        // dd($data);
    }

}
