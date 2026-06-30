@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <h3 class="mb-4">Meu Perfil</h3>

    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
