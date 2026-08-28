<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/programs', 'programs')->name('programs');
Route::view('/contact', 'contact')->name('contact');
Route::view('/donate', 'donate')->name('donate');

Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');
