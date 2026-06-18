<?php

use App\Http\Controllers\Api\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/payments/webhook', WebhookController::class)->name('api.webhook');
