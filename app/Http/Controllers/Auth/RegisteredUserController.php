<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            'role' => ['required', Rule::in(['admin', 'profissional', 'user'])],
            'chave' => ['required'],
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'unique' => 'O :attribute informado já está em uso.',
            'confirmed' => 'A confirmação da senha não corresponde.',
        ]);

        $user = null;
        $role = $request->role;

        if ($role === 'admin' && $request->chave !== '@admin') {
            return redirect()->back()->withErrors(['chave' => 'Chave do Administrador incorreta.'])->withInput();
        }

        if ($role === 'profissional' && $request->chave !== '@prof') {
            return redirect()->back()->withErrors(['chave' => 'Chave do Profissional incorreta.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'chave' => $request->chave,
        ]);
        if ($role === 'profissional' && $request->chave == '@ProfSt!') {
            $profissional = new Profissional([
                'nome' => $request->name,
                'email' => $request->email,
                // 'senha' => Hash::make($request->password),
            ]);
            $profissional->user_id = $user->id;
            // dd($profissional);
            $profissional->save();
        }
        $user->givePermissionTo($role);


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
