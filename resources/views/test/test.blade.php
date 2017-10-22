@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Test Zona</div>
                @if($data['success'])
                <h1 class="alert alert-success">Akcija je uspesno izvrsena!</h1>
                @endif
                <form class="form" role="form" method="POST" action="{{ url('/test/action') }}">
                           {{ csrf_field() }}
                      <div class="form-group{{ $errors->has('test-user') ? ' has-error' : '' }}">
                           <label for="test-user" class="col-md-4 control-label">Izaberi Test Korisnika</label>
                           <div class="col-md-6">
                               <select class="form-control" id="test-user" name="test-user">
                                   @foreach($data['users'] as $user)
                                       <option value={{ $user->id }}>{{ $user->first_name.' '.$user->last_name}}</option>
                                   @endforeach
                               </select>
                               @if ($errors->has('test-user'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('test-user') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div>
                       <br><hr><br>
                       <div class="form-group{{ $errors->has('article') ? ' has-error' : '' }}">
                           <label for="article" class="col-md-12 control-label">Izaberi Tekst</label>
                           <div class="col-md-12">
                               <select class="form-control" id="article" name="article">
                                   @foreach($data['articles'] as $article)
                                       <option value={{ $article->id }}>
                                            | id: {{ $article->id }} | {{ $article->title }} ({{ $article->category }})
                                        </option>
                                   @endforeach
                               </select>
                               @if ($errors->has('article'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('article') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div>
                       <br><hr><br>
                       <div class="form-group{{ $errors->has('action') ? ' has-error' : '' }}">
                           <label for="action" class="col-md-6 control-label">Izaberi akciju</label>
                           <div class="col-md-6">
                               <select class="form-control" id="action" name="action" onchange="showCommentBox(this.value)">
                                    <option value="like" >Like Teksta</option>
                                    <option value="dislike">DisLike Teksta</option>
                                    <option value="comment">Komentarisi Tekst</option>
                                    <option value="addTextToVisited">Dodaj Tekst U Posecene Tekstove</option>
                                    <option value="addLikedCategory">Dodaj Kategoriju Teksta U Omiljene</option>
                                    <option value="addLikedTag">Dodaj Tag U Omiljene</option>
                               </select>
                               @if ($errors->has('action'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('action') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div>
                       <div class="form-group{{ $errors->has('comment_text') ? ' has-error' : '' }}" id="commentBox">
                         <br><br><hr><br>
                           <label for="comment_text" class="col-md-3 control-label center">Unesite Komentar za dati tekst</label>
                           <div class="col-md-9">
                               <textarea id="comment_text" class="form-control" name="comment_text"></textarea>
                               @if ($errors->has('comment_text'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('comment_text') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div>
                       <div class="form-group{{ $errors->has('liked_tag') ? ' has-error' : '' }}" id="likedTag">
                        <br><br><hr><br>
                           <label for="liked_tag" class="col-md-4 control-label">Unesi naziv oznake:</label>
                           <div class="col-md-8">
                               <input id="liked_tag" type="text" class="form-control" name="liked_tag">
                               @if ($errors->has('liked_tag'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('liked_tag') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div>
                       <br><br><hr>
                       <div class="clearfix"></div>
                       <div class="form-group">
                           <div class="col-md-4 col-md-offset-8">
                               <button type="submit" class="btn btn-success btn-large btn-block">
                                   <span></span> Izvrsi Akciju
                               </button>
                           </div>
                           <br><br><hr>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById('commentBox').style.display = 'none';
    document.getElementById('likedTag').style.display = 'none';


    function showCommentBox (value){
        if(value==='comment') {
           document.getElementById('commentBox').style.display = 'block';

           return;
        } else if (value === 'addLikedTag') {
           document.getElementById('likedTag').style.display = 'block';

           return;
        }

        document.getElementById('commentBox').style.display = 'none';
        document.getElementById('likedTag').style.display = 'none';
    }
</script>
@endsection