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
        Schema::create('tipo_manutencao_tipo_veiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_manutencao_id')->constrained('tipo_manutencoes')->cascadeOnDelete();
            $table->foreignId('tipo_veiculo_id')->constrained('tipo_veiculos')->cascadeOnDelete();
            $table->unique(['tipo_manutencao_id', 'tipo_veiculo_id'], 'tm_tv_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_manutencao_tipo_veiculo');
    }
};
