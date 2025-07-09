<?php

use Newnet\Zone\Http\Controllers\Admin\CountryController;
use Newnet\Zone\Http\Controllers\Admin\ProvinceController;
use Newnet\Zone\Http\Controllers\Admin\DistrictController;
use Newnet\Zone\Http\Controllers\Admin\TownshipController;

Route::prefix('zone')
    ->name('zone.admin.')
    ->middleware('admin.acl')
    ->group(function () {
        Route::resource('country', CountryController::class);
        Route::resource('province', ProvinceController::class);
        Route::resource('district', DistrictController::class);
        Route::resource('township', TownshipController::class);
    });
