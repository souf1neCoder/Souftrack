<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Category;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\OperationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class StatisticsController extends Controller
{
    use HttpResponses;

    public function __construct(private OperationService $operationService){}


    public function index()
    {
        $account = auth('sanctum')->user()->account;
        // set date settings
        $start_of_month = $account->start_month;
        $now = Carbon::now();
        $nowNextMonth = Carbon::now()->addMonth();
        $start_date = Carbon::createFromFormat('d/m/Y', "$start_of_month/$now->month/$now->year");
        $end_date = Carbon::createFromFormat('d/m/Y',"$start_of_month/$nowNextMonth->month/$nowNextMonth->year");
        //  get data from category model
        $circleExp = Category::CategoriesWithSumOperations($account->id,'expense',$start_date,$end_date)->get();
        $circleInc = Category::CategoriesWithSumOperations($account->id,'income',$start_date,$end_date)->get();
        // get data from operation service
        $expensesSumByMonth = $this->operationService->SumAmountByCategories($account,'expense');
        $incomeSumByMonth = $this->operationService->SumAmountByCategories($account,'income');


        return $this->handleResponse(compact('circleExp','circleInc','expensesSumByMonth','incomeSumByMonth'));
    }
}
