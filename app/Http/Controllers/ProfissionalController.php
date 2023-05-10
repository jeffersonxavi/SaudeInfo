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
        return DataTables::of(Profissional::latest('updated_at'))->make(true);
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
        $profissional->tipo_profissional = strtolower($profissional->tipo_profissional);
        $especialidades = Especialidade::all();
        
        return view('profissionais.edit', compact('profissional', 'especialidades'));
    }

    public function getPacientes($id)
    {

        // $pacientes = Paciente::selectRaw('pacientes.*, 
        // (SELECT COUNT(*) FROM paciente_profissional 
        //  WHERE paciente_id = pacientes.id AND profissional_id = ?) AS vinculado', [$id])
        // ->latest('updated_at');
        // ->orderByRaw('vinculado DESC, pacientes.nome ASC');
        
        $pacientes = Paciente::leftJoin('paciente_profissional', function ($join) use ($id) {
            $join->on('paciente_profissional.paciente_id', '=', 'pacientes.id')
                 ->where('paciente_profissional.profissional_id', '=', $id);
        })
        ->selectRaw('pacientes.*, COUNT(paciente_profissional.paciente_id) AS vinculado')
        ->groupBy('pacientes.id')
        ->orderBy('vinculado', 'desc')//ou somente ->latest('vinculado', 'desc');    
        ->latest('updated_at');  
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
            //dd($request);
        } else {
            $profissional->especialidades()->detach();
        }
        return redirect()->route('profissionais.edit',$id)->with('success', 'Atualização foi realizada!');
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
