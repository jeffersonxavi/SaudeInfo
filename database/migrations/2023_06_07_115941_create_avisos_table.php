<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->date('data_criacao');
            $table->date('data_expiracao')->nullable();
            $table->date('data_aviso')->nullable();
            $table->enum('prioridade', ['alta', 'media', 'baixa']);
            $table->enum('estado', ['pendente', 'em_andamento', 'concluido']);
            $table->string('responsavel');
            // $table->string('departamento');
            // $table->string('tipo_aviso');
            // $table->text('destinatarios');
            // $table->text('anexos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
