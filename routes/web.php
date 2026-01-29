<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\SavedKosController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

Route::get('testimonials', [LandingController::class, 'testomonials'])->name('landing.testimonials');
Route::get('/search', [LandingController::class, 'search'])->name('landing.search');

Route::resource('/', LandingController::class);
Route::get('/kos/{id}', [KosController::class, 'show'])->name('kos.show');
Route::get('/apartments/{id}', [ApartmentController::class, 'show'])->name('apartments.show');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])->name('verification.send');
});

// Footer content routes
Route::view('/press-kit', 'footercontent.company.presskit')->name('press.kit');
Route::view('/contact', 'footercontent.company.contact')->name('contact');

Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/settings/update', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');
    
    // Saved Kos Routes
    Route::get('/saved', [SavedKosController::class, 'index'])->name('saved.index');
    Route::post('/kos/{id}/toggle-save', [SavedKosController::class, 'toggle'])->name('kos.toggle.save');
    Route::get('/kos/{id}/check-saved', [SavedKosController::class, 'checkSaved'])->name('kos.check.saved');
});

// Review Routes
Route::get('/reviews/{kos_id}', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);

Route::get('/help-center', [HelpController::class, 'index'])->name('help.center');
Route::get('/help-center/search', [HelpController::class, 'search'])->name('help.search');

Route::get('/safety-guide', function () {
    return view('footercontent.support.safety');
})->name('safety.guide');

Route::get('/privacy-policy', function () {
    return view('footercontent.support.privasi');
})->name('privacy.policy');

Route::get('/about', function () {
    return view('footercontent.company.about');
})->name('about');

Route::get('/terms', function () {
    return view('footercontent.support.terms');
})->name('terms');

Route::get('/careers', function () {
    return view('footercontent.company.careers');
})->name('careers');

Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report-problem', [ReportController::class, 'index'])->name('report.problem');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Password Reset Routes only (login/register handled by custom AuthController)
Auth::routes(['login' => false, 'register' => false, 'reset' => true, 'verify' => false]);
