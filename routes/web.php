<?php

use App\Http\Controllers\Admin\ChildController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorDashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/programs', 'programs')->name('programs');
Route::view('/contact', 'contact')->name('contact');
Route::view('/donate', 'donate')->name('donate');
Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DonorDashboardController::class, 'index'])->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
    Route::view('/volunteer', 'volunteer.dashboard')->name('volunteer.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::patch('/donations/{donation}/status', [AdminDonationController::class, 'updateStatus'])->name('donations.status');
    Route::get('/children', [ChildController::class, 'index'])->name('children.index');
    Route::post('/children', [ChildController::class, 'store'])->name('children.store');
    Route::delete('/children/{child}', [ChildController::class, 'destroy'])->name('children.destroy');
});
