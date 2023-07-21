<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsulta;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Laudo;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ConsultaController extends Controller
{
    public function paginacaoAjax(Request $request)
    {
        $dataParam = $request->input('data');

        $query = Consulta::with('paciente', 'profissional', 'tipoConsulta', 'laudo');

        if ($dataParam) {
            if ($dataParam !== 'todas') {
                $query->whereDate('dia_consulta', $dataParam);
            }
        }

        if (auth()->user()->can('profissional')) {
            $profissional = Profissional::where('user_id', auth()->user()->id)->first();
            $query->where('profissional_id', $profissional->id);
        } elseif (auth()->user()->can('user')) {
            $paciente = Paciente::where('user_id', auth()->user()->id)->first();
            $query->where('paciente_id', $paciente->id);
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

    public function consultaProfissional(Request $request)
    {
        $profissionalId = $request->input('profissionalId');
        $dataParam = $request->input('data');

        $query = Consulta::with('paciente', 'profissional', 'tipoConsulta')
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

    public function index()
    {
        $consultas = Consulta::all();
        $profissionais = Profissional::all();
        return view('consultas.index', compact('consultas', 'profissionais'));
    }

    public function buscarPaciente(Request $request)
    {
        $procurar = $request->input('nome');
        $procurar = str_replace(['.', '-'], '', $procurar); // Remover pontos e traços do CPF

        $pacientes = Paciente::where(function ($query) use ($procurar) {
            $query->where('nome', 'ilike', '%' . $procurar . '%')
                ->orWhere('cpf', 'LIKE', '%' . $procurar . '%');
        })->get();

        return response()->json($pacientes);
    }





    public function create()
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
        $pacientes = Paciente::all();
        $profissionais = Profissional::all();
        $tiposConsultas = TipoConsulta::all();
        return view('consultas.create', compact('pacientes', 'profissionais', 'tiposConsultas'));
    }

    public function store(StoreConsulta $request)
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }        
        $consulta = Consulta::create($request->all());
        $profissional = Profissional::find($request->profissional_id);

        $profissional->pacientes()->syncWithoutDetaching($request->input('paciente_id'));
        return redirect()->route('consultas.index')->with('success','Consulta de ' .$consulta->paciente->nome. ' agendada!');
    }

    public function edit($id)
    {
        $consulta = Consulta::find($id);
        if (!Auth::user()->can('admin') && !$consulta->paciente->user_id !== Auth::user()->id && $consulta->profissional->user_id !== Auth::user()->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $pacientes = Paciente::all();
        $profissionais = Profissional::all();
        $tiposConsultas = TipoConsulta::all();
        $laudo = Laudo::where('consulta_id', $id)->first();
        return view('consultas.edit', compact('consulta', 'pacientes', 'profissionais', 'tiposConsultas', 'laudo'));
    }

    public function update(StoreConsulta $request, $id)
    {
        $consulta = Consulta::find($id);
        $consulta->update($request->all());
        $profissional = Profissional::find($request->profissional_id);
        if ($profissional) {
            $profissional->pacientes()->syncWithoutDetaching($request->input('paciente_id'));
        }
        
        if ($request->has('laudo')) {
            $laudo = Laudo::where('consulta_id', $id)->first();
            $laudo->update($request->all());
        }
        return redirect()->route('consultas.edit', $id)->with('success','Consulta de ' .$consulta->paciente->nome. ' atualizada!');
    }

    public function destroy($id)
    {
        $consulta = Consulta::find($id);
        $consulta->delete();
        return redirect()->route('consultas.index');
    }

    public function buscarProfissional(Request $request)
    {
        $procurar = $request->nome;
        $dataSelecionada = $request->data; // Novo parâmetro de data

        if ($procurar) {
            $procurar = str_replace(['.', '-'], '', $procurar); // Remover pontos e traços do CPF

            $profissionais = Profissional::where('nome', 'iLIKE', "%$procurar%")->get();

            foreach ($profissionais as $profissional) {
                $consultas = Consulta::where('profissional_id', $profissional->id)
                    ->whereDate('dia_consulta', $dataSelecionada) // Usar a data selecionada na cláusula WHERE
                    ->count();

                $profissional->num_consultas = $consultas;
                $profissional->data_selecionada = $dataSelecionada; // Adicionar a data selecionada à resposta JSON
            }
        }

        return response()->json($profissionais);
    }



    public function updateStatus(Request $request)
    {
        $consultaId = $request->input('consultaId');
        $novoStatus = $request->input('novoStatus');


        // Atualize o status da consulta no banco de dados
        $consulta = Consulta::find($consultaId);
        $consulta->status = $novoStatus;
        $consulta->save();

        // Retorne uma resposta adequada, se necessário
        return response()->json(['message' => 'Status atualizado com sucesso']);
    }
    public function getConsultaDetails($id)
    {
        $consulta = Consulta::with('profissional', 'paciente', 'tipoConsulta')->findOrFail($id);
        $laudo = Laudo::where('consulta_id', $id)->first();

        if ($laudo) {
            $consulta->laudo = $laudo;
        }

        return response()->json($consulta);
    }
}
