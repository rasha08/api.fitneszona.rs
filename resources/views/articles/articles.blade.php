@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading">Kategorije
            </div>

          @foreach($data['categories'] as $category)
          <li class="list-group-item row col-md-11 col-xs-offset-1">
            <a class="col-md-8" href={{ url('articles/category/'.$category) }}>
              <h4>{{ $category }}</h4>
            </a>
          </li>
          @endforeach
        </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Tekstovi
                  <br>
                  <form class="form-inline col-md-10 col-md-offset-1" >
                  <input class="form-control col-md-10" style="width: 80%;" type="text" placeholder="Jos uvek nije implementirano" aria-label="Search">
                      <button class="btn btn-success col-md-2" type="submit">pretrazi</button>
                </form>
                <br><br>
                </div>
                 @if (@$data['success'] === 'create')
                    <h2 class="alert alert-success">
                        <strong>Uspesno ste dodali tekst!</strong>
                    </h2>
                 @elseif (@$data['success'] ==='update')
                    <h2 class="alert alert-success">
                        <strong>Uspesno ste izmenili tekst! </strong>
                    </h2>
                 @elseif (@$data['success'] ==='delete')
                    <h2 class="alert alert-success">
                        <strong>Uspesno ste obrisali tekst! </strong>
                    </h2>
                  @elseif (@$data['success'] ==='already in db')
                    <h2 class="alert alert-danger">
                        <strong>Dati tekst je vec unet u bazu podataka! </strong>
                    </h2>
                 @endif
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <li class="list-group-item row col-md-11 col-md-offset-1 well">
                        <h4 class="col-md-8">NAPRAVI TEKST</h4>
                        <a class="btn btn-info col-md-4" href="/articles/create" role="button">KREIRAJ</a>
                    </li>

                    @if (@$data)
                      @foreach(@$data['articles'] as $article)
                            <li class="list-group-item row col-md-11 col-md-offset-1">
                                <a class="col-md-8" href={{'articles/'.$article->id }}>
                                  <h4>{{ $article->id }} || {{ $article->title }}</h4>
                                </a>
                                <a class="btn btn-default col-md-2 col-sm-6" href={{'articles/'.$article->id.'/edit' }} role="button">IZMENI</a>

                                <form method="POST" action="{{ url('/articles/'.$article->id) }}">
                                  <input name="_method" type="hidden" value="DELETE">
                                  <button class="btn btn-danger col-md-2 col-sm-6" role="button" type="submit">
                                    OBRISI
                                  </button>
                                </form>
                            </li>
                      @endforeach
                      {{ @$data['articles']->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection