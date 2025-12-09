<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CreditPredictService;

class CreditPredictController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new CreditPredictService();
    }

    public function predict(Request $request)
    {
        $age = $request->input('age');
        $income = $request->input('income');
        $loan = $request->input('loan');

        if ($age && $income && $loan) {
            $result = $this->service->predict($age, $income, $loan);
            return response()->json(['result' => $result]);
        } else {
            return response()->json(['error' => 'age, income, loan 필드가 필요합니다.'], 400);
        }
    }

    public function form(Request $request)
    {
        $result = null;
        if ($request->isMethod('post')) {
            $age = $request->input('age');
            $income = $request->input('income');
            $loan = $request->input('loan');
            if ($age && $income && $loan) {
                $result = $this->service->predict($age, $income, $loan) === '1' ? '승인' : '미승인';
            }
        }
        return view('main', ['result' => $result]);
    }
}