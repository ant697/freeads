@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{--            @include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Posts</div>
                    <div class="card-body">
                        {{--<a href="{{ url('/posts/create') }}" class="btn btn-success btn-sm" title="Add New Post">--}}
                            {{--<i class="fa fa-plus" aria-hidden="true"></i> Add New--}}
                        {{--</a>--}}

                        <form method="GET" action="{{ url('/posts') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                    <th>#</th><th>Titre</th><th> Photo </th><th>Categorie</th><th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            @if ($item->picture1 === null)
                                                <img class="post-nopicture" src="{{ asset('images/none.png') }}">
                                            @else
                                                <img class="post-picture" src="{{ asset('storage/' . $item->picture1) }}">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('posts?category=' . $item->category) }}">
                                                {{ $item->category }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/posts/' . $item->id) }}" title="View Post"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Voir</button></a>

                                            @if (Auth::check() && Auth::id() === $item->user_id  || Auth::user()->role === 'admin')
                                                <a href="{{ url('/posts/' . $item->id . '/edit') }}" title="Edit Post"><button class="btn btn-primary btn-sm"><i class="far fa-edit"></i></i> Edit</button></a>
                                                <form method="POST" action="{{ url('/posts' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Post" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="far fa-trash-alt"></i> Supprimer</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $posts->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection