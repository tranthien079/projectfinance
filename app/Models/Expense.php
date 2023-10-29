<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $fillable = [
    'id',
    'user',
    'title',
    'amount',
    'account',
    'expense_date',
    'updated_at',
    ];
    public function expenseDetail()
    {
        return $this->hasMany(ExpenseCategories::class, 'id_expense','id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class)->select(['id', 'name']);;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
