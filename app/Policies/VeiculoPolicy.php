<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Veiculo;

class VeiculoPolicy
{
    public function view(User $user, Veiculo $veiculo): bool
    {
        return $user->isMaster() || $user->veiculos->contains($veiculo->id);
    }

    public function update(User $user, Veiculo $veiculo): bool
    {
        return $user->isMaster();
    }

    public function delete(User $user, Veiculo $veiculo): bool
    {
        return $user->isMaster();
    }
}
