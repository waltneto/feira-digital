<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ];

        if ($user->isConsumidor()) {
            $rules['cpf'] = 'required|string|min:11|max:14|unique:consumidores,cpf,' . $user->consumidor->id;
        } elseif ($user->isProdutor()) {
            $rules['documento'] = 'required|string|min:11|max:18|unique:produtores,documento,' . $user->produtor->id;
        }

        $validatedData = $request->validate($rules);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        if ($user->isConsumidor()) {
            $user->consumidor->cpf = $validatedData['cpf'];
            $user->consumidor->save();
        } elseif ($user->isProdutor()) {
            $user->produtor->documento = $validatedData['documento'];
            $user->produtor->save();
        }

        return redirect()->route('dashboard')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isConsumidor() && $user->consumidor) {
            $user->consumidor()->delete();
        } elseif ($user->isProdutor() && $user->produtor) {
            $user->produtor()->delete();
        }
        
        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sua conta foi excluída com sucesso.');
    }
}
