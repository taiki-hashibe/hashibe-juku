<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('admin.')->prefix('admin')->group(function () {
    Route::controller(\App\Http\Controllers\Admin\AuthController::class)->group(function () {
        Route::match(['GET', 'POST'], '/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
    });
    Route::middleware(['auth.admin:admins'])->group(function () {
        Route::controller(\App\Http\Controllers\Admin\DashboardController::class)->group(function () {
            Route::get('', 'index')->name('dashboard');
        });
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->withTrashed()->only([
            'index', 'show',  'destroy'
        ]);
        Route::match(['GET', 'POST'], '/post/sort/{category?}', [\App\Http\Controllers\Admin\PostController::class, 'sort'])->name('post.sort');
        Route::post('/post/revert/{post}', [\App\Http\Controllers\Admin\PostController::class, 'revert'])->name('post.revert');
        Route::resource('post', \App\Http\Controllers\Admin\PostController::class);
        Route::match(['GET', 'POST'], '/category/sort/{category?}', [\App\Http\Controllers\Admin\CategoryController::class, 'sort'])->name('category.sort');
        Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);
        Route::match(['GET', 'POST'], '/curriculum/sort', [\App\Http\Controllers\Admin\CurriculumController::class, 'sort'])->name('curriculum.sort');
        Route::match(['GET', 'POST'], '/curriculum/sort/item/{curriculum}', [\App\Http\Controllers\Admin\CurriculumController::class, 'sortItem'])->name('curriculum.sort-item');
        Route::resource('curriculum', \App\Http\Controllers\Admin\CurriculumController::class);
        Route::match(['GET', 'POST'], '/page/sort', [\App\Http\Controllers\Admin\PageController::class, 'sort'])->name('page.sort');
        Route::resource('page', \App\Http\Controllers\Admin\PageController::class);
        Route::name('media-upload.')->controller(\App\Http\Controllers\Admin\MediaUploadController::class)->group(function () {
            Route::post('/upload', 'upload')->name('upload');
            Route::post('/upload/file', 'uploadFile')->name('upload.file');
        });
        Route::name('ckeditor.')->controller(\App\Http\Controllers\Admin\CkEditorController::class)->group(function () {
            Route::post('/image-upload', 'imageUpload')->name('image-upload');
        });
    });
});
