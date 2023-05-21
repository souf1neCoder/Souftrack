<?php

namespace App\Http\Controllers\API;

use App\Models\Operation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\OperationRequest;
use App\Http\Resources\OperationResource;
use App\Traits\HttpResponses;
class OperationController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OperationRequest $request)
    {
        
        $operation = Operation::create([
            'amount'=>$request->amount,
            'category_id'=>$request->category_id,
            'remark'=>$request->remark,
            'account_id'=>$request->user()->account->id
        ]);
        return $this->handleResponse(new OperationResource($operation),'Operation Added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Operation $operation)
    {
        $response = Gate::inspect('view', $operation);
        if ($response->allowed()) {
        return $this->handleResponse(new OperationResource($operation),'');
        }
        return $this->handleError($response->message(),401);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Operation $operation)
    {
        $response = Gate::inspect('update', $operation);

        if ($response->allowed()) {
        return $this->handleResponse(new OperationResource($operation),'');
        // return $this->handleResponse($operation->with('categories'),'');
        }
        return $this->handleError($response->message(),401);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(OperationRequest $request, Operation $opr)
    public function update(OperationRequest $request,Operation $operation)
    {
        $response = Gate::inspect('update', $operation);
        if ($response->allowed()) {
        $operation->update([
            'remark'=>$request->remark,
            'category_id'=>$request->category_id,
            'amount'=>$request->amount
        ]);
        return $this->handleResponse(new OperationResource($operation),'Operation Updated successfully!');
    }
    return $this->handleError($response->message(),401);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation)
    {
        $response = Gate::inspect('delete', $operation);
        if ($response->allowed()) {
        
 
        $operation->delete();
        
        return $this->handleResponse(new OperationResource($operation),'Operation Deleted successfully!');
        }
    return $this->handleError($response->message(),401);



    }
    // 
   
   
}
