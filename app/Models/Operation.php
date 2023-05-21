<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = ['amount','account_id','category_id','remark'];
    // Categories
    public function categories(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    // Account
    public function Account(){
        return $this->belongsTo(Account::class);
    }
}
