<?php

namespace Database\Factories;

use App\Models\Especialidade;
use App\Models\TipoConsulta;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class TipoConsultaFactory extends Factory
{
    use HasFactory;

    protected $model = TipoConsulta::class;

    public function definition()
    {
        $this->faker = \Faker\Factory::create('pt_BR');
        $tiposConsultas = [
            // Tipos de consultas que você já possui
            'Consulta Médica',
            'Exame de Rotina',
            'Avaliação Cardiológica',
            'Check-up Geral',
            'Consulta Dermatológica',
            'Consulta Gastroenterológica',
            'Consulta Neurológica',
            'Consulta Ortopédica',
            'Consulta Oftalmológica',
            'Consulta Otorrinolaringológica',
            'Consulta Urológica',
            'Consulta Endocrinológica',
            'Consulta Radiológica',
            'Consulta Hematológica',
            'Consulta Infectológica',
            'Consulta Nefrológica',
            'Consulta Psiquiátrica',
            'Consulta Oncológica',
            'Consulta Pediátrica',
            'Consulta Ginecológica',
            'Cirurgia Cardiovascular',
            'Cirurgia Plástica',
            'Cirurgia Torácica',
            'Cirurgia Neurológica',
            'Anestesia Geral',
        
            // Tipos de exames adicionais
            'Exame de Sangue',
            'Ressonância Magnética',
            'Tomografia Computadorizada',
            'Ultrassonografia',
            'Eletrocardiograma',
            'Colonoscopia',
            'Endoscopia',
            'Mamografia',
            'Ecocardiograma',
            'Eletroencefalograma',
            'Radiografia',
            'Hemograma',
            'Cintilografia',
            'Densitometria Óssea',
            'Holter',
            'Espirometria',
            'Teste Ergométrico',
            'Colonoscopia',
            'Eletroretinografia',
            // Adicione mais tipos de exames conforme necessário
        ];
        
        $frasesDescricao = [
            'Realização da {tipoConsulta} com um renomado especialista em {especialidade}.',
            'Consulta {tipoConsulta} para diagnóstico, tratamento e acompanhamento personalizado.',
            'Avaliação {tipoConsulta} com um profissional experiente e altamente qualificado.',
            'Exame {tipoConsulta} completo para verificação precisa da sua saúde geral.',
            'Consulta {tipoConsulta} para acompanhamento do seu quadro clínico e orientações médicas.',
            'Procedimento {tipoConsulta} realizado com sucesso e resultados satisfatórios.',
            'Consulta {tipoConsulta} com um especialista para obter orientações e cuidados específicos.',
            'Tratamento {tipoConsulta} realizado por uma equipe especializada e comprometida.',
            'Realização da {tipoConsulta} com foco na prevenção de doenças e promoção da saúde.',
            'Consulta {tipoConsulta} voltada para melhoria da sua qualidade de vida e bem-estar.',
            'Avaliação {tipoConsulta} completa para identificação de possíveis problemas e intervenções necessárias.',
            'Exame {tipoConsulta} para monitoramento contínuo da sua condição de saúde.',
            'Consulta {tipoConsulta} com suporte emocional e orientação abrangente ao paciente.',
            'Procedimento {tipoConsulta} personalizado para melhorar sua saúde e bem-estar geral.',
            'Consulta {tipoConsulta} com cuidados específicos e tratamentos personalizados.',
            'Tratamento {tipoConsulta} integrado com abordagem multidisciplinar para melhores resultados.',
            'Realização da {tipoConsulta} com resultados precisos e confiáveis para sua tranquilidade.',
            'Consulta {tipoConsulta} para esclarecimento de dúvidas e questões relacionadas à sua saúde.',
            'Avaliação {tipoConsulta} para manutenção da sua saúde em longo prazo e prevenção de complicações.',
            // Adicione mais frases conforme necessário
        ];
        
        
        
        $descricao = $this->faker->unique()->randomElement($frasesDescricao);
        $tipoConsulta = $this->faker->unique()->randomElement($tiposConsultas);
        $especialidade = \App\Models\Especialidade::factory()->create()->nome; // Ajuste para obter o nome da especialidade corretamente
        
        $descricao = str_replace('{tipoConsulta}', $tipoConsulta, $descricao);
        $descricao = str_replace('{especialidade}', $especialidade, $descricao);
        
        return [
            'nome' => $tipoConsulta,
            'especialidade_id' => function () {
                return Especialidade::inRandomOrder()->first()->id;
            },
            'duracao_estimada' => $this->faker->numberBetween(30, 120),
            'descricao' => $descricao,
            'valor' => $this->faker->randomFloat(2, 50, 200),
        ];        
    }
}
