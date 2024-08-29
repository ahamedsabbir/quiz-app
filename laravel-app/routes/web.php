<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware([Admin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('question', QuestionController::class);
}
Route::middleware([Applicant::class])->prefix('applicant')->group(function () {
//result
	Route::post('result', [ExamController::class, 'examResult']);
	Route::get('apply/{id}', [ApplyController::class, 'apply'])->middleware(ApplyCheck::class);
}








#Ajax
Route::prefix('ajax')->group(function(){
    Route::get('/state/{country_id}', [AjaxController::class, 'stateAjax']);
    Route::get('/post/cat', [AjaxController::class, 'postCatAjax']);
});

#Ckeditor
Route::get('ckeditor', [CkeditorController::class, 'index']);
Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');

require __DIR__.'/auth.php';
