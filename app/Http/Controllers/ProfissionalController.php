<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Especialidade;
use App\Models\Laudo;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Profissional;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfissional;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfissionalController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $profissionais = Profissional::orderBy('id', 'desc')->get();
        return view('profissionais.index', ['profissionais' => $profissionais]);
    }

    public function paginacaoAjax()
    {
        $this->authorize('admin');
        return DataTables::of(Profissional::latest('updated_at'))->make(true);
    }


    public function create()
    {
        $this->authorize('admin');
        $pacientes = Paciente::all();
        $especialidades = Especialidade::all();

        return view('profissionais.create',  compact('pacientes', 'especialidades'));
    }

    public function store(StoreProfissional $request)
    {
        $this->authorize('admin');
        $data = $request->except('senha', 'especialidades', 'pacientes');

        if ($request->has('senha')) {
            $data['senha'] = Hash::make($request->senha);
        }
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
        ])->givePermissionTo('profissional');

        event(new Registered($user));

        $profissional = new Profissional($request->all());
        $profissional->user_id = $user->id;
        $profissional->save();
        
        if ($request->has('especialidades')) {
            $profissional->especialidades()->sync($request->especialidades);
        }

        if ($request->has('pacientes')) {
            $profissional->pacientes()->sync($request->pacientes);
        }

        return redirect()->route('profissionais.index')->with('success', 'Profissional criado com sucesso!');
    }

    public function show($id)
    {
        $this->authorize('admin');
        $profissional = Profissional::findOrFail($id);
        return view('profissionais.show', ['profissional' => $profissional]);
    }

    public function edit($id)
    {
        $profissional = Profissional::findOrFail($id);
        if (!Auth::user()->can('admin') && $profissional->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $profissional->tipo_profissional = strtolower($profissional->tipo_profissional);
        $especialidades = Especialidade::all();
        $laudo = Laudo::all();
        $user = User::where('id', $profissional->user_id)->first();

        return view('profissionais.edit', compact('profissional', 'especialidades', 'laudo', 'user'));
    }

    public function getPacientes($id)
    {

        // $pacientes = Paciente::selectRaw('pacientes.*, 
        // (SELECT COUNT(*) FROM paciente_profissional 
        //  WHERE paciente_id = pacientes.id AND profissional_id = ?) AS vinculado', [$id])
        // ->latest('updated_at');
        // ->orderByRaw('vinculado DESC, pacientes.nome ASC');

        // $pacientes = Paciente::leftJoin('paciente_profissional', function ($join) use ($id) {
        //     $join->on('paciente_profissional.paciente_id', '=', 'pacientes.id')
        //          ->where('paciente_profissional.profissional_id', '=', $id);
        // })
        // ->selectRaw('pacientes.*, COUNT(paciente_profissional.paciente_id) AS vinculado')
        // ->groupBy('pacientes.id')
        // ->orderBy('vinculado', 'desc')//ou somente ->latest('vinculado', 'desc');    
        // ->latest('updated_at');  
        $profissional = Profissional::find($id);
        $consulta = $profissional->consultas()->distinct('paciente_id')->get();
        return DataTables::of($consulta)
            ->addColumn('paciente.nome', function ($consulta) {
                return $consulta->paciente->nome;
            })
            ->addColumn('tipoConsulta.nome', function ($consulta) {
                return $consulta->paciente->email;
            })
            ->make(true);
    }



    public function update(StoreProfissional $request, $id)
    {
        $profissional = Profissional::findOrFail($id);
        if (!Auth::user()->can('admin') && $profissional->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $user = User::where('id', $profissional->user_id)->first();
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($profissional->user_id)],
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

        // atualizar as especialidades do 
        $profissional->update($request->all());
        
        if ($request->has('especialidades')) {
            $profissional->especialidades()->sync($request->especialidades);
            //dd($request);
        } else {
            $profissional->especialidades()->detach();
        }
        
        return redirect()->route('profissionais.edit', $id)->with('success', 'Atualização foi realizada!');
    }


    public function atualizarPaciente(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);

        // verificar se o paciente está ativo
        if ($request->input('ativo') == 1) {
            $profissional->pacientes()->syncWithoutDetaching($request->input('paciente_id'));
        } else {
            $profissional->pacientes()->detach($request->input('paciente_id'));
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $profissional = Profissional::findOrFail($id);
        $profissional->delete();
        return redirect()->route('profissionais.index')->with('success', 'Profissional excluído com sucesso!');
    }

    public function buscarConsultaProfissional(Request $request)
    {
        $profissionalId = $request->input('profissionalId');
        $dataParam = $request->input('data');

        $query = Consulta::with('paciente', 'profissional', 'tipoConsulta', 'laudo')
            ->where('profissional_id', $profissionalId);

        if ($dataParam) {
            if ($dataParam !== 'todas') {
                $query->whereDate('dia_consulta', $dataParam);
            }
        }

        $data = $query->get();

        return Datatables::of($data)
            ->addColumn('paciente.nome', function ($consulta) {
                return $consulta->paciente->nome;
            })
            ->addColumn('paciente.cpf', function ($consulta) {
                return $consulta->paciente->cpf;
            })
            ->addColumn('profissional.nome', function ($consulta) {
                return $consulta->profissional->nome;
            })
            ->addColumn('tipoConsulta.nome', function ($consulta) {
                return $consulta->tipoConsulta->nome;
            })
            ->addColumn('tipoConsulta.duracao_estimada', function ($consulta) {
                return $consulta->tipoConsulta->duracao_estimada;
            })
            ->addColumn('laudo', function ($consulta) {
                return $consulta->laudo;
            })
            ->make(true);
    }
}
