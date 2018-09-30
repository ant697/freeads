@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{--            @include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"> {{ $user->name }}</div>
                    <div class="card-body">
<!--                        --><?php //die(var_dump('<pre>', '<h3>previous</h3>', url()->previous(), '</pre>')); ?>
                        <a href="{{ url('posts/') }}" title="Retour"><button class="btn btn-warning btn-sm"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Retour</button></a>
                        @if (Auth::check() && Auth::id() === $user->id || Auth::user()->role === 'admin')
                            <a href="{{ url('users/' . $user->id . '/edit') }}" title="Editer"><button class="btn
                            btn-primary btn-sm"><i class="far fa-edit"></i>Editer</button></a>
                            <form method="POST" action="{{ url('users' . '/' . $user->id) }}" accept-charset="UTF-8"
                                  style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Post" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="far fa-trash-alt"></i> Supprimer</button>
                            </form>
                        @else
                            <a href=" {{ url('posts?user=' . $user->id) }} " title="Posts">
                                <button class="btn btn-light btn-sm">
                                    <i class="fas fa-search"></i>
                                   {{ $user->nbrPosts }} Posts
                                </button>
                            </a>
                        @endif
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                {{--<tr>--}}
                                {{--<th>ID</th><td>{{ $user->id }}</td>--}}
                                {{--</tr>--}}
                                <tr><th> Nom </th><td> {{ $user->name }} </td></tr><tr><th> Mail </th><td> {{
                                    $user->email }} </td></tr>
                                <tr><th>Role</th><td> {{ ($user->role === 'user') ? 'Utilisateur' : 'Administrateur' }}
                                    </td></tr>
                                <tr><th>Membre depuis :</th><td>{{ $user->created_at }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
