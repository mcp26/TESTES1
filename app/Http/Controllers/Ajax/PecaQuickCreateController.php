<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePecaRequest;
use App\Models\Peca;

class PecaQuickCreateController extends Controller
{
    public function store(StorePecaRequest $request)
    {
        $peca = Peca::create($request->validated());

        return response()->json(['id' => $peca->id, 'nome' => $peca->nome], 201);
    }
}
