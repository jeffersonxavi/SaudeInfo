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
        Schema::create('especialidade_profissional', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('especialidade_id');
            $table->unsignedBigInteger('profissional_id');
            $table->foreign('especialidade_id')->references('id')->on('especialidades')->onDelete('cascade');
            $table->foreign('profissional_id')->references('id')->on('profissionais')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialidade_profissional');
    }
};
