<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Income;
use App\Models\Account;
use App\Models\Expense;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index() {
        $stats = array();
        $title = __('pages.sections.account');
        $user = auth()->user();
        
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc('id')->get();
        $categories = DB::table('categories')->where('user', $user->id)->where('type', 'expense')->orderByDesc('id')->get();
        $incomecategories = DB::table('categories')->where('user', $user->id)->where('type', 'income')->orderByDesc('id')->get();
    
        foreach ($accounts as $account) {
            $incomeTransactions = DB::table('income')->where('account', $account->id)->count();
            $expenseTransactions = DB::table('expenses')->where('account', $account->id)->count();
            $account->transactions = $incomeTransactions + $expenseTransactions;
        }
        return view('account.index', compact("user", "accounts",  "title"));
    }

    public function create()
    {
        
        $data = [
            'name' => request('name'),
            'user' => Auth::user()->id,
            'balance' => request('balance'),
            'type' => request('type'),
            'status' => request('status')
        ];

        DB::table('accounts')->insert($data);

        return redirect()->route('account.index')->with('success','Thêm nguồn tiền thành công.');
    }
 
    public function edit($id) {
        $title = __('overview.overview-form.update-title');
        $account = DB::table('accounts')->where('id', $id)->first();
        return view('/account/edit', compact("account","title"));
    }

    public function update(Request $request)
    {
        $data = [
            'name' => request('name'),
            'balance' => request('balance'),
            'type' => request('type'),
            'status' => request('status')
        ];

        DB::table('accounts')->where('id', $request->input('accountid'))->update($data);

        return redirect()->route('account.index')->with('success','Chỉnh sửa nguồn tiền thành công.');
    }
    public function destroy($id)
    {
        DB::table('accounts')->where('id', $id)->delete();
 
        return redirect()->route('account.index')->with('success','Xóa nguồn tiền thành công.');
    }
}
