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
        Schema::create('manutencoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->restrictOnDelete();
            $table->foreignId('tipo_manutencao_id')->constrained('tipo_manutencoes')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->date('data_manutencao');
            $table->decimal('valor_medicao', 10, 2)->unsigned();
            $table->timestamps();
            $table->index(['veiculo_id', 'tipo_manutencao_id', 'valor_medicao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manutencaos');
    }
};
