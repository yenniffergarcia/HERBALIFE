
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title>IMEDCHI</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link href="{{ asset('bower_components/assets/css/reset.css') }}" rel="stylesheet" />
        <link href="{{ asset('bower_components/assets/css/supersized.css') }}" rel="stylesheet" />  
        <link href="{{ asset('bower_components/assets/css/style.css') }}" rel="stylesheet" />   

    </head>

<body>

@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">

    <link href="{{ asset('bower_components/assets/css/reset.css') }}" rel="stylesheet" />
    <link href="{{ asset('bower_components/assets/css/supersized.css') }}" rel="stylesheet" />  
    <link href="{{ asset('bower_components/assets/css/style.css') }}" rel="stylesheet" />       
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
@include('flash::message')
    <div class="page-container">
        <div class="login-box">
            <div class="login-logo">
                <a style="color: black;" href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
            </div>


                <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                    {!! csrf_field() !!}

                        <input type="text" name="email" class="username" value="{{ old('email') }}"
                               placeholder="E-mail / Username">
                        @if ($errors->has('email'))
                            <span class="help-block" style="color: red;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                        <input type="password" name="password" class="password"
                               placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block" style="color: red;"
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    <div class="error"><span></span></div>
                    <div class="row">
                        <div class="col-xs-8">
                            <!--<div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>-->
                        </div>
                        <div class="col-xs-4">
                            <button type="submit">Entrar</button>
                        </div>
                    </div>
                </form>

        </div>
    </div>

    <script src="{{ asset('bower_components/assets/js/jquery-1.8.2.min.js') }}"></script>
    <script src="{{ asset('bower_components/assets/js/supersized.3.2.7.min.js') }}"></script>
    <script src="{{ asset('bower_components/assets/js/supersized-init.js') }}"></script>
    <script src="{{ asset('bower_components/assets/js/scripts.js') }}"></script>

</body>
</html>  
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    <script>
        $('#flash-overlay-modal').modal();
    </script>      
    @yield('js')
@stop
