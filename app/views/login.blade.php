@extends('layouts.scaffold')

@section('main')
<style>
    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

    <div class="container">

        {{ Form::open(array('url' => 'login', 'class' => 'form-signin')) }}
            <h2 class="form-signin-heading">Please sign in</h2>
            {{ Form::label('email', 'Email address', array('class' => 'sr-only')) }}
            {{ Form::email('email', Input::old('email'), array('placeholder' => 'Email address', 'class' => 'form-control', 'required', 'autofocus')) }}
            {{ Form::label('password', 'Password', array('class' => 'sr-only')) }}
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
            {{ Form::submit('Sign in', array('class' => 'btn btn-lg btn-primary btn-block')) }}
        {{ Form::close() }}

    </div> <!-- /container -->

@stop