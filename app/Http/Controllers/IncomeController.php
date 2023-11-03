<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class IncomeController extends Controller
{
    public function index() {
        $title = __('pages.sections.income');
        $user = Auth::user();
        $stats = [];
        $directorys = DB::table('directory')->where('user', $user->id)->orderByDesc("id")->get();
      
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $categories = DB::table('categories')->where('type', 'Income')->orderByDesc("id")->get();
        $incomecategories = DB::table('categories')->where('user', $user->id)->where('type', 'Income')->orderByDesc("id")->get();
        $income = DB::table("income")
            ->where('income.user', $user->id)
            ->leftJoin("accounts", "income.account", "=", "accounts.id")
            ->leftJoin("categories", "income.category", "=", "categories.id")
            ->orderByDesc("income.id")
            ->select('income.id', 'income.income_date', 'income.category', 'income.amount', 'income.title', 'accounts.name', 'categories.name as categoryname')
            ->get();
        $stats['earned'] = DB::table('income')->where('user', $user->id)->whereMonth('income_date', date("m"))->sum('amount');
        $stats['percentage'] = ($user->monthly_earning > 0) ? round(($stats['earned'] / $user->monthly_earning) * 100) : 0;

        return view('income.index', compact("user", "title", "accounts", "categories", "incomecategories", "income", "stats","directorys"));
    }
    
    public function getCategories() {
        $categories = DB::table('categories')->where('type', 'Income')->where('id_catalog', '0')->orderByDesc("id")->get();
    }
    public function add() {
        $user = Auth::user();
        if(request('description') == null) {
            $description = '';
        } else {
            $description = request('description');
        }

        

        $data = [
            'title' => request('title'),
            'user' => $user->id,
            'amount' => request('amount'),
            'account' => request('account'),
            'category' => request('category'),
            'income_date' => date('Y-m-d', strtotime(request('income_date'))),
            'description' => $description
        ];
        $income_id = DB::table('income')->insertGetId($data);

      
        if(request('directory') == null) {
            if(request('directoryMul') != null) {
                $directory = request('directoryMul');
                $directoryData = [];
                foreach ($directory as $dir) {
                    $directoryData = [
                        'directory' => $dir,
                        'income' =>  $income_id,
                    ];
        
                    DB::table('incomedetail')->insert($directoryData);
                }
            } else {
                $directory = '';
            }

        } else {
            $directory = request('directory');
            $directoryData0 = [
                'name' => $directory,
                'user' => $user->id
            ];

            $directory_id = DB::table('directory')->insertGetId($directoryData0);

            $directoryData = [
                'directory' => $directory_id,
                'income' =>  $income_id,
            ];
            DB::table('incomedetail')->insert($directoryData);
        }
       
        if (request('account') != "00") {
            $this->balance(request('account'), request('amount'), "plus");
        }
        return redirect()->route('income.index')->with('success','Thêm khoản thu thành công.');
    }
    
    public function balance($accountId, $amount, $action) {
        $account = DB::table('accounts')->where('id', $accountId)->first();
        $balance = ($action == "plus") ? $account->balance + $amount : $account->balance - $amount;
        DB::table('accounts')->where('id', $accountId)->update(["balance" => $balance]);
        return true;
    }
    
    public function edit(Request $request, $id) {
        $title = __('pages.sections.income');
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $incomecategories = DB::table('categories')->where('user', $user->id)->where('type', 'Income')->orderByDesc("id")->get();
        $income = DB::table('income')->where('id', $id)->first();
        $directorys = DB::table('directory')
        ->leftJoin('incomedetail', 'incomedetail.directory', '=', 'directory.id')
        ->select('directory.name','incomedetail.income','incomedetail.directory','directory.id')
        ->get();
        //  $directorys = collect($directorys1)->unique('name')->values()->all();
        return view('/income/edit', compact("income", "accounts", "incomecategories",'title',"directorys"));
    }

    public function update(Request $request) {
        // Lấy dữ liệu cần cập nhật từ request
        $data = [
                'title' => request('title'),
                'amount' => request('amount'),
                'account' => request('account'),
                'category' => request('category'),
                'income_date' => date('Y-m-d', strtotime(request('income_date')))
            ];
        // Tìm và cập nhật dữ liệu thu nhập
            $income = DB::table('income')->where('id', $request->input('incomeid'))->first();
        
            if (!$income) {
                return redirect()->back()->with('error', 'Income not found');
            }
        
            if (request('amount') != $income->amount && $income->account > 0) {
                // Thực hiện các thay đổi liên quan đến tài khoản
                $this->balance($income->account, $income->amount, "minus");
                $this->balance($income->account, request('amount'), "plus");
            }
        
            // Cập nhật dữ liệu thu nhập
            DB::table('income')->where('id', $request->input('incomeid'))->update($data);
        
          if(request('directoryMul') == null) {
            $directoryValues = '';
            DB::table('incomedetail')
            ->where('income', $request->input('incomeid'))
            ->delete();
          } else {
            $directoryValues = request('directoryMul');
            $directoryData = []; 

            DB::table('incomedetail')
            ->where('income', $request->input('incomeid'))
            ->delete();

            foreach ($directoryValues as $dir) {
            
              $directoryData = 
                [
                'directory' => $dir,
                'income' =>  $request->input('incomeid'),
                ];

             DB::table('incomedetail')->insert($directoryData);
            }
          }

           
            return redirect()->route('income.index')->with('success', 'Cập nhật khoản thu thành công.');
        }

    public function destroy($id)
    {
        $income = DB::table('income')->where('id', $id)->first();
        
        if (!empty($income->account)) {
            $this->balance($income->account, $income->amount, "minus");
        }
        DB::table('income')->where('id', $id)->delete();
        return redirect()->route('income.index')->with('success','Xóa khoản thu thành công.');
    }
}
