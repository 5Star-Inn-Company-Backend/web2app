<?php

use App\Http\Controllers\AppsController;
use App\Http\Controllers\CreateAppController;
use App\Http\Controllers\ManageMemberController;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('build/{reference}', function ($reference){

    \App\Jobs\GetBuildJob::dispatch($reference)->delay(now()->addMinutes(2));

    return response()->json(['success'=>true, 'message'=>$reference]);
});


Route::apiResource('member', ManageMemberController::class)->middleware('auth:sanctum');

Route::post("app/convert/{app}", [MyController::class, "convert"])->middleware('auth:sanctum');

Route::apiResource("app", AppsController::class)->middleware('auth:sanctum');

Route::post('/upload', [\App\Http\Controllers\Api\StorageController::class, 'upload']);

Route::get('/cache-all', function () {
    // Clear caches
    // Artisan::call('config:clear');
    // Artisan::call('route:clear');
    // Artisan::call('view:clear');

    // Re-cache configurations, routes, and views
    //Artisan::call('config:cache');
    //Artisan::call('route:cache');
    //Artisan::call('view:cache');

    return 'All caches have been cleared and reset.';
});
