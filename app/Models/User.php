<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'username',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //
    public function account(){
        return $this->hasOne(Account::class);
    }
    //
    static public  function setUserName($value):string{
        $genUserName = explode(' ',strtolower($value),2);
        $username = '';
        if(count($genUserName) == 2){
            $username = $genUserName[0][0] . trim($genUserName[1]);
        }else{
            $username = $genUserName[0][0];
        }
        $i = 0;
        while(User::whereUsername($username)->exists()) {
            $i++;
            $username .= $i;
        }
        return '@' . $username;
    }
    /**
 * Send a password reset notification to the user.
 *
 * @param  string  $token
 * @return void
 */
    public function sendPasswordResetNotification($token)
    {
        // $url = 'http://127.0.0.1:8000/reset-password?token='. $token;
        // $this->notify(new ResetPasswordNotification($url));
    }
}
