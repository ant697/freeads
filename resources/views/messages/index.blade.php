@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{--@include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Messages</div>
                    <div class="card-body">
                        <a href="{{ url('/messages/create') }}" class="btn btn-success btn-sm" title="Add New Message">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/messages') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Titre</th><th>Content</th><th>Envoyeur</th><th>Receveur</th><th>Post</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($messages as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->title }}</td><td>{{ $item->content }}</td><td>{{
                                        $item->sender->name
                                        }}</td><td>{{ $item->receiver->name }}</td><td>{{ $item->post->title }}</td>
                                        <td>
                                            <a href="{{ url('/messages/' . $item->id) }}" title="View Message"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Voir</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $messages->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
