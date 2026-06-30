<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcaRequest;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::orderBy('nome')->get();

        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(StoreMarcaRequest $request)
    {
        Marca::create($request->validated());

        return redirect()->route('marcas.index')->with('success', 'Marca cadastrada com sucesso.');
    }
}
