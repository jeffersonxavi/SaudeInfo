<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoConsulta;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use App\Models\TipoConsulta;
use Yajra\DataTables\DataTables;

class TipoConsultaController extends Controller
{
    public function paginacaoAjax()
    {
        $data = TipoConsulta::with('especialidade')->get();
    
        return Datatables::of($data)
            ->addColumn('especialidade.nome', function ($tipoConsulta) {
                return $tipoConsulta->especialidade->nome;
            })
            ->make(true);
    }
    public function index()
    {
        $tiposConsultas = TipoConsulta::all();
        return view('tipos_consultas.index', compact('tiposConsultas'));
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        return view('tipos_consultas.create', compact('especialidades'));
    }
  
    public function store(StoreTipoConsulta $request)
    {
        $tipos_consulta = TipoConsulta::create($request->all());

        return redirect()->route('tipos-consultas.index')->with('success', $tipos_consulta->nome. ' adicionado(a)!');
    }

    public function edit($id)
    {
        $tipoConsulta = TipoConsulta::find($id);
        $especialidades = Especialidade::all();
        return view('tipos_consultas.edit', compact('tipoConsulta','especialidades'));
    }

    public function update(StoreTipoConsulta $request, $id)
    {
        $tipoConsulta = TipoConsulta::find($id);
        $tipoConsulta->update($request->all());
        return redirect()->route('tipos-consultas.edit', $id)->with('success', $tipoConsulta->nome. ' atualizado(a)!');
    }

    public function destroy($id)
    {
        $tipoConsulta = TipoConsulta::find($id);
    
        if ($tipoConsulta) {
            $tipoConsulta->delete();
        }
    
        return redirect()->route('tipos-consultas.index');
    }
    
}
