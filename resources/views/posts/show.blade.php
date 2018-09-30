@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{--            @include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Post {{ $post->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('posts') }}" title="Retour">
                            <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Retour
                            </button>
                        </a>
                        @if (Auth::check() && Auth::id() === $post->user_id || Auth::user()->role === 'admin')
                            <a href="{{ url('/posts/' . $post->id . '/edit') }}" title="Edit Post">
                                <button class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</button>
                            </a>
                            <form method="POST" action="{{ url('posts' . '/' . $post->id) }}" accept-charset="UTF-8"
                                  style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Post"
                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                            class="far fa-trash-alt"></i> Supprimer
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/messages/create/' . $post->id . '/' . $post->user_id . '/' . Auth::id())}}"
                               title="Contact">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-envelope"></i>
                                    Contact
                                </button>
                            </a>
                        @endif
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                {{--<tr>--}}
                                {{--<th>ID</th><td>{{ $post->id }}</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <th> Titre</th>
                                    <td> {{ $post->title }} </td>
                                </tr>
                                <tr>
                                    <th> Description
                                    </th>
                                    <td> {{ $post->content }} </td>
                                </tr>
                                <tr>
                                    <th> Prix</th>
                                    <td class="priceCol">
                                        <?php
                                        $splitedPrice = str_split(strrev($post->price));
                                        $newPrice = '';
                                        for ($i = 0; $i < count($splitedPrice); $i++) {
                                            if ($i % 3 === 0) {
                                                $newPrice .= ' ';
                                            }
                                            $newPrice .= $splitedPrice[$i];
                                        }
                                        $newPrice = strrev($newPrice);
                                        ?>
                                        {{ $newPrice }} €
                                    </td>
                                </tr>
                                <tr>
                                    <th> Vendeur</th>
                                    <td>
                                        <a href="{{ url('users/' . $post->user_id) }}">
                                            <i class="far fa-user"></i>
                                            {{ $post->user->name }}
                                        </a>
                                    </td>
                                </tr>
                                @if ($post->picture1 !== null)
                                    <tr>
                                        <th> Photo 1</th>
                                        <td>
                                            <img class="post-picture-view"
                                                 src="{{ asset('storage/' . $post->picture1) }}">
                                        </td>
                                    </tr>
                                @endif
                                @if ($post->picture2 !== null)
                                    <tr>
                                        <th> Photo 2</th>
                                        <td>
                                            <img class="post-picture-view"
                                                 src="{{ asset('storage/' . $post->picture2) }}">
                                        </td>
                                    </tr>
                                @endif
                                @if ($post->picture3 !== null)
                                    <tr>
                                        <th> Photo 3</th>
                                        <td>
                                            <img class="post-picture-view"
                                                 src="{{ asset('storage/' . $post->picture3) }}">
                                        </td>
                                    </tr>
                                @endif
                                @if ($post->picture4 !== null)
                                    <tr>
                                        <th> Photo 4</th>
                                        <td>
                                            <img class="post-picture-view"
                                                 src="{{ asset('storage/' . $post->picture4) }}">
                                        </td>
                                    </tr>
                                @endif
                                @if ($post->picture5 !== null)
                                    <tr>
                                        <th> Photo 5</th>
                                        <td>
                                            <img class="post-picture-view"
                                                 src="{{ asset('storage/' . $post->picture5) }}">
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
