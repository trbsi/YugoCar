<?php

use App\Source\Public\App\Controllers\ContactController;
use App\Source\Public\App\Controllers\PublicController;
use App\Source\Ride\App\Controllers\RideController;

Route::get('/', [RideController::class, 'search'])->name('home');
Route::get('android', [PublicController::class, 'androidStore'])->name('android.store');
Route::get('iphone', [PublicController::class, 'iphoneStore'])->name('iphone.store');
Route::get('open-and-redirect/{route}', [PublicController::class, 'openAndRedirect'])->name('open-and-redirect');

Route::prefix('ride')->group(function () {
    Route::get('search', [RideController::class, 'search'])->name('ride.search');
});

Route::prefix('contact')->group(function () {
    Route::get('contact', [ContactController::class, 'contact'])->name('contact');
    Route::middleware('throttle:2,30')->post('send-message', [ContactController::class, 'sendMessage'])->name(
        'contact.send-message'
    );
});

Route::get('language/{locale}', [PublicController::class, 'changeLanguage'])->name('change.language');

//Route::get('/auth/redirect/{driver}', [SocialController::class, 'redirect'])->name('social_login.redirect');
//Route::get('/auth/callback/{driver}', [SocialController::class, 'callback'])->name('social_login.callback');
