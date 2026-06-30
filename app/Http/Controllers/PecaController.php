<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePecaRequest;
use App\Models\Peca;

class PecaController extends Controller
{
    public function index()
    {
        $pecas = Peca::orderBy('nome')->get();

        return view('pecas.index', compact('pecas'));
    }

    public function create()
    {
        return view('pecas.create');
    }

    public function store(StorePecaRequest $request)
    {
        Peca::create($request->validated());

        return redirect()->route('pecas.index')->with('success', 'Peça cadastrada com sucesso.');
    }
}
