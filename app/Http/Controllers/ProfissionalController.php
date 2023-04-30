<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Profissional;
use Yajra\DataTables\DataTables;

class ProfissionalController extends Controller
{
    public function index()
    {
        $profissionais = Profissional::orderBy('id','desc')->get();
        return view('profissionais.index', ['profissionais' => $profissionais]);
    }

    public function paginacaoAjax()
    {
        return DataTables::of(Profissional::orderBy('updated_at', 'asc'))->make(true);
    }


    public function create()
    {
        $pacientes = Paciente::all();
        $especialidades = Especialidade::all();

        return view('profissionais.create',  compact('pacientes','especialidades'));
    }

    public function store(Request $request)
    {
        $data = $request->except('senha', 'especialidades', 'pacientes');
        
        if ($request->has('senha')) {
            $data['senha'] = Hash::make($request->senha);
        }
        
        $profissional = Profissional::create($data);
        
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
        $profissional = Profissional::findOrFail($id);
        return view('profissionais.show', ['profissional' => $profissional]);
    }

    public function edit($id)
    {
        $profissional = Profissional::findOrFail($id);
        
        $especialidades = Especialidade::all();
  

        return view('profissionais.edit', compact('profissional', 'especialidades'));
    }

    public function getPacientes($id)
    {

        $pacientes = Paciente::selectRaw('pacientes.*, 
            (SELECT COUNT(*) FROM paciente_profissional 
             WHERE paciente_id = pacientes.id AND profissional_id = ?) AS vinculado', [$id])
            //->orderByRaw('vinculado DESC, pacientes.nome ASC');
            ->orderBy('pacientes.nome');

        return DataTables::of($pacientes)->make(true);
    }
    
    
    
    public function update(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);
        $data = $request->except('senha');
    
        if ($request->has('senha')) {
            $data['senha'] = Hash::make($request->senha);
        }

        $profissional->update($data);
    
        // // atualizar os pacientes do profissional
        // if ($request->has('pacientes')) {
        //     $profissional->pacientes()->sync(array_keys($request->pacientes, 1));
        // } else {
        //     $profissional->pacientes()->detach();
        // }
        
    
        // atualizar as especialidades do profissional
        if ($request->has('especialidades')) {
            $profissional->especialidades()->sync($request->especialidades);
        } else {
            $profissional->especialidades()->detach();
        }
    
        return redirect()->route('profissionais.index')->with('success', 'Profissional atualizado com sucesso!');
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
}
