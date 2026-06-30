<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $veiculos = Veiculo::where('ativo', true)->orderBy('nome')->get();

        return view('admin.users.create', compact('veiculos'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->safe()->only(['name', 'email', 'role']);
        $data['password'] = Hash::make($request->validated('password'));

        $user = User::create($data);
        $user->veiculos()->sync($request->input('veiculos', []));

        return redirect()->route('admin.users.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function edit(User $user)
    {
        $veiculos = Veiculo::where('ativo', true)->orderBy('nome')->get();
        $user->load('veiculos');

        return view('admin.users.edit', compact('user', 'veiculos'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->safe()->only(['name', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->validated('password'));
        }

        $user->update($data);
        $user->veiculos()->sync($request->input('veiculos', []));

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso.');
    }
}
