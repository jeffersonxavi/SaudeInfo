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

        $total_consultas = array_sum($data); // Calcula o número total de consultas

        $now = Carbon::now(); // Obtém a data e horário atual

        // Últimas 5 consultas do horário atual
        $proximas_consultas =  Consulta::where('dia_consulta', '>=', $now->toDateString())
            ->where(function ($query) use ($now) {
                $query->where('dia_consulta', '>', $now->toDateString())
                    ->orWhere(function ($query) use ($now) {
                        $query->where('dia_consulta', '=', $now->toDateString())
                            ->where('hora_consulta', '>', $now->toTimeString());
                    });
            })
            ->orderBy('dia_consulta')
            ->orderBy('hora_consulta')
            ->take(10)
            ->get();

        //Total
        $consultas_do_dia = Consulta::where('dia_consulta', $now)->count();
        $total_profissionais = Profissional::count();
        $total_pacientes = Paciente::count();
        $mediaConsultasPaciente = $total_pacientes != 0 ? $total_consultas / $total_pacientes : 0;
        $mediaConsultasProfissional =  $total_profissionais != 0 ? $total_consultas / $total_profissionais : 0;

        //Gráfifco Pizza
        $pie_tipos_consultas = TipoConsulta::withCount('consultas')->orderByDesc('consultas_count')->limit(5)->get();
        $labels2 = $pie_tipos_consultas->pluck('nome');
        $data2 = $pie_tipos_consultas->pluck('consultas_count');

        $graficoTipoConsulta = [
            'labels' => $labels2,
            'datasets' => [
                [
                    'label' => 'Consultas mais realizadas',
                    'tension' => 0.1,
                    'fill' => true,
                    'data' => $data2,
                    'backgroundColor' => ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'],
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
