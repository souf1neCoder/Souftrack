<?php

namespace App\Http\Controllers\API;

use App\Models\Operation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Services\OperationService;
use App\Traits\HttpResponses;

class SearchController extends Controller
{
    use HttpResponses;
    public function __construct(private OperationService $operationsService)
    {
        
    }
    public function __invoke(Request $request)
    {
        $account = auth('sanctum')->user()->account;
        // get data from operation service
        $operations  = $this->operationsService->search($request,$account);
        // return
        return $this->handleResponse(compact("operations"));
    }
}
