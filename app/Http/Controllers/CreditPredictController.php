<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rubix\ML\Classifiers\LogisticRegression;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;

class CreditPredictController extends Controller
{
    public function predict(Request $request)
    {
        // 샘플 데이터
        $samples = [
            [25, 3000, 500],
            [40, 8000, 2000],
            [35, 5000, 1000],
            [50, 12000, 3000],
            [23, 2500, 400],
            [60, 15000, 5000],
        ];
        $labels = ['1', '1', '1', '1', '0', '0'];

        // 모델 생성 및 학습
        $dataset = new Labeled($samples, $labels);
        $model = new LogisticRegression();
        $model->train($dataset);

        // 요청 데이터 받기
        $age = $request->input('age');
        $income = $request->input('income');
        $loan = $request->input('loan');

        if ($age && $income && $loan) {
            $test = new Unlabeled([[intval($age), intval($income), intval($loan)]]);
            $predictions = $model->predict($test);
            return response()->json(['result' => $predictions[0]]);
        } else {
            return response()->json(['error' => 'age, income, loan 필드가 필요합니다.'], 400);
        }
    }
    
    public function form(Request $request)
    {
        $result = null;
        if ($request->isMethod('post')) {
            $samples = [
                [25, 3000, 500],
                [40, 8000, 2000],
                [35, 5000, 1000],
                [50, 12000, 3000],
                [23, 2500, 400],
                [60, 15000, 5000],
            ];
            $labels = ['1', '1', '1', '1', '0', '0'];
            $dataset = new Labeled($samples, $labels);
            $model = new LogisticRegression();
            $model->train($dataset);

            $age = $request->input('age');
            $income = $request->input('income');
            $loan = $request->input('loan');
            if ($age && $income && $loan) {
                $test = new Unlabeled([[intval($age), intval($income), intval($loan)]]);
                $predictions = $model->predict($test);
                $result = $predictions[0] === '1' ? '승인' : '미승인';
            }
        }
        return view('main', ['result' => $result]);
    }
}