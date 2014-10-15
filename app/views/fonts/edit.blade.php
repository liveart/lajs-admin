@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Font</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($font, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('fonts.update', $font->id))) }}

        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('fontFamily', 'FontFamily:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('fontFamily', Input::old('fontFamily'), array('class'=>'form-control', 'placeholder'=>'FontFamily')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('ascent', 'Ascent:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'ascent', Input::old('ascent'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('vector', 'Vector:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('vector', Input::old('vector'), array('class'=>'form-control', 'placeholder'=>'Vector')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('options', 'Options:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::label('boldAllowed', 'Allow bold', array('class'=>'control-label')) }}
                {{ Form::checkbox('boldAllowed', Input::old('boldAllowed'), true) }}<br/>
                {{ Form::label('italicAllowed', 'Allow italic', array('class'=>'control-label')) }}
                {{ Form::checkbox('italicAllowed', Input::old('italicAllowed'), true) }}<br/>
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('fonts.show', 'Cancel', $font->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop