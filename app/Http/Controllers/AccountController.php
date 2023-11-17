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
        $categories = $this->getCategories();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc('id')->get();
        // $categories = DB::table('categories')->where('user', $user->id)->where('type', 'expense')->orderByDesc('id')->get();
        $incomecategories = DB::table('categories')->where('user', $user->id)->where('type', 'income')->orderBy('id', 'DESC')->get();
        $directorys = DB::table('directory')->where('user', $user->id)->orderByDesc("id")->get();
        foreach ($accounts as $account) {
            $incomeTransactions = DB::table('income')->where('account', $account->id)->count();
            $expenseTransactions = DB::table('expenses')->where('account', $account->id)->count();
            $account->transactions = $incomeTransactions + $expenseTransactions;
        }
        return view('account.index', compact("user", "accounts",  "title","incomecategories","categories","directorys"));
    }

    public function getCategories() {
        $user = Auth::user();
        $categories = DB::table('categories')
        ->where('user', $user->id)
        ->where('categories.type', 'expense')
        ->orderByDesc("categories.id")
        ->select('categories.id','categories.id_catalog','categories.name')
        ->get();
    
        $listCategories = [];
        Category::recursive($categories, $parents = 0, $level = 1, $listCategories );
     
        return  $listCategories;
    }


    public function create()
    {
        
        $data = [
            'name' => request('name'),
            'user' => Auth::user()->id,
            'balance' => request('balance'),
            'type' => request('type'),
            'status' => 'Active'
        ];

        DB::table('accounts')->insert($data);

        return redirect()->route('account.index')->with('success','Thêm tài khoản thành công.');
    }
 
    public function edit($id) {
        $title = __('pages.sections.account');
        // $title = __('overview.overview-form.update-title');
        $account = DB::table('accounts')->where('id', $id)->first();
        return view('/account/edit', compact("account","title"));
    }

    public function update(Request $request)
    {
        $data = [
            'name' => request('name'),
            'balance' => request('balance'),
            'type' => request('type'),
            'status' => 'Active'
        ];

        DB::table('accounts')->where('id', $request->input('accountid'))->update($data);

        return redirect()->route('account.index')->with('success','Chỉnh sửa tài khoản thành công.');
    }
    public function destroy($id)
    {
        Account::find($id)->delete();
        return redirect()->route('account.index')->with('success','Xóa tài khoản thành công.');
    }
}
