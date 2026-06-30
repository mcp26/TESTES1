<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['veiculo_id', 'tipo_manutencao_id', 'user_id', 'data_manutencao', 'valor_medicao'])]
class Manutencao extends Model
{
    protected $table = 'manutencoes';

    protected function casts(): array
    {
        return [
            'data_manutencao' => 'date',
            'valor_medicao' => 'decimal:2',
        ];
    }

    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function tipoManutencao(): BelongsTo
    {
        return $this->belongsTo(TipoManutencao::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pecas(): BelongsToMany
    {
        return $this->belongsToMany(Peca::class, 'manutencao_peca')
            ->withPivot('marca_id', 'quantidade');
    }
}
