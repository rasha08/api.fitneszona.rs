@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Kontrolna Tabla</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <li class="list-group-item row col-md-11 col-md-offset-1">
                        <h4 class="col-md-8">Tekstovi na fitneszona.rs</h4>
                        <a class="btn btn-default col-md-4" href="/articles" role="button">Prikazi</a>
                    </li>

                    <li class="list-group-item row col-md-11 col-md-offset-1">
                        <h4 class="col-md-8">Korisnici na fitneszona.rs</h4>
                        <a class="btn btn-default col-md-4" href="/articles" role="button">Prikazi</a>
                    </li>

                    <li class="list-group-item row col-md-11 col-md-offset-1">
                        <h4 class="col-md-8">Konfiguracija sajta fitneszona.rs</h4>
                        <a class="btn btn-default col-md-4" href="/articles" role="button">Prikazi</a>
                    </li>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
