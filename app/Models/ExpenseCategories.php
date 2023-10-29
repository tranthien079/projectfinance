<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategories extends Model
{
    use HasFactory;
    protected $table = 'category_expense';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_category',
        'id_expense'
    ];
    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'id_category','id');
    }
}
