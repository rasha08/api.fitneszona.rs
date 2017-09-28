@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="col-md-6"></div>
                    @if (@$data)
                      <a class="btn btn-info col-md-3 col-sm-6" href={{ $data['article']->id.'/edit' }} role="button">IZMENI</a>
                      
                      <form method="POST" action="{{ url('/articles/'.$data['article']->id) }}">
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-warning col-md-3 col-sm-6" role="button" type="submit">
                          OBRISI
                        </button>
                      </form>
                </div>
                <div class="panel-body">
                    <h1>{{ $data['article']->title }}</h1>
                    <div class="row">
                      <div class="col-md-1"><h3>Opis: </h3></div>
                      <div class="col-md-10">
                        <p class="well">{{ $data['article']->description }}
                        </p>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-3 col-md-offset-5"><h3>Teks (HTML): </h3>
                      </div>
                        <div class="col-md-10 col-md-offset-1 well">
                          {{ $data['article']->text }}
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-md-3">
                        <span class="alert alert-info">kategotija: 
                          {{ $data['article']->category }}
                        </span>
                      </div>
                      <div class="col-md-9">
                        @foreach(explode('|', $data['article']->tags) as $tag)
                          <span class="alert alert-warning">{{ $tag }}</span>
                        @endforeach
                      </div>
                    </div>
                    <br><br>
                    <div class="row">
                      <div class="col-md-4">kreiran: {{ $data['article']->created_at }}</div>
                      <div class="col-md-4">vidjen puta: {{ $data['article']->seen_times }}</div>    
                      <div class="col-md-4">Dali je tekst menjan: 
                        {{ $data['article']->created_at === $data['article']->updated_at }}</div>        
                     </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection