<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    use HttpResponses;
    public function changePassword(ChangePasswordRequest $request, User $user){
        if(Hash::check($request->oldPassword,$user->password)){
            $user->update(['password'=>bcrypt($request->password)]);
            return $this->handleResponse(new UserResource($user),'Password Changed successfully');
        }
        return $this->handleError(['Password incorrect'],403);
    }
}
