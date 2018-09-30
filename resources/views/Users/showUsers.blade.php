@extends('layouts.app')
@section('content')
    <h1 class="text-center">User</h1>
    <ul class="list-unstyled">
        <li>
            <h2>Nom : {{ $user->name }}</h2>
        </li>
        <li>
            <h2>Email : {{ $user->email }}</h2>
        </li>
        <li>
            <h2>Date de création : {{ $user->created_at }}</h2>
        </li>

    </ul>
@endsection