<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" >
    <meta name="author" content="Simcy Creative">
    <link rel="icon" type="image/png" sizes="16x16" href="{{  asset('uploads/app/yv91yZHRY2MB84Y3vAnyGz89LYOBLDYm.png') }}">
    <title>{{__('pages.sections.login')}} </title>
    <!-- Material design icons -->
    <link href="{{ asset('assets/fonts/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/simcify.min.css') }}" rel="stylesheet">
    <!-- Signer CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>


<div class="auth-page">
        <div class="auth-card card">
            <div class="auth-logo">
                {{-- <img src="{{ asset('uploads/app/'.env('APP_LOGO')) }}" class="img-responsive"> --}}
            </div>
            <div class="login">
                <div class="auth-heading mt-15">
                    <h2>{{__('auth.auth-form.login-title')}}</h2>
                    <p>{{__('auth.auth-form.login-intro')}}</p>
                </div>
                <div class="auth-form">
                    <form class="simcy-form" action="{{ route('auth.login') }}" data-parsley-validate="" method="POST" loader="true">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.label.email')}}</label>
                                    {{-- @if ( env('APP_ENV') == "demo" )
                                        <input type="email" class="form-control" name="email" value="demo123@gmail.com" placeholder="{{__('auth.auth-form.placeholder.email')}}" >
                                    @else
                                        <input type="email" class="form-control" name="email" placeholder="{{__('auth.auth-form.placeholder.email')}}" >
                                    @endif --}}
                                    <input type="text" class="form-control" name="email" value="" placeholder="{{__('auth.auth-form.placeholder.email')}}" >
                                    @if ($errors->has('email'))
                                    <span class="text-danger" style="font-size: 15px!important; height:40px; padding-top: 4px;"> <i>* {{ $errors->first('email') }}</i></span>
                                    @endif
                                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.label.password')}}</label>
                                    {{-- @if ( env('APP_ENV') == "demo" )
                                        <input type="password" class="form-control" name="password" value="passqw" placeholder="{{__('auth.auth-form.placeholder.password')}}" >
                                    @else
                                        <input type="password" class="form-control" name="password" placeholder="{{__('auth.auth-form.placeholder.password')}}" >
                                    @endif --}}
                                    <input type="password" class="form-control" name="password" value="" placeholder="{{__('auth.auth-form.placeholder.password')}}" >
                                    @if ($errors->has('password'))
                                    <span class="text-danger" style="font-size: 15px!important; height:40px; padding-top: 4px;"> <i>* {{ $errors->first('password') }}</i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                  <a href="" class="auth-switch pull-right mt-10 text-muted text-thin" show=".forgot">{{__('auth.links.forgot')}}</a>
                                 
                                    <button type="submit" class="btn btn-primary">{{__('auth.button.login')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
              
                <div class="">
                  <p class="text-muted text-thin mt-40">{{__('auth.messages.no-account')}} <a href="" class="auth-switch text-primary" show=".register">{{__('auth.links.create')}}</a></p>
                </div>
              
            </div>
            <div class="forgot">
                <div class="auth-heading mt-15">
                    <h2>{{__('auth.auth-form.forgot-title')}}</h2>
                    <p>{{__('auth.auth-form.forgot-intro')}}</p>
                </div>
                <div class="auth-form">
                    <form class="simcy-form" action="{{ url('Auth@forgot') }}" data-parsley-validate="" method="POST" loader="true">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.label.email')}}</label>
                                    <input type="email" class="form-control" name="email" placeholder="{{__('auth.auth-form.placeholder.email')}}" required="">
                                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-block">{{__('auth.button.reset')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="">
                  <p class="text-muted text-thin mt-40">{{__('auth.messages.remembered')}} <a href="" class="auth-switch text-primary" show=".login">{{__('auth.links.login')}}</a></p>
                </div>
            </div>
            {{-- @if ( env('NEW_ACCOUNTS') == "Enabled" )  --}}
            <div class="register" >
                <div class="auth-heading mt-15">
                    <h2>{{__('auth.auth-form.create-title')}}</h2>
                    <p>{{__('auth.auth-form.create-intro')}}</p>
                </div>
                <div class="auth-form">
                    <form class="simcy-form" action="{{ route('auth.signup') }}"  data-parsley-validate="" method="POST" loader="true">
                        @csrf
                       
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.label.first-name')}}</label>
                                    <input type="text" class="form-control" name="lname" placeholder="{{__('auth.auth-form.label.first-name')}}" required="">
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.placeholder.last-name')}}</label>
                                    <input type="text" class="form-control" name="fname" placeholder="{{__('auth.auth-form.placeholder.last-name')}}" required="">
                                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.label.email')}}</label>
                                    <input type="email" class="form-control" name="email" placeholder="{{__('auth.auth-form.placeholder.email')}}" required="">
                                    @if ($errors->has('email'))
                                    <span class="text-danger" style="font-size: 15px!important; height:40px; padding-top: 4px;"> <i>* {{ $errors->first('email') }}</i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('auth.auth-form.label.password')}}</label>
                                    <input type="password" class="form-control" name="password" placeholder="{{__('auth.auth-form.placeholder.password')}}" required="">
                                    @if ($errors->has('password'))
                                    <span class="text-danger" style="font-size: 15px!important; height:40px; padding-top: 4px;"> <i>* {{ $errors->first('password') }}</i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-block">{{__('auth.button.create')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="">
                  <p class="text-muted text-thin mt-40">{{__('auth.messages.have-account')}} <a href="" class="auth-switch text-primary" show=".login">{{__('auth.links.login')}}</a></p>
                </div>
            </div>
            {{-- @endif --}}
    </div>
    <p class="copyright text-thin text-muted"> &copy; {{ date("Y") }} {{ env("APP_NAME") }} <span>•</span> {{__('pages.footer')}}</p>
</div>

    <!-- scripts -->
    <script src="{{ url('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/simcify-lang.js"></script> <!-- js language translation -->
    <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js//jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/js/simcify.min.js')}}"></script>
    <!-- custom scripts -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{ url('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/lang.js"></script> <!-- js language translation -->

</body>
</html>
