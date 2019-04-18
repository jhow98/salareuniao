@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="wrapper">
                <main>
                    <div class="jumbotron">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="display-4">Bem vindo, </h2>
                                <p class="lead"> {{ $name }}. </p>
                            </div>
                            <div class="col-md-6">
                                <p class="lead">Hoje é {{Carbon\Carbon::now()->formatLocalized('%A %d de %B de %Y.')}}</p>
                            </div>
                        </div>

                        <hr class="my-4">
                        @include('layouts._calendar')
                    </div>
                </main>
            </div>

        </div>
    </div>
    @endsection
