<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaProfissional;
use App\Models\Profissional;
use Yajra\DataTables\DataTables;

class AgendaProfissionalController extends Controller
{
    public function paginacaoAjax()
    {
        $data = AgendaProfissional::with('profissional')->get();
    
        return Datatables::of($data)
            ->addColumn('profissional.nome', function ($agendaProfissional) {
                return $agendaProfissional->profissional->nome;
            })->addColumn('profissional.tipo_profissional', function ($agendaProfissional) {
                return $agendaProfissional->profissional->tipo_profissional;
            })
            ->make(true);
    }

    
    public function index()
    {
        $agendaProfissionais = AgendaProfissional::all();
        return view('agenda_profissionais.index', compact('agendaProfissionais'));
    }


    public function buscarProfissional(Request $request)
    {
        if ($procurar = $request->nome) {
            $tags = Profissional::where('nome', 'LIKE', "%$procurar%")->get();
        }
        return response()->json($tags);
    }

    public function create()
    {
        $profissionais = Profissional::all();
        return view('agenda_profissionais.create', compact('profissionais'));
    }

    public function store(Request $request)
    {
        AgendaProfissional::create($request->all());
        return redirect()->route('agendas.index');
    }

    public function edit($id)
    {
        $agendaProfissional = AgendaProfissional::find($id);
        $profissionais = Profissional::all();
        
        return view('agenda_profissionais.edit', compact('agendaProfissional', 'profissionais'));
    }

    public function update(Request $request, $id)
    {
        $agendaProfissional = AgendaProfissional::find($id);
        $agendaProfissional->update($request->all());
        return redirect()->route('agendas.index');
    }

    public function destroy($id)
    {
        $agendaProfissional = AgendaProfissional::find($id);
        $agendaProfissional->delete();
        return redirect()->route('agendas.index');
    }
}
