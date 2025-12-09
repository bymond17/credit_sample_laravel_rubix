<?php

namespace App\Services;

use Rubix\ML\Datasets\Unlabeled;

class CreditPredictService
{
    protected $model;

    public function __construct()
    {
        $modelPath = __DIR__ . '/../../Models/credit_model.rbx';
        
        // 모델 파일이 없으면 학습
        if (!file_exists($modelPath)) {
            $dir = dirname($modelPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            CreditModelTrainer::trainAndSave($modelPath);
        }
        
        $this->model = CreditModelTrainer::load($modelPath);
    }

    public function predict($age, $income, $loan)
    {
        $test = new Unlabeled([[intval($age), intval($income), intval($loan)]]);
        $predictions = $this->model->predict($test);
        return $predictions[0];
    }
}