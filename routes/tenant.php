<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

// Api
Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api/')->group(function () {
    Route::get('get_tenant', [ProductController::class, 'getTenant']);

    Route::get('get_all_product', [ProductController::class, 'getAllProduct']);
    Route::post('add_product', [ProductController::class, 'addProduct']);
    Route::get('get_single_product/{id}', [ProductController::class, 'getSingleProduct']);
    Route::post('update_product/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('delete_product/{id}', [ProductController::class, 'deleteProduct']);
});



// Views
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/{pathMatch}', function () {
        return view('tenant');
    })->where('pathMatch', ".*");
});
