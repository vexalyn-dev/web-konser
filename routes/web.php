<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckIn\CheckInController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Routes yang dapat diakses oleh semua pengunjung tanpa login.
*/

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/order', [PublicController::class, 'order'])->name('order');
Route::post('/order', [PublicController::class, 'store'])->name('order.store');
Route::get('/ticket/{ticket_code}', [PublicController::class, 'show'])->name('ticket.show');
Route::get('/ticket/{ticket_code}/download', [PublicController::class, 'downloadPdf'])->name('ticket.download');
Route::get('/ticket/{ticket_code}/download-qrcode', [PublicController::class, 'downloadQrCode'])->name('ticket.download-qrcode');

// Additional public pages (optional)
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes untuk login dan logout.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes khusus untuk administrator.
| Dilindungi oleh middleware 'auth' dan 'admin'.
*/

Route::middleware(['auth', 'admin', 'activity'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

    // Tickets Management
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/trashed', [TicketController::class, 'trashed'])->name('tickets.trashed');
    Route::get('/tickets/export/pdf', [TicketController::class, 'exportPdf'])->name('tickets.export.pdf');
    Route::get('/tickets/export/excel', [TicketController::class, 'exportExcel'])->name('tickets.export.excel');
    Route::post('/tickets/bulk-delete', [TicketController::class, 'bulkDelete'])->name('tickets.bulk-delete');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{id}/restore', [TicketController::class, 'restore'])->name('tickets.restore');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');

    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
});

/*
|--------------------------------------------------------------------------
| Check-In Routes
|--------------------------------------------------------------------------
| Routes khusus untuk staff check-in.
| Dilindungi oleh middleware 'auth' dan 'checkin'.
*/

Route::middleware(['auth', 'checkin', 'activity'])->prefix('checkin')->name('checkin.')->group(function () {
    Route::get('/', [CheckInController::class, 'index'])->name('index');
    Route::get('/scan', [CheckInController::class, 'scan'])->name('scan');
    Route::post('/process', [CheckInController::class, 'process'])->name('process');
    Route::get('/history', [CheckInController::class, 'history'])->name('history');
    Route::post('/validate', [CheckInController::class, 'validate'])->name('validate');
});

/*
|--------------------------------------------------------------------------
| Error Testing Routes (Temporary)
|--------------------------------------------------------------------------
| Temporary test routes untuk testing error pages.
| HAPUS routes ini setelah testing selesai!
*/

Route::get('/test-403', function () {
    abort(403);
});

Route::get('/test-404', function () {
    abort(404);
});

Route::get('/test-500', function () {
    abort(500);
});

/*
|--------------------------------------------------------------------------
| Fallback Routes
|--------------------------------------------------------------------------
| Handle 404 untuk route yang tidak ditemukan.
*/

Route::fallback(function () {
    if (request()->expectsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Route not found.',
        ], 404);
    }

    return response()->view('errors.404', [], 404);
});