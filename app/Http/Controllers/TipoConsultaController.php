<?php

namespace App\Http\Controllers;

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
  
    public function store(Request $request)
    {
        TipoConsulta::create($request->all());
        return redirect()->route('tipos-consultas.index');
    }

    public function edit($id)
    {
        $tipoConsulta = TipoConsulta::find($id);
        $especialidades = Especialidade::all();
        return view('tipos_consultas.edit', compact('tipoConsulta','especialidades'));
    }

    public function update(Request $request, $id)
    {
        $tipoConsulta = TipoConsulta::find($id);
        $tipoConsulta->update($request->all());
        return redirect()->route('tipos-consultas.index');
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