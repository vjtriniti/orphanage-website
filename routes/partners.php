<?php

use App\Http\Controllers\Admin\PartnerController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsurePermission;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', EnsureAdmin::class, EnsureTwoFactor::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/partners', [PartnerController::class, 'index'])
            ->middleware(EnsurePermission::class . ':content.manage')
            ->name('partners.index');
        Route::post('/partners', [PartnerController::class, 'store'])
            ->middleware(EnsurePermission::class . ':content.manage')
            ->name('partners.store');
        Route::put('/partners/{partner}', [PartnerController::class, 'update'])
            ->middleware(EnsurePermission::class . ':content.manage')
            ->name('partners.update');
        Route::delete('/partners/{partner}', [PartnerController::class, 'destroy'])
            ->middleware(EnsurePermission::class . ':content.manage')
            ->name('partners.destroy');
    });
