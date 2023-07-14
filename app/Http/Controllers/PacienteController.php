<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StorePaciente;
use Illuminate\Http\Request;
use App\Models\Paciente;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function store(StorePaciente $request)
    {
        $this->authorize('admin');
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'senha' => ['required', 'min:6'],
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome deve ter no máximo :max caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'O campo senha deve ter no mínimo :min caracteres.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->senha),
        ])->givePermissionTo('user');
        event(new Registered($user));
        $paciente = new Paciente($request->all());
        $paciente->user_id = $user->id;
        $paciente->save();
        return redirect()->route('pacientes.index')->with('success', $paciente->nome. ' adicionado(a)!');
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

    public function update(StorePaciente $request, $id)
    {
        $paciente = Paciente::find($id);
        if (!Auth::user()->can('admin') && $paciente->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($paciente->user_id)],
            'senha' => ['nullable', 'min:6'],
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome deve ter no máximo :max caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'senha.min' => 'O campo senha deve ter no mínimo :min caracteres.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user = User::find($paciente->user_id);
        
        if (!empty($request->nome)) {
            $user->name = $request->nome;
        }
        
        if (!empty($request->email)) {
            $user->email = $request->email;
        }
        
        if (!empty($request->senha)) {
            $user->password = Hash::make($request->senha);
        }
        
        $user->save();
        $paciente->update($request->all());

        return redirect()->route('pacientes.edit', $id)->with('success', 'Dados atualizados!');
    }

    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        $paciente->delete();
        return redirect()->route('pacientes.index');
    }
}
