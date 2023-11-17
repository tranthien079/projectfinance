<?php

use App\Models\Expense;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BookbankController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AuthenticateMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// LOGIN REGISTER LOGOUT
Route::get('/signin',[AuthController::class,'index'])->name('auth.signin')->middleware('signin');
Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
Route::post('/login',[AuthController::class,'login'])->name('auth.login');
Route::post('/signup',[AuthController::class,'signup'])->name('auth.signup');

Route::get('setLocale/{locale}', function ($locale) {
    if (in_array($locale, Config::get('app.locales'))) {
      Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('app.setLocale');

Route::group(array('middleware' => AuthenticateMiddleware::class), function() 
{
        // DASHBOARD or OVERVIEW
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.index');
        Route::get('/dashboard/report',[DashboardController::class,'getreports'])->name('dashboard.getreports');

        Route::get('/setting',[SettingController::class,'index'])->name('setting.index');
        Route::post('/setting/add',[SettingController::class,'add'])->name('setting.add');
        Route::delete('/setting/destroy/{id}', [SettingController::class,'destroy'])->name('setting.destroy');

        // //ACCOUNT
        Route::post('/dashboard/add',[DashboardController::class,'create'])->name('dashboard.create');
        Route::post('/dashboard/update', [DashboardController::class,'update'])->name('dashboard.update');
        Route::get('/dashboard/edit/{id}', [DashboardController::class,'edit'])->name('dashboard.edit');
        Route::delete('/dashboard/destroy/{id}', [DashboardController::class,'destroy'])->name('dashboard.destroy');

        Route::get('/account',[AccountController::class,'index'])->name('account.index');
        Route::post('/account/add',[AccountController::class,'create'])->name('account.create');
        Route::post('/account/update', [AccountController::class,'update'])->name('account.update');
        Route::get('/account/edit/{id}', [AccountController::class,'edit'])->name('account.edit');
        Route::delete('/account/destroy/{id}', [AccountController::class,'destroy'])->name('account.destroy');
        // BUDGET 
        Route::get('/budget',[BudgetController::class,'index'])->name('budget.index');
        Route::post('/budget/adjust',[BudgetController::class,'adjust'])->name('budget.adjust');
        Route::post('/budget/add',[BudgetController::class,'add'])->name('budget.add');
        Route::post('/budget/update', [BudgetController::class,'update'])->name('budget.update');
        Route::get('/budget/edit/{id}', [BudgetController::class,'edit'])->name('budget.edit');
        Route::delete('/budget/destroy/{id}', [BudgetController::class,'destroy'])->name('budget.destroy');

        //INCOME
        Route::get('/income', [IncomeController::class,'index'])->name('income.index');
        Route::post('/income/add', [IncomeController::class,'add'])->name('income.add');
        Route::post('/income/update', [IncomeController::class,'update'])->name('income.update');
        Route::get('/income/edit/{id}', [IncomeController::class,'edit'])->name('income.edit');
        Route::delete('/income/destroy/{id}', [IncomeController::class,'destroy'])->name('income.destroy');
       
        // Expenses
        Route::get('/expense', [ExpenseController::class,'index'])->name('expense.index');
        Route::post('/expense/add', [ExpenseController::class,'add'])->name('expense.add');
        Route::post('/expense/update', [ExpenseController::class,'update'])->name('expense.update');
        Route::get('/expense/edit/{id}', [ExpenseController::class,'edit'])->name('expense.edit');
        Route::delete('/expense/destroy/{id}', [ExpenseController::class,'destroy'])->name('expense.destroy');
        
        // Route::get('/bookbank',[BookbankController::class,'index'])->name('bookbank.index');
        Route::get('/bookbank', [BookbankController::class,'index'])->name('bookbank.index');
        Route::post('/bookbank/add', [BookbankController::class,'add'])->name('bookbank.add');
        Route::post('/bookbank/update', [BookbankController::class,'update'])->name('bookbank.update');
        Route::get('/bookbank/edit/{id}', [BookbankController::class,'edit'])->name('bookbank.edit');
        Route::delete('/bookbank/destroy/{id}', [BookbankController::class,'destroy'])->name('bookbank.destroy');
        Route::get('/bookbank/settle/{id}', [BookbankController::class,'settle'])->name('bookbank.settle');
        Route::post('/bookbank/updatesettle', [BookbankController::class,'updatesettle'])->name('bookbank.updatesettle');
});
