@extends('layouts.app')

@section('content')
   <div class="container-fluid">
       <div class="row">
           <div class="col-md-10 col-md-offset-1">
            {{ $data['configuration']['status'] ? '<h1 class="alert alert-success">Konfiguracija je uspesno promenjena!</h1' : ''}}
               <div class="panel panel-default">
                   <div class="panel-heading well">Konfiguracija sajta</div>
                  
                   <div class="panel-body">
                       <form class="form" role="form" method="POST" action="{{ url('/configuration/'.$data['configuration']['id']) }}">
                           {{ csrf_field() }}
                          <input name="_method" type="hidden" value="PUT">
                          <div class="form-group{{ $errors->has('home_page') ? ' has-error' : '' }}">
                               <label for="home_page" class="col-md-4 control-label">Izaberi Pocetnu Stranu Sajta</label>
                               <div class="col-md-6">
                                   <select class="form-control" id="home-page" name="home_page">
                                       <option value={{ $data['configuration']['home_page'] }}>{{ $data['configuration']['home_page'] }}</option>
                                       @foreach($data['validHomePageChoices'] as $home_page)
                                           <option value={{ $home_page }}>{{ $nameSlug = preg_replace('/_/', ' ', $home_page) }}</option>
                                       @endforeach
                                   </select>
                                   @if ($errors->has('home_page'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('home_page') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('theme') ? ' has-error' : '' }}">
                               <label for="theme" class="col-md-4 control-label">Izaberi Temu sajta</label>
                               <div class="col-md-6">
                                   <select class="form-control" id="theme" name="theme">
                                       <option value={{ $data['configuration']['theme'] }}>{{ $data['configuration']['theme'] }}</option>
                                       @foreach($data['validThemes'] as $theme)
                                           <option value={{ $theme }}>{{ $theme }}</option>
                                       @endforeach
                                   </select>
                                   @if ($errors->has('theme'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('theme') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('number_of_articles_in_sidebar') ? ' has-error' : '' }}">
                               <label for="number_of_articles_in_sidebar" class="col-md-6 control-label">Broj tekstova u sidebar-u (po jednom tagu)</label>
                               <div class="col-md-6">
                                   <input id="number_of_articles_in_sidebar" type="number" class="form-control" name="number_of_articles_in_sidebar" value="{{ $data['configuration']['number_of_articles_in_sidebar'] }}">
                                   @if ($errors->has('number_of_articles_in_sidebar'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('number_of_articles_in_sidebar') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('is_registration_enabled') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je na sajtu dozvoljena registracija novim korisnicima?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="is_registration_enabled " class="left col-md-12 control-label">
                                <input name="is_registration_enabled" id="is_registration_enabled" type="checkbox" {{ $data['configuration']['is_registration_enabled'] ? 'checked' : '' }}>Dozvoli Registraciju
                              </label>
                              @if ($errors->has('is_registration_enabled'))
                                <span class="help-block">
                                   <strong>{{ $errors->first('is_registration_enabled') }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('is_login_enabled') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je na sajtu dozvoljena prijava postojecim korisnicima?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="is_login_enabled " class="left col-md-12 control-label">
                                <input name="is_login_enabled" id="is_login_enabled" type="checkbox" {{ $data['configuration']['is_login_enabled'] ? 'checked' : '' }}>
                                Dozvoli Prijavu
                              </label>
                              @if ($errors->has('is_login_enabled'))
                                <span class="help-block">
                                   <strong>{{ $errors->first('is_login_enabled') }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('is_landing_page_enabled') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je "Landing Page" omogucen?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="is_landing_page_enabled" class="left col-md-12 control-label">
                                <input name="is_landing_page_enabled" id="is_landing_page_enabled" type="checkbox" {{ $data['configuration']['is_landing_page_enabled'] ? 'checked' : '' }}>
                                Omoguci Landing Page
                              </label>
                              @if ($errors->has('is_landing_page_enabled'))
                                <span class="help-block">
                                   <strong>{{ $errors->first('is_landing_page_enabled') }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                           <br><hr><br>
                            <div class="form-group{{ $errors->has('is_chat_bot_enabled') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je "Chat Bot" omogucen?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="is_chat_bot_enabled" class="left col-md-12 control-label">
                                <input name="is_chat_bot_enabled" id="is_chat_bot_enabled" type="checkbox" {{ $data['configuration']['is_chat_bot_enabled'] ? 'checked' : '' }}>
                                Omoguci Chat Bot
                              </label>
                              @if ($errors->has('is_chat_bot_enabled'))
                                <span class="help-block">
                                   <strong>{{ $errors->first('is_chat_bot_enabled') }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('is_google_map_enabled') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je "Google Map" omogucen?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="is_google_map_enabled" class="left col-md-12 control-label">
                                <input name="is_google_map_enabled" id="is_google_map_enabled" type="checkbox" {{ $data['configuration']['is_google_map_enabled'] ? 'checked' : '' }}>
                                Omoguci Google Map
                              </label>
                              @if ($errors->has('is_google_map_enabled'))
                                <span class="help-block">
                                   <strong>{{ $errors->first('is_google_map_enabled') }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                           <br><hr><br>
                            <div class="form-group{{ $errors->has('is_fitness_creator_enabled') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je "Fitness Creator" omogucen?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="is_fitness_creator_enabled" class="left col-md-12 control-label">
                                <input name="is_fitness_creator_enabled" id="is_fitness_creator_enabled" type="checkbox" {{ $data['configuration']['is_fitness_creator_enabled'] ? 'checked' : '' }}>
                                Omoguci Fitness Creator
                              </label>
                              @if ($errors->has('is_fitness_creator_enabled'))
                                <span class="help-block">
                                   <strong>{{ $errors->first('is_fitness_creator_enabled') }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                            @foreach($data['validHomePageChoices'] as $category)
                            <br><hr><br>
                            <div class="form-group{{ $errors->has($category) ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Da li je stranica <span style="font-size: 1.5em">{{ preg_replace('/_/', ' ', $category)  }}</span> omogucena?</label>
                             <div class="checkbox left col-md-4"> 
                               <label for="{{$category}}" class="left col-md-12 control-label">
                                <input name="{{$category}}" id="{{ $category }}" type="checkbox" {{ in_array($category,$data['activeCategories']) ? 'checked' : '' }}>
                                Omoguci kategoriju
                              </label>
                              @if ($errors->has($category))
                                <span class="help-block">
                                   <strong>{{ $errors->first($category) }}</strong>
                                </span>
                              @endif
                            </div>
                           </div>
                           @endforeach
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('banner_image_url') ? ' has-error' : '' }}">
                               <label for="banner_image_url" class="col-md-4 control-label">Url adresa banner slike:</label>
                               <div class="col-md-8">
                                   <input id="banner_image_url" type="text" class="form-control" name="banner_image_url" value="{{ $data['configuration']['banner_image_url'] }}">
                                   @if ($errors->has('banner_image_url'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('banner_image_url') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><hr><br>
                           <div class="form-group{{ $errors->has('banner_text') ? ' has-error' : '' }}">
                               <label for="banner_text" class="col-md-2 control-label center">Tekst Na banner-u sajta</label>
                               <div class="col-md-10">
                                   <textarea id="banner_text" class="form-control" name="banner_text">{{ $data['configuration']['banner_text'] }}</textarea>
                                   @if ($errors->has('banner_text'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('banner_text') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><br><hr><br>
                           <div class="form-group{{ $errors->has('about_us') ? ' has-error' : '' }}">
                               <label for="about_us" class="col-md-2 control-label center">O Nama</label>
                               <div class="col-md-10">
                                   <textarea id="about_us" class="form-control" name="about_us">{{ $data['configuration']['about_us'] }}</textarea>
                                   @if ($errors->has('about_us'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('about_us') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><br><hr><br>
                           <div class="form-group{{ $errors->has('text_for_email_response') ? ' has-error' : '' }}">
                               <label for="text_for_email_response" class="col-md-3 control-label center">Default odgovor nakon email-a korisnika</label>
                               <div class="col-md-9">
                                   <textarea id="article-ckeditor" class="form-control" name="text_for_email_response">{{ $data['configuration']['about_us'] }}</textarea>
                                   @if ($errors->has('text_for_email_response'))
                                       <span class="help-block">
                                           <strong>{{ $errors->first('text_for_email_response') }}</strong>
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <br><br><hr>
                           <div class="clearfix"></div>
                           <div class="form-group">
                            <br><br><hr>
                               <div class="col-md-4 col-md-offset-8">
                                   <button type="submit" class="btn btn-success btn-large btn-block">
                                       <span></span> Sacuvaj Konfiguraciju
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


