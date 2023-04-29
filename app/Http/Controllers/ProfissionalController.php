<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Profissional;
use Illuminate\Support\Facades\DB;

class ProfissionalController extends Controller
{
    public function index()
    {
        $profissionais = Profissional::orderBy('id','desc')->get();
        return view('profissionais.index', ['profissionais' => $profissionais]);
    }

    public function vincularPaciente(Request $request) {
        $profissional = Profissional::find($request->input('profissional_id'));
        $paciente = Paciente::find($request->input('paciente_id'));
    
        $profissional->pacientes()->attach($paciente);
    
        return response()->json(['message' => 'Paciente vinculado com sucesso.']);
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
        $pacientes = Paciente::where('ativo', true)
        ->orderByRaw('(SELECT COUNT(*) FROM paciente_profissional WHERE paciente_id = pacientes.id AND profissional_id = ?) DESC', [$id])
        ->orderBy('nome', 'asc')
        ->get();

        return view('profissionais.edit', compact('profissional', 'especialidades', 'pacientes'));
    }
    
    public function pesquisar(Request $request) {
        $pacientes = Paciente::where('nome', 'like', '%'.$request->nome_paciente.'%')->get();
        return view('pacientes.lista', compact('pacientes'));
    }
    
    
    
    public function update(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);
        $data = $request->except('senha');
    
        if ($request->has('senha')) {
            $data['senha'] = Hash::make($request->senha);
        }

        $profissional->update($data);
    
        // atualizar os pacientes do profissional
        if ($request->has('pacientes')) {
            $profissional->pacientes()->sync($request->pacientes);    
        }    else{
            $profissional->pacientes()->detach();
        }
    
        // atualizar as especialidades do profissional
        if ($request->has('especialidades')) {
            $profissional->especialidades()->sync($request->especialidades);
        } else {
            $profissional->especialidades()->detach();
        }
    
        return redirect()->route('profissionais.index')->with('success', 'Profissional atualizado com sucesso!');
    }
    
    

    public function destroy($id)
    {
        $profissional = Profissional::findOrFail($id);
        $profissional->delete();
        return redirect()->route('profissionais.index')->with('success', 'Profissional excluído com sucesso!');
    }
}
