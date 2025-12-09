<?php
use App\Http\Controllers\CreditPredictController;

Route::match(['get', 'post'], '/', [CreditPredictController::class, 'form']);