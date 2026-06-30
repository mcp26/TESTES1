<?php

namespace App\Policies;

use App\Models\Manutencao;
use App\Models\User;
use App\Models\Veiculo;

class ManutencaoPolicy
{
    public function view(User $user, Manutencao $manutencao): bool
    {
        return $user->isMaster() || $user->veiculos->contains($manutencao->veiculo_id);
    }

    public function createFor(User $user, Veiculo $veiculo): bool
    {
        return $user->isMaster() || $user->veiculos->contains($veiculo->id);
    }
}
