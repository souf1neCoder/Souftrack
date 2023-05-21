<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;
    protected $table = 'account_category';
    protected $fillable = ['account_id','category_id'];
    protected $primaryKey = 'id';
    public $incrementing = true;
}
