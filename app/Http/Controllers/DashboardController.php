<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
 
    public function index() {
        $stats = array();
        $title = __('pages.sections.overview');
        // $user = auth()->user();
        $user = Auth::user();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc('id')->get();
        $categories = DB::table('categories')->where('user', $user->id)->where('type', 'expense')->orderByDesc('id')->get();
        $incomecategories = DB::table('categories')->where('user', $user->id)->where('type', 'income')->orderByDesc('id')->get();
    
        foreach ($accounts as $account) {
            $incomeTransactions = DB::table('income')->where('account', $account->id)->count();
            $expenseTransactions = DB::table('expenses')->where('account', $account->id)->count();
            $account->transactions = $incomeTransactions + $expenseTransactions;
        }
    
        $stats['spent'] = DB::table('expenses')->where('user', $user->id)->whereMonth('expense_date', date("m"))->sum('amount');
        $stats['percentage'] = $user->monthly_spending > 0 ? round(($stats['spent'] / $user->monthly_spending) * 100) : 0;
        $stats['income'] = DB::table('income')->where('user', $user->id)->whereMonth('income_date', date("m"))->sum('amount');
 
        $stats['expenses'] = DB::table('expenses')->where('user', $user->id)->whereMonth('expense_date', date("m"))->sum('amount');
        $stats['savings'] = $stats['expenses'] > $stats['income'] ? 0 : $stats['income'] - $stats['expenses'];
        $stats['incomeTransactions'] = DB::table('income')->where('user', $user->id)->whereMonth('income_date', date("m"))->count();
        $stats['expenseTransactions'] = DB::table('expenses')->where('user', $user->id)->whereMonth('expense_date', date("m"))->count();
        $totalTransactions = $stats['incomeTransactions'] + $stats['expenseTransactions'];
    
        if ($totalTransactions > 0) {
            $stats['incomePercentage'] = round(($stats['incomeTransactions'] / $totalTransactions) * 100);
            $stats['expensePercentage'] = round(($stats['expenseTransactions'] / $totalTransactions) * 100);
        } else {
            $stats['incomePercentage'] = 0;
            $stats['expensePercentage'] = 0;
        }
    
        $reports = $this->reports(date('Y-m-d', strtotime('today - 30 days')) . ' 23:59:59', date('Y-m-d') . ' 00:00:00');

        return view('dashboard.index', compact("user", "accounts", "categories", "incomecategories", "title", "stats", "reports"));
    }


    public function reports($from, $to){
        $reports = [];
        // $user = auth()->user();
        $user = Auth::user();
        $range = $from . ' AND ' . $to;
    
        $reports['income']['total'] = DB::table('income')
            ->where('user', $user->id)
            ->whereBetween('income_date', [$from, $to])
            ->sum('amount');
    
        $reports['expenses']['total']= DB::table('expenses')
            ->where('user', $user->id)
            ->whereBetween('expense_date', [$from, $to])
            ->sum('amount');
     
        $reports['income']['count']= DB::table('income')
            ->where('user', $user->id)
            ->whereBetween('income_date', [$from, $to])
            ->count();
    
        $reports['expenses']['count'] = DB::table('expenses')
            ->where('user', $user->id)
            ->whereBetween('expense_date', [$from, $to])
            ->count();
    
        $reports['expenses']['top'] = DB::table('expenses')
            ->where('user', $user->id)
            ->whereBetween('expense_date', [$from, $to])
            ->orderByDesc('amount')
            ->limit(3)
            ->get();
            
        $begin = new \DateTime($from);
        $end = new \DateTime($to);
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval, $end);
    
        foreach ($daterange as $dt) {
            $dayStart = $dt->format("Y-m-d") . " 00:00:00";
            $dayEnd = $dt->format("Y-m-d") . " 23:59:59";
    
            $reports['chart']['label'][] = $dt->format("d F");
    
            $incomeTotal = DB::table('income')
                ->where('user', $user->id)
                ->whereBetween('income_date', [$dayStart, $dayEnd])
                ->sum('amount');
    
            $expensesTotal = DB::table('expenses')
                ->where('user', $user->id)
                ->whereBetween('expense_date', [$dayStart, $dayEnd])
                ->sum('amount');
    
            $reports['chart']['income'][] = $incomeTotal;
            $reports['chart']['expenses'][] = -1 * $expensesTotal;
        }
    
        return  $reports;
    }
  
    public function getreports(Request $request){
       
        // $from = request("from");
        // $to = request("to");
        $from = $request->input('start_date');
        $to = $request->input('end_date');
         $reports = $this->reports($from . ' 00:00:00', $to . ' 23:59:59');
        return response()->json([
            'status' => 'success',
            'error' => '',
            'warning' => '',
            'data' => $reports,
            'flag' => false
            ]);
     
        
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

        return redirect()->route('dashboard.index')->with('success','Thêm nguồn tiền thành công.');
    }
 
    public function edit($id) {
        $title = __('overview.overview-form.update-title');
        $account = DB::table('accounts')->where('id', $id)->first();
        return view('/dashboard/edit', compact("account","title"));
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

        return redirect()->route('dashboard.index')->with('success','Chỉnh sửa nguồn tiền thành công.');
    }
    public function destroy($id)
    {
        DB::table('accounts')->where('id', $id)->delete();
 
        return redirect()->route('dashboard.index')->with('success','Xóa nguồn tiền thành công.');
    }

}
