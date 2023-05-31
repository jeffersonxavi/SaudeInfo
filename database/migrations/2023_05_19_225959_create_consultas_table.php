<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('profissional_id');
            $table->unsignedBigInteger('tipo_consulta_id');
            $table->date('dia_marcacao');
            $table->date('dia_consulta');
            $table->time('hora_consulta');
            $table->text('descricao')->nullable();
            $table->integer('status');
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->foreign('tipo_consulta_id')->references('id')->on('tipos_consultas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
