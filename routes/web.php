<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeiraController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\PedidoController;



// Página inicial 
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        \Illuminate\Support\Facades\Log::info('Login Request', [
            'credentials' => $credentials,
            'user_exists' => \App\Models\User::where('email', $credentials['email'])->exists(),
            'users_count' => \App\Models\User::count()
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    });

    // Registro
    Route::get('/register/produtor', [RegisterController::class, 'showProdutorRegistrationForm'])
        ->name('register.produtor');
    Route::post('/register/produtor', [RegisterController::class, 'registerProdutor']);

    Route::get('/register/consumidor', [RegisterController::class, 'showConsumidorRegistrationForm'])
        ->name('register.consumidor');
    Route::post('/register/consumidor', [RegisterController::class, 'registerConsumidor']);
});

// Logout (apenas para autenticados)
Route::middleware('auth')->post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Logout realizado com sucesso!');
})->name('logout');

// Rotas públicas (acessíveis a todos)
Route::get('/feiras', [FeiraController::class, 'index'])->name('feiras.index');
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/buscar', [ProdutoController::class, 'search'])->name('produtos.search');

// Rotas autenticadas (apenas para usuários logados)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/perfil/editar', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas da Administração
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        
        // Gestão de Feiras
        Route::get('/feiras', [App\Http\Controllers\Admin\FeiraController::class, 'index'])->name('feiras.index');
        Route::get('/feiras/criar', [App\Http\Controllers\Admin\FeiraController::class, 'create'])->name('feiras.create');
        Route::post('/feiras', [App\Http\Controllers\Admin\FeiraController::class, 'store'])->name('feiras.store');
        Route::get('/feiras/{feira}/editar', [App\Http\Controllers\Admin\FeiraController::class, 'edit'])->name('feiras.edit');
        Route::put('/feiras/{feira}', [App\Http\Controllers\Admin\FeiraController::class, 'update'])->name('feiras.update');
        Route::delete('/feiras/{feira}', [App\Http\Controllers\Admin\FeiraController::class, 'destroy'])->name('feiras.destroy');

        // Gestão de Produtores
        Route::get('/produtores', [App\Http\Controllers\AdminController::class, 'produtores'])->name('produtores');
        Route::delete('/produtores/{produtor}', [App\Http\Controllers\AdminController::class, 'destroyProdutor'])->name('produtores.destroy');
    });

    // Rotas específicas para produtores
    Route::middleware(['produtor'])->group(function () {
        // Participação em Feiras
        Route::get('/produtor/feiras', [App\Http\Controllers\Produtor\ParticipacaoFeiraController::class, 'index'])->name('produtor.feiras.participacao');
        Route::get('/produtor/feiras/{feira}/participar', [App\Http\Controllers\Produtor\ParticipacaoFeiraController::class, 'edit'])->name('produtor.feiras.participar');
        Route::put('/produtor/feiras/{feira}', [App\Http\Controllers\Produtor\ParticipacaoFeiraController::class, 'update'])->name('produtor.feiras.update');

        // Produtos do produtor
        Route::get('/produtos/criar', [ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('/produtos/{produto}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

        // Pedidos Recebidos pelo Produtor
        Route::get('/produtor/pedidos', [PedidoController::class, 'pedidosProdutor'])->name('produtor.pedidos');
        Route::patch('/produtor/pedidos/{pedido}/concluir', [PedidoController::class, 'concluirPedido'])->name('produtor.pedidos.concluir');
        Route::patch('/produtor/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelarPedido'])->name('produtor.pedidos.cancelar');
    });

    // Rotas específicas para consumidores
    Route::middleware(['consumidor'])->group(function () {
        // Carrinho
        Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
        Route::post('/carrinho', [CarrinhoController::class, 'store'])->name('carrinho.store');
        Route::put('/carrinho/{item}', [CarrinhoController::class, 'update'])->name('carrinho.update');
        Route::delete('/carrinho/{item}', [CarrinhoController::class, 'destroy'])->name('carrinho.destroy');
        Route::post('/carrinho/limpar/{feira}', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');

        // Pedidos
        Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
        Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    });
});

// Rotas públicas com parâmetros (devem ficar no final para não conflitar com rotas específicas)
Route::get('/feiras/{feira}', [FeiraController::class, 'show'])->name('feiras.show');
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

// Rota de fallback (para páginas não encontradas)
Route::fallback(function () {
    return redirect()->route('home');
});