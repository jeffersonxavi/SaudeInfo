<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laudo;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Yajra\DataTables\DataTables;

class LaudoController extends Controller
{
    public function index()
    {
        $laudos = Laudo::all();
        $profissionais = Profissional::all();
        $pacientes = Paciente::all();
        $tipos_consultas = TipoConsulta::all();
        // return view('laudos.index', compact('laudos', 'profissionais', 'pacientes','tipos_consultas'));
        return redirect()->back();
    }

    public function create()
    {
        $profissionais = Profissional::all();
        $pacientes = Paciente::all();
        $tipos_consultas = TipoConsulta::all();
        return view('laudos.create', compact('profissionais', 'pacientes', 'tipos_consultas'));
    }

    public function salvarAjax(Request $request)
    {
        $consultaId = $request->input('consulta_id');

        // Verificar se o laudo já existe para a consulta
        $laudo = Laudo::where('consulta_id', $consultaId)->first();

        if ($laudo) {
            // O laudo já existe, então atualize-o em vez de criar um novo
            $laudo->update($request->all());
            $message = 'O laudo foi atualizado com sucesso.';
        } else {
            // O laudo não existe, então crie um novo
            $laudo = Laudo::create($request->all());
            $message = 'O laudo foi criado com sucesso.';
        }

        return response()->json(['message' => $message, 'laudo' => $laudo]);
    }

    public function store(Request $request)
    {
        Laudo::create($request->all());
        return redirect()->back();
    }


    public function edit($id)
    {
        $laudo = Laudo::find($id);
        $profissionais = Profissional::all();
        $pacientes = Paciente::all();
        $tipos_consultas = TipoConsulta::all();
        return view('laudos.edit', compact('laudo', 'profissionais', 'pacientes', 'tipos_consultas'));
    }

    public function update(Request $request, $id)
    {
        $laudo = Laudo::find($id);
        $laudo->update($request->all());
        return redirect()->route('laudos.index');
    }

    public function destroy($id)
    {
        $laudo = Laudo::find($id);
        $laudo->delete();
        return redirect()->route('laudos.index');
    }

    public function paginacaoAjax(Request $request)
    {
        // Verifique se foi fornecida uma data no parâmetro "data"
        $dataParam = $request->input('data');

        // Se nenhuma data for fornecida, obtenha todos os laudos
        if (!$dataParam) {
            $laudos = Laudo::with('paciente', 'profissional')->get();
        } else {
            // Verifique se a data fornecida é "todas"
            if ($dataParam === 'todas') {
                $laudos = Laudo::with('paciente', 'profissional')->get();
            } else {
                // Filtrar os laudos pela data fornecida
                $laudos = Laudo::with('paciente', 'profissional')
                    ->whereDate('data', $dataParam)
                    ->get();
            }
        }
        return Datatables::of($laudos)
            ->addColumn('paciente.nome', function ($laudo) {
                return $laudo->paciente->nome;
            })
            ->addColumn('paciente.cpf', function ($laudo) {
                return $laudo->paciente->cpf;
            })
            ->addColumn('profissional.nome', function ($laudo) {
                return $laudo->profissional->nome;
            })
            ->make(true);
    }

}
