<?php

namespace Database\Seeders;

use App\Models\Manutencao;
use App\Models\Marca;
use App\Models\Peca;
use App\Models\TipoManutencao;
use App\Models\TipoVeiculo;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $master = User::create([
            'name' => 'Administrador',
            'email' => 'master@example.com',
            'password' => Hash::make('password'),
            'role' => 'master',
            'email_verified_at' => now(),
        ]);

        $junior = User::create([
            'name' => 'Técnico Junior',
            'email' => 'junior@example.com',
            'password' => Hash::make('password'),
            'role' => 'junior',
            'email_verified_at' => now(),
        ]);

        $caminhao = TipoVeiculo::create(['nome' => 'Caminhão', 'unidade_medida' => 'km']);
        $gerador = TipoVeiculo::create(['nome' => 'Gerador', 'unidade_medida' => 'horas']);
        $empilhadeira = TipoVeiculo::create(['nome' => 'Empilhadeira', 'unidade_medida' => 'horas']);

        $volvo = Marca::create(['nome' => 'Volvo']);
        $scania = Marca::create(['nome' => 'Scania']);
        $mobil = Marca::create(['nome' => 'Mobil']);
        $castrol = Marca::create(['nome' => 'Castrol']);
        Marca::create(['nome' => 'Bosch']);

        $filtroOleo = Peca::create(['nome' => 'Filtro de Óleo']);
        $oleoMotor = Peca::create(['nome' => 'Óleo Motor']);
        Peca::create(['nome' => 'Filtro de Ar']);
        Peca::create(['nome' => 'Pastilha de Freio']);
        Peca::create(['nome' => 'Correia Dentada']);

        $trocaOleo = TipoManutencao::create(['nome' => 'Troca de Óleo', 'intervalo' => 10000]);
        $trocaOleo->tiposVeiculo()->attach([$caminhao->id]);

        $revisaoGeral = TipoManutencao::create(['nome' => 'Revisão Geral', 'intervalo' => 500]);
        $revisaoGeral->tiposVeiculo()->attach([$gerador->id, $empilhadeira->id]);

        $trocaFiltroAr = TipoManutencao::create(['nome' => 'Troca de Filtro de Ar', 'intervalo' => 20000]);
        $trocaFiltroAr->tiposVeiculo()->attach([$caminhao->id, $empilhadeira->id]);

        $caminhao001 = Veiculo::create([
            'nome' => 'Caminhão 001',
            'tipo_veiculo_id' => $caminhao->id,
            'marca_id' => $volvo->id,
            'data_aquisicao' => now()->subYears(2),
            'placa' => 'ABC1D23',
            'ativo' => true,
        ]);

        $gerador001 = Veiculo::create([
            'nome' => 'Gerador 001',
            'tipo_veiculo_id' => $gerador->id,
            'marca_id' => $scania->id,
            'data_aquisicao' => now()->subYear(),
            'placa' => 'N/A',
            'ativo' => true,
        ]);

        $caminhao001->usuarios()->attach($junior->id);
        $gerador001->usuarios()->attach($junior->id);

        $manutencao = Manutencao::create([
            'veiculo_id' => $caminhao001->id,
            'tipo_manutencao_id' => $trocaOleo->id,
            'user_id' => $master->id,
            'data_manutencao' => now()->subMonths(2),
            'valor_medicao' => 4000,
        ]);
        $manutencao->pecas()->attach($filtroOleo->id, ['marca_id' => $mobil->id, 'quantidade' => 1]);
        $manutencao->pecas()->attach($oleoMotor->id, ['marca_id' => $castrol->id, 'quantidade' => 5]);
    }
}
