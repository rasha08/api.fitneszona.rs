@extends('layouts.app')


@section('content')
   <div class="container-fluid">
       <div class="row">
           <div class="col-md-10 col-md-offset-1">
               <div class="panel panel-default">
                   <div class="panel-heading well">Kreiraj tekst</div>
                  
                   <div class="panel-body">
                       <form class="form-horizontal" role="form" method="POST" action="{{ url('/articles') }}">
                           {{ csrf_field() }}
                           <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                               <label for="title" class="col-md-1 control-label">Naslov</label>
                               <div class="col-md-11">
                                   <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                                   @if ($errors->has('title'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('title') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                               <label for="description" class="col-md-2 control-label center">Kratak Opis Teksta</label>
                               <div class="col-md-10">
                                   <textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>
                                   @if ($errors->has('description'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('description') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                               <label for="text" class="col-md-5 col-md-offset-1 control-label center">Tekst</label>
                               <div class="col-md-12">
                                   <textarea id="article-ckeditor" class="form-control" name="text">{{ old('text') }}</textarea>
                                   @if ($errors->has('text'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('text') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="form-group{{ $errors->has('image_url') ? ' has-error' : '' }}">
                               <label for="image_url" class="col-md-5 control-label">Tagovi (tagovi se dodaju sintaksom tag1|tag2|tag3</label>
                               <div class="col-md-7">
                                   <input id="image_url" type="text" class="form-control" name="image_url" value="{{ old('image_url') }}">
                                   @if ($errors->has('image_url'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('image_url') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                               <label for="tags" class="col-md-5 control-label">TUrl adresa slike:</label>
                               <div class="col-md-7">
                                   <input id="tags" type="text" class="form-control" name="tags" value="{{ old('tags') }}">
                                   @if ($errors->has('tags'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('tags') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                               <label for="category" class="col-md-4 control-label">Izaberi Kategoriju Teksta</label>
                               <div class="col-md-6">
                                   <select class="form-control" id="category" name="category">
                                       <option value=''>izaberi...</option>
                                       @foreach($data['categories'] as $category)
                                           <option value={{ $category }}>{{ $category }}</option>
                                       @endforeach
                                   </select>
                                   @if ($errors->has('category'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('category') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="col-md-4 col-md-offset-8">
                                   <button type="submit" class="btn btn-success btn-large btn-block">
                                       <span></span> Kreiraj Tekst
                                   </button>
                               </div>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection


