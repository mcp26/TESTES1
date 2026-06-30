<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'intervalo'])]
class TipoManutencao extends Model
{
    protected $table = 'tipo_manutencoes';

    public function tiposVeiculo(): BelongsToMany
    {
        return $this->belongsToMany(TipoVeiculo::class, 'tipo_manutencao_tipo_veiculo');
    }

    public function manutencoes(): HasMany
    {
        return $this->hasMany(Manutencao::class);
    }
}
