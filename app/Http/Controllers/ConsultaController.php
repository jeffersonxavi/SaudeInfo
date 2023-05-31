<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class ConsultaController extends Controller
{
    public function paginacaoAjax(Request $request)
    {
        // Verifique se foi fornecida uma data no parâmetro "data"
        $dataParam = $request->input('data');

        // Se nenhuma data for fornecida, obtenha todas as datas
        if (!$dataParam) {
            $data = Consulta::with('paciente', 'profissional', 'tipoConsulta')->get();
        } else {
            // Verifique se a data fornecida é "todas"
            if ($dataParam === 'todas') {
                $data = Consulta::with('paciente', 'profissional', 'tipoConsulta')->get();
            } else {
                // Filtrar as consultas pela data fornecida
                $data = Consulta::with('paciente', 'profissional', 'tipoConsulta')
                    ->whereDate('dia_consulta', $dataParam)
                    ->get();
            }
        }
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

        //é preciso instalar a extensão unaccent no PostgreSQL:
        $pacientes = Paciente::where(function ($query) use ($procurar) {
            $query->whereRaw("unaccent(nome) ILIKE unaccent('%$procurar%')")
                ->orWhereRaw("REPLACE(cpf, '.', '') LIKE '%$procurar%'");
        })->get();

        return response()->json($pacientes);
    }





    public function create()
    {
        $pacientes = Paciente::all();
        $profissionais = Profissional::all();
        $tiposConsultas = TipoConsulta::all();
        return view('consultas.create', compact('pacientes', 'profissionais', 'tiposConsultas'));
    }

    public function store(Request $request)
    {
        Consulta::create($request->all());
        return redirect()->route('consultas.index');
    }

    public function edit($id)
    {
        $consulta = Consulta::find($id);
        $pacientes = Paciente::all();
        $profissionais = Profissional::all();
        $tiposConsultas = TipoConsulta::all();
        return view('consultas.edit', compact('consulta', 'pacientes', 'profissionais', 'tiposConsultas'));
    }

    public function update(Request $request, $id)
    {
        $consulta = Consulta::find($id);
        $consulta->update($request->all());
        return redirect()->route('consultas.index');
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
            $profissionais = Profissional::where('nome', 'LIKE', "%$procurar%")->get();
    
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
}
