@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{--@include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h1>Messages</h1></div>
                    <div class="card-body">
                        <a href="{{ url('/users/' . Auth::id() . '/messages') }}" class="btn btn-primary btn-sm"
                           title="Tous les message">
                            <i class="fas fa-list-ul"></i> Tous
                        </a>
                        <form method="GET" action="{{ url('/users/' . Auth::id() . '/messages') }}"
                              accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>


                        <br/>
                        <br/>
                        @if (!empty($messages['sent']->total()))
                            <h3 class="">Messages Envoyés</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th><th>Titre</th><th>Envoyeur</th><th>Receveur</th><th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($messages['sent'] as $item)
                                        <tr>
                                            <td>{{ $loop->iteration or $item->id }}</td>
                                            <td>{{ $item->title }}</td><td>{{$item->sender->name}}</td><td>{{ $item->receiver->name }}</td>
                                            <td>
                                                <a href="{{ url('/messages/' . $item->id) }}" title="View Message"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Voir</button></a>

                                                <form method="POST" action="{{ url('/messages' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Message" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="far fa-trash-alt"></i> Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $messages['sent']->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
                        @endif
                        @if (!empty($messages['received']->total()))
                            <h3 class=''>Messages Reçus</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th><th>Titre</th><th>Envoyeur</th><th>Receveur</th><th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($messages['received'] as $item)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration or $item->id }}

                                            </td>
                                            <td>{{ $item->title }}</td><td>{{$item->sender->name}}</td><td>{{ $item->receiver->name }}</td>
                                            <td>
                                                <a href="{{ url('/messages/' . $item->id) }}" title="View Message"><button class="btn btn-info btn-sm">
                                                        @if (!$item->viewed)
                                                            <i class="fas fa-envelope"></i>
                                                        @else
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        @endif
                                                        Voir</button></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{--<div class="pagination-wrapper"> {!! $messages->appends(['search' => Request::get('search')])->render() !!} </div>--}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
