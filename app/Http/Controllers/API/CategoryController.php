<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


            $account = auth('sanctum')->user()->account;
            Log::info(json_encode($account));
            $categories = $account->categories()->withCount(['operations', 'operations' => function (Builder $query) use ($account) {
                $query->where('account_id', $account->id);
            }])->get();
            Log::info(json_encode($categories));
            return $this->handleResponse(compact('categories'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $count_categrories_by_name = auth('sanctum')->user()->account->categories()->where('category_name', $request->category_name)->count();
        if ($count_categrories_by_name) {
            return $this->handleError(['Category Already Exists !'], 400);
        }
        try {
            DB::beginTransaction();

            $category = Category::create([
                'category_name' => $request->category_name,
                'category_type' => $request->category_type
            ]);
            DB::insert('insert into account_category (account_id, category_id) values (?, ?)', [auth('sanctum')->user()->account->id, $category->id]);
            DB::commit();
            return $this->handleResponse((new CategoryResource($category)), 'Category Added Successfully!');
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->handleError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $response = Gate::inspect('view', $category);
        if ($response->allowed()) {

            return $this->handleResponse((new CategoryResource($category)));
        }
        return $this->handleError($response->message(), 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $response = Gate::inspect('update', $category);
        if ($response->allowed()) {
            return $this->handleResponse((new CategoryResource($category)));
        }
        return $this->handleError($response->message(), 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, CategoryRequest $request)
    {
        $response = Gate::inspect('update', $category);

        if ($response->allowed()) {
            if (!$request->validated()) {
                return $this->handleError($request->errors(), 400);
            }
            $updatedRows = $category->update([
                'category_name' => $request->category_name,
                'category_type' => $request->category_type,
            ]);
            if ($updatedRows > 0) {

                return $this->handleResponse((new CategoryResource($category)), 'Category Updated Successfully!');
            }
            return $this->handleError('Category Updated Failed', 400);
        } else {
            return $this->handleError($response->message(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        $response = Gate::inspect('delete', $category);
        if ($response->allowed()) {

            try {
                //code...
                DB::beginTransaction();
                $category->delete();
                DB::delete('delete from account_category where account_id = ? and category_id = ?', [$request->user()->id, $category->id]);
                DB::commit();
                return $this->handleResponse((new CategoryResource($category)), 'Category Deleted Successfully!');
            } catch (Exception $ex) {
                DB::rollBack();
                return $this->handleError($ex->getMessage(), 400);
            }
        } else {
            return $this->handleError($response->message(), 401);
        }
    }
}
