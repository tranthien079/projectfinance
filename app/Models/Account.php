<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $fillable = [
    'id',
    'user',
    'name',
    'balance',
    'type',
    'status',
    'created_at',
    'updated_at',
    ];
    public function expenses()
    {
        return $this->hasMany(Expense::class,'account','id');
    }
}
