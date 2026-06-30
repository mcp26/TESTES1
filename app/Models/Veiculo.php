<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'nome', 'tipo_veiculo_id', 'marca_id', 'data_aquisicao', 'placa',
    'documento_path', 'vencimento_documento', 'vencimento_seguro', 'ativo',
])]
class Veiculo extends Model
{
    protected function casts(): array
    {
        return [
            'data_aquisicao' => 'date',
            'vencimento_documento' => 'date',
            'vencimento_seguro' => 'date',
            'ativo' => 'boolean',
        ];
    }

    public function tipoVeiculo(): BelongsTo
    {
        return $this->belongsTo(TipoVeiculo::class);
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'usuario_veiculo');
    }

    public function manutencoes(): HasMany
    {
        return $this->hasMany(Manutencao::class);
    }
}
