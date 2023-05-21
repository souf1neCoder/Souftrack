<?php

namespace App\Http\Controllers\API;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\AccountResource;
use App\Http\Requests\UpdateBudgetRequest;
use App\Http\Requests\UpdateStartMonthRequest;

class AccountController extends Controller
{
   use HttpResponses;
  
   
   // 
   public function update(Request $request,Account $account){
      $response = Gate::inspect('update', $account);
      if ($response->allowed()) {
         $inputs = $request->validate([
            "budget"=>'numeric|gte:0',
            "start_month"=>'integer|gte:1|lte:28'
         ]);
         $account->update($inputs);
         return $this->handleResponse((new AccountResource($account)), 'Setting Updated Successfully!');
      }
      return $this->handleError($response->message(),401);
   }
}
