@extends('layouts.scaffold')

@section('main')

<h1>Import JSON Data</h1>

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
        @if (isset($message))
            <div class="alert alert-success">
                {{{ $message }}}
            </div>
        @endif
    </div>
</div>
<div class="alert alert-warning" role="alert">Warning: existing data will be purged upon import.</div>

{{ Form::open(array('action' => 'ImportController@importGraphics')) }}
<div class="row">
    {{ Form::label('graphicsURL', 'Import Graphics JSON', array('class'=>'control-label')) }}
    <div class="input-group">
        {{ Form::text('graphicsURL', Input::old('graphicsURL'), array('class'=>'form-control', 'placeholder'=>'URL to Graphics JSON')) }}
        <span class="input-group-btn">
            {{ Form::submit('Import Gallery', array('class' => 'btn btn-default')) }}
        </span>
    </div>
</div>
{{ Form::close() }}

{{ Form::open(array('action' => 'ImportController@importFonts')) }}
<div class="row">
    {{ Form::label('fontsURL', 'Import Fonts JSON', array('class'=>'control-label')) }}
    <div class="input-group">
        {{ Form::text('fontsURL', Input::old('fontsURL'), array('class'=>'form-control', 'placeholder'=>'URL to Fonts JSON')) }}
        <span class="input-group-btn">
            {{ Form::submit('Import Fonts', array('class' => 'btn btn-default')) }}
        </span>
    </div>
</div>
{{ Form::close() }}

@stop