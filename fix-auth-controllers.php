<?php
// fix-auth-controllers.php

echo "🔧 Corrigindo controladores de autenticação...\n";

// Criar diretório de controllers Auth se não existir
$authDir = __DIR__ . '/app/Http/Controllers/Auth';
if (!is_dir($authDir)) {
    mkdir($authDir, 0755, true);
    echo "✅ Diretório Auth criado\n";
}

// Controladores necessários
$controllers = [
    'EmailVerificationPromptController' => '<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route(\'dashboard\', absolute: false))
                    : view(\'auth.verify-email\');
    }
}',
    
    'VerifyEmailController' => '<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user\'s email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route(\'dashboard\', absolute: false).\'?verified=1\');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route(\'dashboard\', absolute: false).\'?verified=1\');
    }
}',
    
    'AuthenticatedSessionController' => '<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view(\'auth.login\');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            \'email\' => \'required|string|email\',
            \'password\' => \'required|string\',
        ]);

        if (! Auth::attempt($request->only(\'email\', \'password\'), $request->boolean(\'remember\'))) {
            throw ValidationException::withMessages([
                \'email\' => trans(\'auth.failed\'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route(\'dashboard\', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard(\'web\')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(\'/\');
    }
}',
    
    'RegisteredUserController' => '<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view(\'auth.register\');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            \'name\' => [\'required\', \'string\', \'max:255\'],
            \'email\' => [\'required\', \'string\', \'lowercase\', \'email\', \'max:255\', \'unique:\'.User::class],
            \'password\' => [\'required\', \'confirmed\', Rules\Password::defaults()],
        ]);

        $user = User::create([
            \'name\' => $request->name,
            \'email\' => $request->email,
            \'password\' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route(\'dashboard\', absolute: false));
    }
}'
];

foreach ($controllers as $controllerName => $content) {
    $filePath = $authDir . '/' . $controllerName . '.php';
    if (!file_exists($filePath)) {
        file_put_contents($filePath, $content);
        echo "✅ Criado: $controllerName\n";
    } else {
        echo "⚠️  Já existe: $controllerName\n";
    }
}

echo "🎉 Controladores corrigidos! Agora execute:\n";
echo "php artisan config:clear\n";
echo "php artisan route:clear\n";
echo "php artisan serve\n";