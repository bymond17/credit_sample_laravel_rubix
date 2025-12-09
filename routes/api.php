<?php
use App\Http\Controllers\CreditPredictController;

Route::post('/predict', [CreditPredictController::class, 'predict']);