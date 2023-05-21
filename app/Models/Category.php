<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['category_name','category_type'];
    // Operations
    public function operations(){
        return $this->hasMany(Operation::class);
    }
    // Accounts
    public function accounts(){
        return $this->belongsToMany(Account::class);
    }
    // scope help us get sum by category
    public function scopeCategoriesWithSumOperations($query,$account_id,$category_type,$start_date,$end_date){
        return $query->where('category_type',$category_type)
        ->whereRelation('accounts','accounts.id',$account_id)
        ->whereRelation('operations','operations.account_id',$account_id)
        ->withSum(['operations'=>function($q) use ($account_id,$start_date,$end_date){
            $q->where('account_id',$account_id)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }],'amount');
    }
}
