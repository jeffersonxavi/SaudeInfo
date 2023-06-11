<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PacienteController extends Controller
{
    public function paginacaoAjax()
    {
        return DataTables::of(Paciente::latest('created_at'))->make(true);
    }

    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->senha),
        ])->givePermissionTo('user');

        event(new Registered($user));
        Paciente::create($request->all());
        return redirect()->route('pacientes.index');
    }

    public function edit($id)
    {
        $paciente = Paciente::find($id);
        if (!Auth::user()->can('admin') && $paciente->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $user = User::where('id', $paciente->user_id)->first();
        return view('pacientes.edit', compact('paciente', 'user'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);
        if (!Auth::user()->can('admin') && $paciente->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $paciente->update($request->all());
        $user = User::where('id', $paciente->user_id)->first();
        $user->update([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->senha),
        ]);
        return redirect()->route('pacientes.index');
    }

    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        $paciente->delete();
        return redirect()->route('pacientes.index');
    }
}
