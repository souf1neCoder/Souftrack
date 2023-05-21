<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','start_month','budget','account_image'];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    //operations
    public function operations(){
        return $this->hasMany(Operation::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
