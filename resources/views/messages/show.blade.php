@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
{{--            @include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Message {{ $message->id }}</div>
                    <div class="card-body">

                        <a href="{{ url()->previous() }}" title="Retour"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retour</button></a>
                        @if ($message->sender_id !== Auth::id())
                            <a href="{{ url('/messages/create/' . $message->post_id . '/' . $data['sender']->id . '/' .
                            $data['receiver']->id) }}" title="Reply Message"><button class="btn btn-primary
                            btn-sm">Répondre</button></a>
                        @else
                            <form method="POST" action="{{ url('messages' . '/' . $message->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Message" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="far fa-trash-alt"></i> Supprimer</button>
                            </form>
                        @endif
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    {{--<tr>--}}
                                        {{--<th>ID</th><td>{{ $message->id }}</td>--}}
                                    {{--</tr>--}}
                                    <tr><th> Titre </th><td> {{ $message->title }} </td></tr><tr><th> Contenu
                                        </th><td>
                                            {{ $message->content }} </td></tr>
                                    <tr>
                                        <th> De : </th>

                                        <td><a  href="{{ url('users/' . $data['sender']->id) }}">
                                                <i class="far fa-user"></i>
                                                {{ $data['sender']->name }}
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <th> A : </th>

                                        <td>
                                            <a href="{{ url('users/' . $data['receiver']->id) }}">
                                                <i class="far fa-user"></i>
                                                {{ $data['receiver']->name }}
                                            </a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th> A propos de : </th>
                                        <td>
                                            <a href="{{ url('posts/' . $data['post']->id) }}">
                                                <i class="fab fa-buysellads"></i>
                                                {{ $data['post']->title }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> Date </th>
                                        <td> {{ $message->created_at }} </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
