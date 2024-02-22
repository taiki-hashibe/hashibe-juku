<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(\App\Http\Controllers\Guest\HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/legal', 'legal')->name('legal');
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/term', 'term')->name('term');
});

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::match(['GET', 'POST'], '/logout', 'logout')->name('logout');
    Route::get('/line-login', 'lineLogin')->name('line_login');
    Route::get('/line-callback', 'callback')->name('line_callback');
});

Route::name('line.')->prefix('line')->group(function () {
    Route::post('/webhook', [\App\Http\Controllers\Line\WebhookController::class, 'index'])->name('webhook');
    Route::name('step.')->middleware(['auth.user:users'])->prefix('/step')->controller(\App\Http\Controllers\Line\StepMessageController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::match(['GET', 'POST'], '/aewgrshtjky', 'step1')->name('step-1');
        Route::match(['GET', 'POST'], '/kuytyerswsg', 'step2')->name('step-2');
        Route::get('/questionnaire', 'questionnaireSuccess')->name('questionnaire_success');
        Route::get('/trial-lesson', 'trialLesson')->name('trial_lesson');
        Route::post('/trial-lesson-confirm', 'trialLessonConfirm')->name('trial-lesson-confirm');
        Route::post('/trial-lesson-submit', 'trialLessonSubmit')->name('trial-lesson-submit');
    });
});