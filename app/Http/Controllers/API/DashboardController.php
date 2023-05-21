<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use App\Services\OperationService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    use HttpResponses;
    public function __construct(private OperationService $operationService){}
    public function startUp(Request $request){

        $account =auth('sanctum')->user()->account;
        // set date settings
        $start_of_month = $account->start_month;
        $now = Carbon::now();
        $nowNextMonth = Carbon::now()->addMonth();
        $start_date = Carbon::createFromFormat('d/m/Y', "$start_of_month/$now->month/$now->year");
        $end_date = Carbon::createFromFormat('d/m/Y',"$start_of_month/$nowNextMonth->month/$nowNextMonth->year");
        // get data from service
        $opertaionsLast60Days = $this->operationService->dashboard($start_date,$end_date,$account->id)['opertaionsLast60Days'];
        $incomeLastMonth = $this->operationService->dashboard($start_date,$end_date,$account->id)['incomeLastMonth'];
        $expensesLastMonth = $this->operationService->dashboard($start_date,$end_date,$account->id)['expensesLastMonth'];
       return $this->handleResponse(compact("expensesLastMonth","incomeLastMonth","opertaionsLast60Days","start_date"));

    }
}
