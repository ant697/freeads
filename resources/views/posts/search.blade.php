@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{--            @include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Posts</div>
                    <div class="card-body">
                        <a href="{{ url('/posts/create') }}" class="btn btn-success btn-sm" title="Add New Post">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        <a href="{{ url('/posts/') }}" class="btn btn-primary btn-sm"
                           title="Tous les Posts">
                            <i class="fas fa-list-ul"></i> Tous
                        </a>
                        <form method="GET" action="{{ url('/posts') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <label>Categorie</label>
                                <select name="category" class="form-control" id="category" >
                                    @foreach (json_decode('{"": "Aucun","Multimedia":"Multimedia",
                                    "Immobilier":"Immobilier","Vehicules":"Vehicules","Loisirs":"Loisirs",
                                    "Materiel Pro":"Materiel Pro","Services":"Services","Maison":"Maison"}', true) as $optionKey => $optionValue)
                                        <option value="{{ $optionKey }}" {{ (request('category') == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    <label>Prix</label>
                                    <div class="form-inline">
                                        <input type="number" class="form-control form-inline" name="priceMin"
                                               placeholder="Price minimum..." value="{{ request('priceMin') }}">
                                        <input type="number" class="form-control form-inline" name="priceMax"
                                               placeholder="Price maximum..." value="{{ request('priceMax') }}">
                                    </div>
                                    <div class="form-inline">
                                        <input type="checkbox" class="form-control form-inline" name="picture"
                                               value="true">
                                        <label>
                                            Uniquement avec photo
                                        </label>
                                    </div>
                                </div>

                                <span class="input-group-append ">
                                    <button class="btn btn-secondary " type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>

                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            @if ((count($posts) > 1 && isset($posts[0])) || (!empty($posts) && !isset($posts[0])))
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th>#</th><th>Titre</th><th>Description</th><th>Photo</th><th>Prix</th><th>Categorie</th><th
                                            >Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = max(array_keys($posts)); $i >= 1; $i--)
                                            @if (isset($posts[$i]))
                                                @foreach($posts[$i] as $item)

                                                    <tr>
                                                        <td>{{ $loop->iteration or $item->id }}</td>
                                                        <td>{{ $item->title }}</td>
                                                        <td>
                                                            {{ (strlen($item->content) > 50) ? substr($item->content, 0, 50) . "..." : $item->content }}
                                                        </td>
                                                        <td>
                                                            @if ($item->picture1 === null)
                                                                <img class="post-nopicture" src="{{ asset('images/none.png') }}">
                                                            @else
                                                                <img class="post-picture" src="{{ asset('storage/' . $item->picture1) }}">
                                                            @endif
                                                        </td>
                                                        <td class="priceCol">
                                                            <?php
                                                            $splitedPrice = str_split(strrev($item->price));
                                                            $newPrice = '';
                                                            for ($j = 0; $j < count($splitedPrice); $j++) {
                                                                if ($j % 3 === 0) {
                                                                    $newPrice .= ' ';
                                                                }
                                                                $newPrice .= $splitedPrice[$j];
                                                            }
                                                            if (strlen($newPrice) > 10) {
                                                                $newPrice = substr(strrev($newPrice), 0, 9) . '...';
                                                            } else {
                                                                $newPrice = strrev($newPrice);
                                                            }
                                                            ?>
                                                            {{ $newPrice }} €

                                                        </td>
                                                        <td>
                                                            <a href="{{ url('posts?category=' . $item->category) }}">
                                                                {{ $item->category }}
                                                            </a>
                                                        </td>

                                                        <td>
                                                            <a href="{{ url('/posts/' . $item->id) }}" title="View Post"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Voir</button></a>
                                                            @if (Auth::check() && Auth::id() === $item->user_id || Auth::user()->role === 'admin')
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
                                            @endif
                                    @endfor
                                    </tbody>
                                </table>
                            @else
                                <h3 class="text-warning"> Aucun résultat trouvé</h3>
                            @endif
                        </div>

                        {{--<div class="pagination-wrapper">{!! $totalPosts->appends(['search' => Request::get('search')])->render() !!}</div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
