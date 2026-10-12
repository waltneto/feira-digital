<?php
// fix-auth.php

echo "🔧 Corrigindo problema de autenticação...\n";

// Verificar se o arquivo auth.php existe
$authRouteFile = __DIR__ . '/routes/auth.php';

if (!file_exists($authRouteFile)) {
    echo "📝 Criando arquivo routes/auth.php...\n";
    
    $content = '<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(\'guest\')->group(function () {
    Route::get(\'register\', [RegisteredUserController::class, \'create\'])->name(\'register\');
    Route::post(\'register\', [RegisteredUserController::class, \'store\']);
    Route::get(\'login\', [AuthenticatedSessionController::class, \'create\'])->name(\'login\');
    Route::post(\'login\', [AuthenticatedSessionController::class, \'store\']);
    Route::get(\'forgot-password\', [PasswordResetLinkController::class, \'create\'])->name(\'password.request\');
    Route::post(\'forgot-password\', [PasswordResetLinkController::class, \'store\'])->name(\'password.email\');
    Route::get(\'reset-password/{token}\', [NewPasswordController::class, \'create\'])->name(\'password.reset\');
    Route::post(\'reset-password\', [NewPasswordController::class, \'store\'])->name(\'password.store\');
});

Route::middleware(\'auth\')->group(function () {
    Route::get(\'verify-email\', EmailVerificationPromptController::class)->name(\'verification.notice\');
    Route::get(\'verify-email/{id}/{hash}\', VerifyEmailController::class)->middleware([\'signed\', \'throttle:6,1\'])->name(\'verification.verify\');
    Route::post(\'email/verification-notification\', [EmailVerificationNotificationController::class, \'store\'])->middleware(\'throttle:6,1\')->name(\'verification.send\');
    Route::get(\'confirm-password\', [ConfirmablePasswordController::class, \'show\'])->name(\'password.confirm\');
    Route::post(\'confirm-password\', [ConfirmablePasswordController::class, \'store\']);
    Route::put(\'password\', [PasswordController::class, \'update\'])->name(\'password.update\');
    Route::post(\'logout\', [AuthenticatedSessionController::class, \'destroy\'])->name(\'logout\');
});';

    file_put_contents($authRouteFile, $content);
    echo "✅ Arquivo routes/auth.php criado com sucesso!\n";
} else {
    echo "✅ Arquivo routes/auth.php já existe.\n";
}

// Verificar controllers de auth
$authControllers = [
    'AuthenticatedSessionController',
    'ConfirmablePasswordController', 
    'EmailVerificationNotificationController',
    'EmailVerificationPromptController',
    'NewPasswordController',
    'PasswordController',
    'PasswordResetLinkController',
    'RegisteredUserController',
    'VerifyEmailController'
];

foreach ($authControllers as $controller) {
    $controllerFile = __DIR__ . "/app/Http/Controllers/Auth/{$controller}.php";
    if (!file_exists($controllerFile)) {
        echo "⚠️  Controller Auth\\{$controller} não encontrado.\n";
    }
}

echo "🎉 Correção concluída! Execute: php artisan serve\n";