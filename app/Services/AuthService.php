<?php

namespace App\Services;
use Exception;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Traits\HttpResponses;
use App\Models\AccountCategory;
use Illuminate\Support\Facades\DB;

class AuthService{
    use HttpResponses;
    public function registreTransact($request){
        try {
            DB::beginTransaction();
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'username' => User::setUserName($request->fullname)
            ]);
            $account = Account::create([
                'user_id' => $user->id,
                'account_image' => 'https://avatars.dicebear.com/api/pixel-art-neutral/' . $user->username . '.svg'
            ]);
            Category::where('is_default',true)->get()->each(function ($category) use ($account) {
                AccountCategory::create([
                    'account_id'=>$account->id,
                    'category_id'=>$category->id,
                ]);
            });
            DB::commit();
            $token = $user->createToken('api token ' . $user->fullname)->plainTextToken;
            return $this->handleResponse($token, 'User register successfully');
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->handleError([$ex->getMessage()],400);
        }
    }
}
