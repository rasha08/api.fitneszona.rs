@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Korisnici sajta fitneszona.rs</div>

                <div class="panel-body">
                    @foreach($users as $user)
                    <li class="list-group-item row col-md-11 col-md-offset-1">
                        <h4 class="col-md-12">id: {{ $user->id }} || <b>{{ $user->first_name }} {{ $user->last_name }}</b> || email: {{ $user->email }} ||</h4>
                    </li>
                    @endforeach

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection