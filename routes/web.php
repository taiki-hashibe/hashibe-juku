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

Route::controller(\App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
});

Route::get('/ir/{key}', [\App\Http\Controllers\InflowRouteController::class, 'index'])->name('inflow-route');

Route::name('category.')->controller(\App\Http\Controllers\CategoryController::class)->group(function () {
    Route::get('/category/{category}', 'index')->name('index');
});

Route::name('post.')->prefix('post')->controller(\App\Http\Controllers\PostController::class)->group(function () {
    Route::get('/content/{post}', 'post')->name('post');
    Route::get('/{category}/{post}', 'index')->name('category');
});

Route::name('curriculum.')->controller(\App\Http\Controllers\CurriculumController::class)->group(function () {
    Route::get('/curriculum/{curriculum:slug}', 'index')->name('index');
    Route::get('/curriculum/post/{curriculum:slug}', 'post')->name('post');
});

Route::name('register.')->prefix('register')->controller(\App\Http\Controllers\RegisterController::class)->group(function () {
    Route::get('/guidance', 'guidance')->name('guidance');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::controller(\App\Http\Controllers\User\AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::match(['GET', 'POST'], '/logout', 'logout')->name('logout');
        Route::get('/line-login', 'lineLogin')->name('line-login');
        Route::get('/line-callback', 'callback')->name('line-callback');
    });
    Route::middleware(['auth.user:users'])->group(function () {
        Route::controller(\App\Http\Controllers\User\HomeController::class)->group(function () {
            Route::get('', 'index')->name('home');
        });
        Route::name('post.')->prefix('post')->controller(\App\Http\Controllers\User\PostController::class)->group(function () {
            Route::get('/content/{post:slug}', 'post')->name('post');
            Route::get('/{category:slug}/{post:slug}', 'index')->name('category');
            Route::post('/trial-viewing', 'trialViewing')->name('trial-viewing');
        });
        Route::name('category.')->controller(\App\Http\Controllers\User\CategoryController::class)->group(function () {
            Route::get('/category/{category:slug}', 'index')->name('index');
        });
        Route::name('curriculum.')->controller(\App\Http\Controllers\User\CurriculumController::class)->group(function () {
            Route::get('/curriculum/{curriculum:slug}', 'index')->name('index');
            Route::get('/curriculum/post/{curriculum:slug}/{post:slug}', 'post')->name('post');
        });
        Route::get('/bookmark', [\App\Http\Controllers\User\BookmarkController::class, 'index'])->name('bookmark');
        Route::get('/complete', [\App\Http\Controllers\User\CompleteController::class, 'index'])->name('complete');
        Route::name('register.')->prefix('register')->controller(\App\Http\Controllers\User\RegisterController::class)->group(function () {
            Route::get('/guidance', 'guidance')->name('guidance');
            Route::post('/register', 'register')->name('register');
        });
    });
});

Route::name('line.')->prefix('line')->group(function () {
    Route::post('/webhook', [\App\Http\Controllers\Line\WebhookController::class, 'index'])->name('webhook');
    Route::controller(\App\Http\Controllers\Line\AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::match(['GET', 'POST'], '/logout', 'logout')->name('logout');
        Route::get('/line-login', 'lineLogin')->name('line-login');
        Route::get('/line-callback', 'callback')->name('line-callback');
    });
    Route::name('step.')->middleware(['auth.line:users'])->prefix('/step')->controller(\App\Http\Controllers\Line\StepMessageController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::match(['GET', 'POST'], '/aewgrshtjky', 'step1')->name('step-1');
        Route::match(['GET', 'POST'], '/kuytyerswsg', 'step2')->name('step-2');
        Route::get('/questionnaire', 'questionnaireSuccess')->name('questionnaire_success');
        Route::get('/trial-lesson', 'trialLesson')->name('trial_lesson');
        Route::post('/trial-lesson-confirm', 'trialLessonConfirm')->name('trial-lesson-confirm');
        Route::post('/trial-lesson-submit', 'trialLessonSubmit')->name('trial-lesson-submit');
    });
});

Route::get('/page/{page:slug}', [\App\Http\Controllers\PageController::class, 'index'])->name('page');
