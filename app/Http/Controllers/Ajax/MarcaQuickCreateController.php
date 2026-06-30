<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarcaRequest;
use App\Models\Marca;

class MarcaQuickCreateController extends Controller
{
    public function store(StoreMarcaRequest $request)
    {
        $marca = Marca::create($request->validated());

        return response()->json(['id' => $marca->id, 'nome' => $marca->nome], 201);
    }
}
