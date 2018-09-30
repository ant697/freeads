@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
{{--            @include('admin.sidebar')--}}

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create New Post</div>
                    <div class="card-body">
                        <a href="{{ url()->previous() }}" title="Retour"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retour</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/posts') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('posts.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
