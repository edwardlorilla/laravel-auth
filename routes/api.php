<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', 'UserController')->except(['show']);
    Route::apiResource('log-activity', 'LogActivityController')->except(['show']);
    Route::apiResource('announcements', 'AnnouncementController')->except(['show']);
    Route::apiResource('performances', 'PerformanceController')->except(['show']);
    Route::apiResource('documents', 'DocumentController')->except(['show']);
    Route::apiResource('categories', 'CategoryController')->except(['show']);
    Route::apiResource('files', 'FileController')->except(['show']);
    Route::apiResource('transactions', 'TransactionController')->except(['show']);
    Route::apiResource('contributions', 'ContributionController')->except(['show']);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json(\App\User::whereId(auth()->user()->id)->with(['photo', 'contributions' => function ($query) {
        $query->where('user_id', auth()->user()->id)->with('transaction', 'user:id,email,first_name,last_name');
    }, 'performances' => function ($query) {
        $query->where('user_id', auth()->user()->id);
    }])->first());
});
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');

// Password reset link request routes...
Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');