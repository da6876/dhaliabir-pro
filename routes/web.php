<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('dashboard');
});

Route::resource('about', AboutUsController::class);
Route::get('about-data', [AboutUsController::class, 'getData'])->name('about.data');

Route::resource('resume', ResumeController::class);
Route::get('resume-data', [ResumeController::class, 'getData'])->name('resume.data');

Route::resource('education', EducationController::class);
Route::get('education-data', [EducationController::class, 'getData'])->name('education.data');

Route::resource('experience', ExperienceController::class);
Route::get('experience-data', [ExperienceController::class, 'getData'])->name('experience.data');

Route::resource('services', ServiceController::class);
Route::get('services-data', [ServiceController::class, 'getData'])->name('services.data');

Route::resource('users', PortfolioController::class);
Route::resource('roles', PortfolioController::class);
Route::resource('permissions', PortfolioController::class);
Route::resource('portfolio', PortfolioController::class);
Route::get('portfolio-data', [PortfolioController::class, 'getData'])->name('portfolio.data');
