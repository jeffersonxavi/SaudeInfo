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
        $this->authorize('admin');
        return DataTables::of(Paciente::latest('created_at'))->make(true);
    }

    public function index()
    {
        $this->authorize('admin');
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->senha),
        ])->givePermissionTo('user');
        
        event(new Registered($user));        
        Paciente::create([
            'user_id' => $user->id,
            'nome' => $request->nome,
            'genero' => $request->genero,
            'estado_civil' => $request->estado_civil,
            'data_nascimento' => $request->data_nascimento,
            // 'ativo' => $request->ativo,
            'rg' => $request->crm,
            'cpf' => $request->cpf,
            'cep' => $request->cep,
            'numero_sus' => $request->numero_sus,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'uf' => $request->uf,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
        ]);
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
