@extends('layouts.scaffold')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Color</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($color, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('colors.update', $color->id))) }}
    <div class="form-group">
        {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
          {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('value', 'HEX Code:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
          {{ Form::text('value', Input::old('value'), array('class'=>'form-control', 'placeholder'=>'Hex Code, e.g. #00EE76')) }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-sm-10">
          {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
          @if (count($color->products) > 0)
                {{ link_to_route('products.edit', 'Cancel', array($color->products[0]->id), array('class' => 'btn btn-lg btn-default')) }}
              @else
                {{ link_to_route('colors.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
          @endif
        </div>
    </div>

{{ Form::close() }}

@stop