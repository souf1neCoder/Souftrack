<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class OperationService
{

    public function  SumAmountByCategories($account, $categroy_type)
    {
        // get sum by month
        $data = $account->operations()->whereRelation('categories', 'category_type', $categroy_type)->whereYear('created_at', date('Y'))->get()->groupBy(function ($d) {
            return Carbon::parse($d->created_at)->format('m');
        })->map(function ($row) {
            return $row->sum('amount');
        });
        // merge data with other months
        $allMonths = collect();
        for ($i = 1; $i <= 12; $i++) {
            $allMonths->put(str_pad($i, 2, '0', STR_PAD_LEFT), 0);
        }
        $data = $allMonths->merge($data)->values();
        $result = collect();
        // transform data 
        $data->each(function ($val, $i) use ($result) {
            $result->put(str_pad($i + 1, 2, '0', STR_PAD_LEFT), $val);
        });
        Log::info(json_encode($result));
        return $result;
    }
    //
    public function search(Request $request, $account)
    {
        $operations = collect([]);
        if ($request->filled('search_term')) {
            $operations = Operation::where('remark', 'like', '%' . $request->search_term . '%')->orWhere('amount', 'like', '%' .  $request->search_term . '%')->with('categories')->get()->filter(function ($opr) use ($account) {
                return $opr->account_id === $account->id;
            });
        } else if ($request->filled('category_id')) {

            $operations = Operation::where('category_id', $request->category_id)->where('account_id', $account->id)->with('categories')->get();
        }
        return $operations;
    }

    //
    public function dashboard($start_date, $end_date, $id)
    {
        $opertaionsLast60Days =  Operation::where('account_id', $id)->where('created_at', '>=', Carbon::now()->subDays(60))->with('categories')->orderBy('created_at', 'desc')->get();
        $expensesLastMonth = Operation::whereRelation('categories', 'category_type', 'expense')->where('account_id', $id)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('amount');
        $incomeLastMonth = Operation::whereRelation('categories', 'category_type', 'income')->where('account_id', $id)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('amount');
        return compact('opertaionsLast60Days', 'expensesLastMonth', 'incomeLastMonth');
    }
}
