<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\StrukturController as AdminStrukturController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\StrukturController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

Route::get('/_debug', function () {
    $paths = [
        public_path('build/manifest.json'),
        public_path('build'),
        base_path('public/build/manifest.json'),
    ];
    $result = [];
    foreach ($paths as $p) {
        $result[$p] = file_exists($p) ? 'EXISTS' : 'NOT_FOUND';
        if (file_exists($p) && is_file($p)) {
            $result[$p . ' (contents)'] = file_get_contents($p);
        }
        if (file_exists($p) && is_dir($p)) {
            $result[$p . ' (files)'] = scandir($p);
        }
    }
    $result['APP_ENV'] = app()->environment();
    $result['base_path'] = base_path();
    $result['public_path'] = public_path();
    return response()->json($result);
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/feed', [PostController::class, 'index'])->name('feed');
    Route::get('/mahasiswa', [\App\Http\Controllers\MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/{mahasiswa}', [\App\Http\Controllers\MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/reaction', [ReactionController::class, 'toggle'])->name('posts.reaction');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/redirect', [NotificationController::class, 'redirect'])->name('notifications.redirect');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/struktur-kelas', [StrukturController::class, 'index'])->name('struktur-kelas.index');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('struktur', AdminStrukturController::class);
});

require __DIR__.'/auth.php';
