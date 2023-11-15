<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    public function index() {
        $stats = [];
        $title = __('pages.sections.expenses');
        $user = Auth::user();
        $directorys = DB::table('directory')->where('user', $user->id)->orderByDesc("id")->get();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $expensecategories = DB::table('categories')->where('user', $user->id)->where('type', 'expense')->orderByDesc("id")->get();
        $categories1 = $this->getCategories();
        $categoryDefault = $this->getCategoriesDefault();
        $expensessss = DB::table("expenses")
            ->where('expenses.user', $user->id)
            ->leftJoin("accounts", "expenses.account", "=", "accounts.id")
            ->leftJoin("categories", "expenses.category", "=", "categories.id")
            ->orderByDesc("expenses.id")
            ->select('expenses.id', 'expenses.expense_date', 'expenses.amount', 'expenses.title', 'accounts.name', 'categories.name as category')
            ->get();

         $account = Account::with('expenses')->get();
        // dd($categories);
        $stats['spent'] = DB::table('expenses')->where('user', $user->id)->whereMonth('expense_date', date("m"))->sum('amount');
        $stats['percentage'] = ($user->monthly_spending > 0) ? round(($stats['spent'] / $user->monthly_spending) * 100) : 0;
 
       return view('expense.index', compact("user", "title", "stats", "accounts", "expensecategories","expensessss","account","categories1","directorys","categoryDefault"));
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

    public function getCategoriesDefault() {
        $user = Auth::user();
        $categories = DB::table('categories')->where('user', $user->id)->where('categories.type', 'expense')->get();
        $listCategories = [];
        Category::recursive($categories, $parents = 0, $level = 1, $listCategories );
     
        return  $listCategories;
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
            'category' =>  request('category'),
            'description' => $description,
            'expense_date' => date('Y-m-d', strtotime(request('expense_date')))
            
        ];
        $expense_id =  DB::table('expenses')->insertGetId($data);
      
    

        if(request('directory') == null) {
        
             if(request('directoryMul') != null) {
                $directory = request('directoryMul');
                $directoryData = [];
                foreach ($directory as $dir) {
                    $directoryData = [
                        'directory' => $dir,
                        'expense' =>  $expense_id,
                    ];
        
                    DB::table('expensedetail')->insert($directoryData);
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
            $directory_id =   DB::table('directory')->insertGetId($directoryData0);

            $directoryData = [
                'directory' => $directory_id ,
                'expense' =>  $expense_id,
            ];
            DB::table('expensedetail')->insert($directoryData);
        }
      
        if (request('account') != "00") {
            $this->balance(request('account'), request('amount'), "minus");
        }
        return redirect()->route('expense.index')->with('success','Thêm khoản chi thành công.');
    }
    
    public function balance($accountId, $amount, $action) {
        $account = DB::table('accounts')->where('id', $accountId)->first();
        $balance = ($action == "plus") ? $account->balance + $amount : $account->balance - $amount;
        DB::table('accounts')->where('id', $accountId)->update(["balance" => $balance]);
        return true;
    }


    public function edit(Request $request, $id) {
        $categories = $this->getCategories();
        // $categories = collect($categories1)->unique('name')->values()->all();
        $title = __('pages.sections.expenses');
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $expense = DB::table('expenses')->where('id', $id)->first();
        $directorys = DB::table('directory')
        ->leftJoin('expensedetail', 'expensedetail.directory', '=', 'directory.id')
        ->select('directory.name','expensedetail.expense','expensedetail.directory','directory.id')
        ->get();
        // $directorys = collect($directorys1)->unique('name')->values()->all();
        return view('/expense/edit', compact("expense", "accounts", "categories","title","directorys"));
    }

    public function update(Request $request) {
            if(request('description') == null) {
                $description = '';
            } else {
                $description = request('description');
            }
            $data = [
                'title' => request('title'),
                'amount' => request('amount'),
                'account' => request('account'),
                'category' =>  request('category'),
                'description' => $description,
                'expense_date' => date('Y-m-d', strtotime(request('expense_date')))
            ];
          
            $expense = DB::table('expenses')->where('id', $request->input('expenseid'))->first();
        
            if (!$expense) {
                return redirect()->back()->with('error', 'Income not found');
            }
        
            if (request('amount') != $expense->amount && $expense->account > 0) {
                // Thực hiện các thay đổi liên quan đến tài khoản
                $this->balance($expense->account, $expense->amount, "plus");
                $this->balance($expense->account, request('amount'), "minus");
            }
        
            DB::table('expenses')->where('id', $request->input('expenseid'))->update($data);

            if(request('directoryMul') == null) {
                $directoryValues = '';
                DB::table('expensedetail')
                ->where('expense', $request->input('expenseid'))
                ->delete();
              } else {
                $directoryValues = request('directoryMul');
                $directoryData = []; 
    
                DB::table('expensedetail')
                ->where('expense', $request->input('expenseid'))
                ->delete();
    
                foreach ($directoryValues as $dir) {
                
                  $directoryData = 
                    [
                    'directory' => $dir,
                    'expense' =>  $request->input('expenseid'),
                    ];
    
                 DB::table('expensedetail')->insert($directoryData);
                }
              }
            return redirect()->route('expense.index')->with('success','Cập nhật chi thành công.');
       
}

    public function destroy(Request $request)
    {
        $expense = DB::table('expenses')->where('id',  $request->input('expenseid'))->first();
        
        if (!empty($expense->account)) {
            $this->balance($expense->account, $expense->amount, "plus");
        }
      
        DB::table('expenses')->where('id',  $request->input('expenseid'))->delete();
    
        return redirect()->route('expense.index')->with('success','Xóa khoản chi thành công.');
    }
}
