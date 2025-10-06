<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OtpController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\v1\PlanController;
use App\Http\Controllers\Api\v1\RefundController;
use App\Http\Controllers\Api\V1\SocialController;
use App\Http\Controllers\Api\v1\SubscriptionController;
use App\Http\Controllers\Api\V1\PasswordResetController;
use App\Http\Controllers\Api\v1\StripeWebhookController;
use App\Http\Controllers\Api\V1\InvitationLinkController;
use App\Http\Controllers\UserGuideController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/otp/send', [OtpController::class, 'sendOtp']);
    Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
    Route::Post('/social-login', [SocialController::class, 'socialLogin']);
});

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('/send-invitation', [InvitationLinkController::class, 'sendInvitation'])->middleware('permission:send.invite');
});



Route::get('/register/invite/{token}', [InvitationLinkController::class, 'registerWithInvitation']);
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::group([],function () {
    Route::get('/plans', [PlanController::class, 'index']);        // list all plans
    Route::post('/plans', [PlanController::class, 'store']);       // create plan in Stripe + DB
    Route::get('/plans/{plan}', [PlanController::class, 'show']);  // get single plan
    Route::put('/plans/{plan}', [PlanController::class, 'update']); // update plan
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy']); // delete plan
});


Route::group(["middleware" => "auth:api"],function () {
    Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'subscribe']); // subscribe to plan
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'cancel']); // cancel subscription

    // Refund Requests
    Route::post('/refund-requests', [RefundController::class, 'store']); // user request refund
    Route::get('/refund-requests', [RefundController::class, 'index']);  // user refund requests
});


Route::group([],function () {
    Route::get('/admin/refund-requests', [RefundController::class, 'adminIndex']); // list all
    Route::put('/admin/refund-requests/{id}/approve', [RefundController::class, 'approve']); 
    Route::put('/admin/refund-requests/{id}/reject', [RefundController::class, 'reject']);  
});

// User Guides Routes
Route::group(['prefix' => 'user-guides'], function () {
    Route::get('/', [UserGuideController::class, 'index']); // Get all user guides with filters
    Route::get('/{audience}/{contentType}', [UserGuideController::class, 'getByAudienceAndType']); // Get guides by audience and type
    Route::get('/{userGuide}', [UserGuideController::class, 'show']); // Get single user guide
    Route::post('/', [UserGuideController::class, 'store']); // Create user guide
    Route::put('/{userGuide}', [UserGuideController::class, 'update']); // Update user guide
    Route::delete('/{userGuide}', [UserGuideController::class, 'destroy']); // Delete user guide
});