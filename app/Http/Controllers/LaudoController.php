<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use App\Models\Laudo;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Yajra\DataTables\DataTables;
use Mpdf\Mpdf;

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

    public function gerarPDF($consulta_id)
    {
        // Obtenha os dados do laudo com base no ID da consulta
        $laudo = Laudo::where('consulta_id', $consulta_id)->first();

        // Verifique se o laudo existe
        if ($laudo) {
            // Crie o conteúdo do PDF
            $html = '
            <html>

            <head>
                <title>Laudo - ' . $laudo->paciente->nome . '</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            bottom: 70px;
                            top: 70px;

                        }
                        h1 {
                            color: #333;
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        h2 {
                            color: #333;
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .info {
                            margin-bottom: 10px;
                        }

                        .info-label {
                            font-weight: bold;
                        }
                        .footer {
                            text-align: right;
                            color: #000;
                            margin-top: 50px;
                            clear: both;
                        }
                        .centered-text {
                            text-align: center;
                            margin-bottom: 10px;
                        }
                        .right-aligned-text {
                            text-align: right;
                        }
                        section {
                            margin-bottom: 100px;
                        }
                        #assinatura {
                            position: fixed;
                            bottom: 0;
                            width: 100%;
                            text-align: center;
                            color: #888;
                        }
                    </style>
            </head>

            <body>
                <header>
                    <div class="clinic-info">
                        <span class="info-label">Nome da Clínica:</span> Saúde TECH
                        <br>
                        <span class="info-label">Endereço:</span> Rua ABC, 123 - Cidade, Estado
                        <br>
                        <span class="info-label">Telefone:</span> (00) 1234-5678
                        <br>
                        <span class="info-label">Website:</span> www.saudetech.com
                    </div>
                </header>
                <h2>Informações do Laudo</h2>

                <section>
                    <div class="info">
                        <span class="info-label">Data:</span> ' . $laudo->data . '
                    </div>
                    <div class="info">
                        <span class="info-label">Tipo de Consulta:</span> ' . $laudo->tipoConsulta->nome . '
                    </div>
                    <div class="info">
                        <span class="info-label">Profissional:</span> ' . $laudo->profissional->nome . '
                    </div>
                    <div class="info">
                        <span class="info-label">Paciente:</span> ' . $laudo->paciente->nome . '
                    </div>
                    <div class="info">
                        <span class="info-label">Data nascimento:</span> ' . $laudo->paciente->data_nascimento . '
                        (<span class="info-label">Idade: </span>' . $laudo->paciente->idade . ' anos)
                    </div>
                    <div class="info">
                        <span class="info-label">Motivo da Consulta:</span> ' . $laudo->motivo_consulta . '
                    </div>
                    <div class="info">
                        <span class="info-label">Diagnostíco:</span>
                        <p>' . $laudo->diagnostico . '</p>
                    </div>
                    <div class="info">
                        <span class="info-label">Tratamento:</span>
                        <p>' . $laudo->tratamento_recomendado . '</p>
                    </div>
                </section>


                <!-- <div id="assinatura" class="info">
                    <hr> 
                    <span class="signature-name">' . $laudo->profissional->nome . '</span> 
                    <br>
                    <span class="info-label">Cargo:</span> ' . $laudo->profissional->tipo_profissional . '
                    <br>
                </div> -->
                <div class="footer">
                    <hr> <!-- Adicione uma linha para a assinatura do profissional de saúde -->
                    <div class="centered-text">
                        Assinatura
                    </div>
                    <div class="right-aligned-text">
                        <span class="signature-name">' . $laudo->profissional->nome . '</span> <!-- Substitua "Dr. João da Silva" pelo nome do profissional -->
                        <br>
                        <span class="info-label">Cargo:</span> ' . $laudo->profissional->tipo_profissional . '
                    </div>
                </div>
                <div id="assinatura" class="info">
                    Laudo gerado em ' . date('d/m/Y H:i:s') . '
                </div>
                </div>

            </body>

            </html>
            ';

            // Crie uma instância do mPDF
            $mpdf = new Mpdf();

            // Configurações adicionais do mPDF
            $mpdf->SetHeader('Laudo - ' . $laudo->paciente->nome);
            $mpdf->SetFooter('{PAGENO}');

            // Carregue o HTML no mPDF
            $mpdf->WriteHTML($html);

            // Gere o nome do arquivo PDF com base no nome do paciente
            $fileName = 'laudo_' . $laudo->paciente->nome . '.pdf';

            // Saída do PDF para visualização inline
            $mpdf->Output($fileName, 'I');
        } else {
            // Lógica de tratamento quando o laudo não existe
        }
    }
}
