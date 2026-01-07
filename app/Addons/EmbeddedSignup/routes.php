<?php

use Illuminate\Support\Facades\Route;
use App\Addons\EmbeddedSignup\Controllers\EmbeddedSignupController;
Route::group(['prefix' => localeRoutePrefix() . '/client', 'middleware' => ['web', 'auth', 'verified','subscriptionCheck']], function () {
    Route::get('whatsapp/embedded-signup', [EmbeddedSignupController::class, 'index'])->name('client.whatsapp.embedded-signup');
    Route::post('whatsapp/embedded-signup/store', [EmbeddedSignupController::class, 'store'])->name('client.whatsapp.embedded-signup.store');
    Route::get('whatsapp/embedded-signup/access-token', [EmbeddedSignupController::class, 'getAccessClient'])->name('client.whatsapp.embedded-signup.access-token');
    Route::get('whatsapp/embedded-signup/sync/{id}', [EmbeddedSignupController::class, 'sync'])->name('client.whatsapp.embedded-signup.sync');
    Route::get('whatsapp/embedded-signup/delete/{id}', [EmbeddedSignupController::class, 'delete'])->name('client.whatsapp.embedded-signup.delete');
    Route::get('whatsapp/profile/edit/{id}', [EmbeddedSignupController::class, 'getBusinessProfileDetails'])->name('client.whatsapp.profile.edit');
    Route::post('whatsapp/profile/update/{id}', [EmbeddedSignupController::class, 'updateBusinessProfile'])->name('client.whatsapp.profile.update');
});
