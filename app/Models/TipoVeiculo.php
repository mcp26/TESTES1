<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'unidade_medida'])]
class TipoVeiculo extends Model
{
    public function veiculos(): HasMany
    {
        return $this->hasMany(Veiculo::class);
    }

    public function tiposManutencao(): BelongsToMany
    {
        return $this->belongsToMany(TipoManutencao::class, 'tipo_manutencao_tipo_veiculo');
    }
}
