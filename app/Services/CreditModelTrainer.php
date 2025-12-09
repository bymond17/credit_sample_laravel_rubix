<?php
namespace App\Services;

use Rubix\ML\Classifiers\MultilayerPerceptron;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\Dropout;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\NeuralNet\ActivationFunctions\HyperbolicTangent;
use Rubix\ML\NeuralNet\Layers\BatchNorm;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Serializers\Native;

class CreditModelTrainer
{
    public static function trainAndSave($modelPath = __DIR__ . '/../../Models/credit_model.rbx')
    {
        $samples = [];
        $labels = [];
        for ($i = 0; $i < 3000; $i++) {
            $age = rand(20, 65);
            $income = rand(2000, 20000);
            $loan = rand(100, 7000);
            $approved = ($income >= $loan * 2) ? '1' : '0';
            $samples[] = [$age, $income, $loan];
            $labels[] = $approved;
        }
        $dataset = new Labeled($samples, $labels);

        $model = new MultilayerPerceptron([
            new Dense(32),
            new Activation(new ReLU()),
            new BatchNorm(),
            new Dropout(0.3),
            new Dense(16),
            new Activation(new ReLU()),
            new BatchNorm(),
            new Dropout(0.2),
            new Dense(8),
            new Activation(new HyperbolicTangent()),
        ], 256, new Adam(0.001), 1e-4, 100);

        $model->train($dataset);

        $serializer = new Native();
        $encoding = $serializer->serialize($model);

        $persister = new Filesystem($modelPath);
        $persister->save($encoding);
    }

    public static function load($modelPath = __DIR__ . '/../../Models/credit_model.rbx')
    {
        $persister = new Filesystem($modelPath);
        $encoding = $persister->load();

        $serializer = new Native();
        return $serializer->deserialize($encoding);
    }
}