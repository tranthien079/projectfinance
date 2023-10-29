<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Income;
use App\Models\Account;
use App\Models\Expense;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{

public function index() {
    $stats = array();
    $title = __('pages.sections.budget');
    $user = Auth::user();
    $cashlimit = DB::table('cashlimit')
    ->leftJoin('categories', 'categories.id', '=', 'cashlimit.category')
    ->select('cashlimit.id','cashlimit.category','cashlimit.startday','cashlimit.endday','cashlimit.title')
    ->get();
    $accounts = Account::where('user', $user->id)->orderBy("id")->get();
    $categories1 = Category::where('user', $user->id)->where('type', 'expense')->orderBy("id")->get();
    $incomecategories = Category::where('user', $user->id)->where('type', 'income')->orderBy("id")->get();
    $categories = $this->getCategories();
    $stats['allocated'] = Category::where('user', $user->id)->sum("budget");
    $stats['spent'] = Expense::where('user', $user->id)
                            ->whereMonth('expense_date', date("m"))
                            ->sum('expenses.amount');

    if ($user->monthly_spending > 0) {
        $stats['percentage'] = round(($stats['spent'] / $user->monthly_spending) * 100);
    } else {
        $stats['percentage'] = 0;
    }

    $budgets = Category::leftJoin("cashlimit", "categories.id", "=", "cashlimit.category")->where("user", $user->id)->where('type', 'expense')->get();
    
    $budgets1 = Category::where("user", $user->id)->where('type', 'expense')->get();
  
    foreach ($budgets1 as $budget) {
            $budget->spent = Expense::leftJoin("category_expense", "expenses.id", "=", "category_expense.id_expense")
                            ->leftJoin("categories", "category_expense.id_category", "=", "categories.id")
                            ->leftJoin("cashlimit", "categories.id", "=", "cashlimit.category")
                            ->where('category_expense.id_category', $budget->id)
                            ->whereBetween('expenses.expense_date', ['cashlimit.startday', 'cashlimit.endday'])
                            ->sum('expenses.amount');
        $budget->lastmonth = Expense::leftJoin("accounts", "expenses.account", "=", "accounts.id")
                        ->leftJoin("category_expense", "expenses.id", "=", "category_expense.id_expense")
                        ->leftJoin("categories", "category_expense.id_category", "=", "categories.id")
                        ->leftJoin("cashlimit", "categories.id", "=", "cashlimit.category")
                        ->where('category_expense.id_category', $budget->id)
                        ->whereBetween('expenses.expense_date', ['cashlimit.startday', 'cashlimit.endday'])
                        ->sum('expenses.amount');
        $budget->transactions = Expense::leftJoin("accounts", "expenses.account", "=", "accounts.id")
                            ->leftJoin("category_expense", "expenses.id", "=", "category_expense.id_expense")
                            ->leftJoin("categories", "category_expense.id_category", "=", "categories.id")
                            ->leftJoin("cashlimit", "categories.id", "=", "cashlimit.category")
                            ->where('category_expense.id_category', $budget->id)
                            ->whereBetween('expenses.expense_date', ['cashlimit.startday', 'cashlimit.endday'])
                            ->count();
        if ($budget->budget > 0) {
            $budget->percentage = round(($budget->spent / $budget->budget) * 100);
        } else {
            $budget->percentage = 0;
        }
        // Chart data
        // $stats['thismonth'][] = "{value:" . $budget->spent . ", name:'" . $budget->name . "'}";
        // $stats['lastmonth'][] = "{value:" . $budget->lastmonth . ", name:'" . $budget->name . "'}";
        $stats['thismonth'][] = [
            'value' => $budget->spent,
            'name' => $budget->name,
        ];
        $stats['lastmonth'][] = [
            'value' => $budget->lastmonth,
            'name' => $budget->name,
        ];
    }
    return view('budget.index', compact("title", "user", "stats", "accounts", "categories", "incomecategories", "budgets","cashlimit","budgets1")); 
  }

  public function getCategories() {
    $user = Auth::user();
    $categories = DB::table('categories')
    ->where('user', $user->id)
    ->where('categories.type', 'expense')
    ->orderByDesc("categories.id")
    ->get();

    $listCategories = [];
    Category::recursive($categories, $parents = 0, $level = 1, $listCategories );
 
    return  $listCategories;
}

  public function add(Request $request) {
    $category = request('category');
    if ($category) {
        foreach ($category as $cat) {
            $data = [
                'title' => request('title'),
                'amountlimit' => request('amount'),
                'account' => request('account'),
                'category' => $cat,
                'startday' => date('Y-m-d', strtotime(request('start_date'))),
                'endday' => date('Y-m-d', strtotime(request('end_date'))),
            ];
            Category::where('id', $cat)->update(['budget' => request('amount')]);
            $limit_id =  DB::table('cashlimit')->insertGetId($data);
        }
    }

   
    return redirect()->route('budget.index')->with('success','Thêm hạn mức chi thành công');
  }

  public function edit(Request $request, $id) {
     $title = __('pages.sections.budget');
     $user = Auth::user();
     $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
     $cashlimit = DB::table('cashlimit')
    ->leftJoin('categories', 'categories.id', '=', 'cashlimit.category')
    ->where('cashlimit.id', $id)
    ->select('cashlimit.id','cashlimit.title','cashlimit.amountlimit','cashlimit.account','cashlimit.category','cashlimit.startday','cashlimit.endday')
    ->first();
    $categories = $this->getCategories();   
    return view('/budget/edit', compact("cashlimit", "accounts", "categories","title"));
  }

  public function update(Request $request) {
    $categories = $request->input('category', []);

    foreach ($categories as $cat) {
        $data = [
            'title' => $request->input('title'),
            'amountlimit' => $request->input('amount'),
            'account' => $request->input('account'),
            'category' => $cat,
            'startday' => date('Y-m-d', strtotime($request->input('startday'))),
            'endday' => date('Y-m-d', strtotime($request->input('endday')))
        ];
      
        Category::where('id', $cat)->update(['budget' => $request->input('amount')]);

        // Assuming cashlimit has a 'budget' field that you want to update
        $limit = DB::table('cashlimit')->where('id', $request->input('cashid'))->first();
      
        // Assuming cashlimit table contains the fields you're trying to update
        
        DB::table('cashlimit')->where('id', $request->input('cashid'))->update($data);
    }

    return redirect()->route('budget.index')->with('success', 'Cập nhật hạn mức chi thành công.');
}

  public function destroy(Request $request)
  {
      $cashid = $request->input('cashid');
      $category = $request->input('category');
  
      $limit = DB::table('cashlimit')->where('id', $cashid)->first();
  
      if ($limit) {
          DB::table('cashlimit')->where('id', $cashid)->delete();
          Category::where('id', $category)->update(['budget' => 0]);
          return redirect()->route('budget.index')->with('success', 'Xóa hạn mức chi thành công.');
      } else {
          return redirect()->route('budget.index')->with('error', 'Không tìm thấy hạn mức chi.');
      }
  }

  public function balance($accountId, $amount, $action) {
    $account = DB::table('accounts')->where('id', $accountId)->first();
    $balance = ($action == "plus") ? $account->balance + $amount : $account->balance - $amount;
    DB::table('accounts')->where('id', $accountId)->update(["balance" => $balance]);
    return true;
}


  public function adjust(Request $request) {
    $user = Auth::user();
    $goals = [
        'monthly_spending' => $request->input('monthly_spending'),
        'annual_spending' => $request->input('annual_spending'),
        'monthly_saving' => $request->input('monthly_saving'),
        'monthly_earning' => $request->input('monthly_earning')
    ];

    User::where('id', $user->id)->update($goals);

    // Update amount trong bang Category
    if ($request->has('category')) {
        foreach ($request->input('category') as $index => $category) {
            Category::where('id', $category)->update(['budget' => $request->input('budget')[$index]]);
        }
    }

    // return response()->json(['status' => 'success', 'message' => __('pages.messages.alright'), 'data' => __('budget.messages.adjust-success'), 'action' => 'reload()']);
    return redirect()->route('budget.index')->with('success','Thiếp lập thành công.');
}
}
    // public function index() {
    //     $stats = array();
    //     $title = __('pages.sections.budget');
    //     $user = Auth::user();
    //     $accounts = DB::table('accounts')->where('user', $user->id)->orderBy("id")->get();
    //     $categories = DB::table('categories')->where('user',$user->id)->where('type','expense')->orderBy("id")->get();
    //     $incomecategories = DB::table('categories')->where('user',$user->id)->where('type','income')->orderBy("id")->get();
    //     $stats['allocated'] = DB::table('categories')->where('user', $user->id)->sum("budget", "total")[0]->total;
    //     $stats['spent'] = DB::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
    //     if ($user->monthly_spending > 0) {
    //       $stats['percentage'] = round(($stats['spent'] / $user->monthly_spending) * 100);
    //     }else{
    //       $stats['percentage'] = 0;
    //     }
    //     $budgets = DB::table('categories')->where("user", $user->id)->where('type','expense')->get();
    //     $budget = new StdClass();
    //     foreach($budgets as $budget){
    //         $budget->spent = DB::table('expenses')->where('category', $budget->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
    //         $budget->lastmonth = DB::table('expenses')->where('category', $budget->id)->where('MONTH(`expense_date`)', date("m") - 1)->sum('amount','total')[0]->total;
    //         $budget->transactions = DB::table('expenses')->where('category', $budget->id)->where('MONTH(`expense_date`)', date("m"))->count('id','total')[0]->total;
    //         if ($budget->budget > 0) {
    //           $budget->percentage = round(($budget->spent / $budget->budget) * 100);
    //         }else{
    //           $budget->percentage = 0;
    //         }

    //         // Chart data
    //         $stats['thismonth'][] = "{value:".$budget->spent.", name:'".$budget->name."'}";
    //         $stats['lastmonth'][] = "{value:".$budget->lastmonth.", name:'".$budget->name."'}";
    //     }
        
    //     return view('dashboard.index',compact("title","user","stats","accounts","categories","incomecategories",'budgets'));
    // }

