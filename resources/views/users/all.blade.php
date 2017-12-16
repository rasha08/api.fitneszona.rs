@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Korisnici sajta fitneszona.rs</div>
                <div class="panel-body">
                    <div class="row well col-md-12">
                        <div class="col-md-6">
                            <button class="btn btn-block btn-default">Statistika Aktivnosti Korisnika</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-block btn-info" onclick="openModal('all-modal')">Pošalji obaveštenje svim korisnicima</button>
                        </div>
                    </div>

                    <div class="custom-modal col-md-12 table-bordered" style="position: absolute; z-index: -9999; box-shadow: 5px, 3px, 10px, black !important; margin-left: -4.5%;margin-right:auto; background-color: snow; opacity: 0; margin-top: -200px; min-height: 600px;"
                        id="all-modal">
                        <div class="row">
                            <div class="modal-header">
                                <div type="button" class="close" aria-label="Close" onclick="closeCustomModal('all-modal')">
                                    <span aria-hidden="true">&times;</span>
                                </div>
                                <h4 class="modal-title">OBAVEŠTENJE ZA SVE KORISNIKE </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-body">
                                <form class="form-horizontal" method="POST" action="{{ url('notification/all/users') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label for="title" class="col-md-1 control-label">Naslov</label>
                                        <div class="col-md-11">
                                            <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}"> @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                        <label for="text" class="col-md-5 col-md-offset-1 control-label center"></label>
                                        <div class="col-md-12">
                                            <textarea id="article-ckeditor-all-modal" class="form-control" name="text">{{ old('text') }}</textarea> @if ($errors->has('text'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('text') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                        <label for="title" class="col-md-1 control-label">Url</label>
                                        <div class="col-md-11">
                                            <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}"> @if ($errors->has('url'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">OK</button>
                                            <div class="btn btn-warning" onclick="closeCustomModal('all-modal')">ODUSTANI</div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    </form>




                    @foreach($users as $user)
                    <div class="form-group{{ $errors->has($user->id) ? ' has-error' : '' }}">
                        <div class="checkbox left col-md-12 alert">
                            <label for="{{$user->id}}" class="left col-md-12 control-label">
                                <h4 class="col-md-12">
                                    <span class="well">id: {{ $user->id }} </span>
                                    <span class="well">
                                        <strong> {{ $user->first_name }} {{ $user->last_name }} </strong>
                                    </span>
                                    <span class="well"> email: {{ $user->email }} </span>
                                </h4>
                            </label>
                            @if ($errors->has($user->id))
                            <span class="help-block">
                                <strong>{{ $errors->first($user->id) }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="right row col-md-offset-3 col-md-9">
                        <button class="btn btn-default">Statistika</button>
                        <button class="btn btn-info" onclick="openModal('{{$user->id}}-modal')">Posalji obavestenje</button>
                        <button class="btn btn-danger">Zabrani pristup korisniku</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="custom-modal col-md-12 table-bordered" style="position: absolute; z-index: -9999; box-shadow: 5px, 3px, 10px, black !important; margin-left: -4.5%;margin-right:auto; background-color: snow; opacity: 0; margin-top: -200px; min-height: 600px;"
                        id="{{$user->id}}-modal">
                        <div class="row">
                            <div class="modal-header">
                                <div type="button" class="close" aria-label="Close" onclick="closeCustomModal('{{$user->id}}-modal')">
                                    <span aria-hidden="true">&times;</span>
                                </div>
                                <h4 class="modal-title">OBAVEŠTENJE ZA KORISNIKA {{ $user->first_name }} {{ $user->last_name }} </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-body">
                                <?php $url='/notification/'.$user->id ?>
                                <form class="form-horizontal" method="POST" action="{{ url($url) }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label for="title" class="col-md-1 control-label">Naslov</label>
                                        <div class="col-md-11">
                                            <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}"> @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                        <label for="text" class="col-md-5 col-md-offset-1 control-label center"></label>
                                        <div class="col-md-12">
                                            <textarea id="article-ckeditor-{{$user->id}}-modal" class="form-control" name="text">{{ old('text') }}</textarea> @if ($errors->has('text'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('text') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                        <label for="title" class="col-md-1 control-label">Url</label>
                                        <div class="col-md-11">
                                            <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}"> @if ($errors->has('url'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">OK</button>
                                            <div class="btn btn-warning" onclick="closeCustomModal('{{$user->id}}-modal')">ODUSTANI</div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    </form>
                    <br> @endforeach {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.opacity = 1;
        document.getElementById(modalId).style.zIndex = 9999;
        CKEDITOR.replace(`article-ckeditor-${modalId}`);
        if (modalId == 'all-modal') {
            document.getElementById(modalId).style.marginTop = '100px';
        }
    }

    function closeCustomModal(modalId) {
        document.getElementById(modalId).style.opacity = 0;
        document.getElementById(modalId).style.zIndex = -9999;
    }
</script> @endsection