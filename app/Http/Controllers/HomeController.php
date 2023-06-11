<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {


        $consultas = Consulta::selectRaw('EXTRACT(MONTH FROM dia_consulta) as month, COUNT(*) as count')
            ->whereYear('dia_consulta', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];
        $colors = [
            'rgb(75, 192, 192)',
            // '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#E91E63',
            // '#00BCD4', '#009688', '#4CAF50', '#8BC34A', '#CDDC39'
        ];

        $currentYear = date('Y');
        $locale = 'pt_BR';

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create($currentYear, $i, 1)->locale($locale)->monthName;
            $count = 0;

            foreach ($consultas as $consulta) {
                if ($consulta->month == $i) {
                    $count = $consulta->count;
                    break;
                }
            }

            array_push($labels, $month);
            array_push($data, $count);
        }


        $graficoConsultaMes = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Quantidade de consultas por mês',
                    'data' => $data,
                    'tension' => 0.1,
                    'fill' => true,
                    'backgroundColor' => $colors
                ]
            ]
        ];

        $user = auth()->user();

        $paciente = Paciente::where('user_id', $user->id)->first();
        $profissional = Profissional::where('user_id', $user->id)->first();

        $now = Carbon::now(); // Obtém a data e horário atual

        $consultas_do_dia = Consulta::query();
        $total_consultas =  Consulta::query();
        $total_pacientes = Paciente::query();
        $total_profissionais = Profissional::query();
        $total_pacientes_profissional = 0;


        // Últimas 5 consultas do horário atual
        $proximas_consultas =  Consulta::where('dia_consulta', '>=', $now->toDateString());
        if ($user->can('user')) {
            $proximas_consultas->where('paciente_id', $paciente->id);
            $consultas_do_dia->where('paciente_id', $paciente->id);
            $total_consultas->where('paciente_id', $paciente->id);
            $total_pacientes->where('id', $paciente->id);
        } elseif ($user->can('profissional')) {
            $proximas_consultas->where('profissional_id', $profissional->id);
            $consultas_do_dia->where('profissional_id', $profissional->id);
            $total_consultas->where('profissional_id', $profissional->id);
            $total_pacientes_profissional = $profissional->consultas()->distinct('paciente_id')->count('paciente_id');
            
            
        }
        $proximas_consultas->where(function ($query) use ($now) {
            $query->where('dia_consulta', '>', $now->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->where('dia_consulta', '=', $now->toDateString())
                        ->where('hora_consulta', '>', $now->toTimeString());
                });
        })
            ->orderBy('dia_consulta')
            ->orderBy('hora_consulta')
            ->take(10);

        $proximas_consultas = $proximas_consultas->get();


        //Total


        $total_consultas = $total_consultas->count();
        $total_pacientes = $total_pacientes->count();
        $total_profissionais = $total_profissionais->count();
        $consultas_do_dia = $consultas_do_dia->where('dia_consulta', $now)->count();

        $mediaConsultasPaciente = $total_pacientes != 0 ? $total_consultas / $total_pacientes : 0;
        $mediaConsultasProfissional =  $total_profissionais != 0 ? $total_consultas / $total_profissionais : 0;

        //Gráfifco Pizza

        $consultas = Consulta::query();

        if ($user->can('user')) {
            $paciente = Paciente::where('user_id', $user->id)->first();
            $consultas->where('paciente_id', $paciente->id);
        } elseif ($user->can('profissional')) {
            $profissional = Profissional::where('user_id', $user->id)->first();
            $consultas->where('profissional_id', $profissional->id);
        }


        $tipos_consultas = TipoConsulta::whereHas('consultas', function ($query) use ($user) {
            if ($user->can('user')) {
                $query->whereHas('paciente', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            } elseif ($user->can('profissional')) {
                $query->whereHas('profissional', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            }
        })

            ->withCount(['consultas' => function ($query) use ($consultas) {
                $query->whereIn('id', $consultas->select('id'));
            }])
            ->orderByDesc('consultas_count')
            ->take(10)
            ->get();


        $labels2 = $tipos_consultas->pluck('nome');
        $data2 = $tipos_consultas->pluck('consultas_count');

        $graficoTipoConsulta = [
            'labels' => $labels2,
            'datasets' => [
                [
                    'label' => 'Consultas mais realizadas',
                    'tension' => 0.1,
                    'fill' => true,
                    'data' => $data2,
                    'backgroundColor' => ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff8c00', '#00bfff', '#7fff00', '#ff1493', '#008080'],
                ],
            ],
        ];

        $avisos = Aviso::where('data_criacao', '<=', $now)
            ->where('data_expiracao', '>=', $now)
            ->get();
        $total_avisos = $avisos->count();

        return view('dashboard', compact(
            'graficoConsultaMes',
            'total_consultas',
            'total_pacientes_profissional',
            'proximas_consultas',
            'consultas_do_dia',
            'total_profissionais',
            'total_pacientes',
            'mediaConsultasPaciente',
            'mediaConsultasProfissional',
            'graficoTipoConsulta',
            'total_avisos',
            'avisos'
        ));
    }
}
