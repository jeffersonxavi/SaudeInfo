<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaProfissional;
use App\Models\Profissional;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AgendaProfissionalController extends Controller
{
    public function paginacaoAjax()
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
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
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
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
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
        $profissionais = Profissional::all();
        return view('agenda_profissionais.create', compact('profissionais'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
        AgendaProfissional::create($request->all());
        return redirect()->route('agendas.index');
    }

    public function edit($id)
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
        $agendaProfissional = agendaProfissional::find($id);
        if (!Auth::user()->can('admin') && $agendaProfissional->profissional->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $profissionais = Profissional::all();
        return view('agenda_profissionais.edit', compact('agendaProfissional', 'profissionais'));
    }

    public function update(Request $request, $id)
    {
        $agendaProfissional = AgendaProfissional::find($id);
        if (!Auth::user()->can('admin') && $agendaProfissional->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $agendaProfissional->update($request->all());
        return redirect()->route('agendas.index');
    }

    public function destroy($id)
    {
        $agendaProfissional = AgendaProfissional::find($id);
        if (!Auth::user()->can('admin') && $agendaProfissional->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }
        $agendaProfissional->delete();
        return redirect()->route('agendas.index');
    }
}
