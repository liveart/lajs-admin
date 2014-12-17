@extends('layouts.scaffold', array('page_title'=>'Editing product'))
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Location For {{{ $location->product->name }}}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($location, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('locations.update', $location->id))) }}
        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('image', 'Image URL:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('image', Input::old('image'), array('class'=>'form-control', 'placeholder'=>'Thumbnail URL')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('editableArea', 'Editable Area:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10 form-inline">
                {{ Form::text('left', $left, array('class'=>'form-control', 'placeholder'=>'Left')) }}
                {{ Form::text('top', $top, array('class'=>'form-control', 'placeholder'=>'Top')) }}
                {{ Form::text('right', $right, array('class'=>'form-control', 'placeholder'=>'Right')) }}
                {{ Form::text('bottom', $bottom, array('class'=>'form-control', 'placeholder'=>'Bottom')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('editableAreaUnits', 'Editable Area Units:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10 form-inline">
                {{ Form::text('width', $width, array('class'=>'form-control', 'placeholder'=>'Width')) }}
                {{ Form::text('height', $height, array('class'=>'form-control', 'placeholder'=>'Height')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('clipRect', 'Clip Rect:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10 form-inline">
                {{ Form::text('cr_left', $cr_left, array('class'=>'form-control', 'placeholder'=>'Left')) }}
                {{ Form::text('cr_top', $cr_top, array('class'=>'form-control', 'placeholder'=>'Top')) }}
                {{ Form::text('cr_right', $cr_right, array('class'=>'form-control', 'placeholder'=>'Right')) }}
                {{ Form::text('cr_bottom', $cr_bottom, array('class'=>'form-control', 'placeholder'=>'Bottom')) }}
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('products.edit', 'Cancel', $location->product->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop