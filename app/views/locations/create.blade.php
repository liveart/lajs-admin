@extends('layouts.scaffold')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>New Location</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'locations.store', 'files' => true, 'class' => 'form-horizontal')) }}
        {{ Form::hidden('product_id', $product_id) }}
        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('image', 'Image URL:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::text('image', Input::old('image'), array('class'=>'form-control', 'placeholder'=>'Image URL')) }}
                {{ Form::file('imageFile') }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('editableArea', 'Editable Area:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10 form-inline">
                {{ Form::text('left', Input::old('left'), array('class'=>'form-control', 'placeholder'=>'Left')) }}
                {{ Form::text('top', Input::old('top'), array('class'=>'form-control', 'placeholder'=>'Top')) }}
                {{ Form::text('right', Input::old('right'), array('class'=>'form-control', 'placeholder'=>'Right')) }}
                {{ Form::text('bottom', Input::old('bottom'), array('class'=>'form-control', 'placeholder'=>'Bottom')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('editableAreaUnits', 'Editable Area Units:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10 form-inline">
                {{ Form::text('width', Input::old('width'), array('class'=>'form-control', 'placeholder'=>'Width')) }}
                {{ Form::text('height', Input::old('height'), array('class'=>'form-control', 'placeholder'=>'Height')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('clipRect', 'Clip Rect:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10 form-inline">
                {{ Form::text('cr_left', Input::old('cr_left'), array('class'=>'form-control', 'placeholder'=>'Left')) }}
                {{ Form::text('cr_top', Input::old('cr_top'), array('class'=>'form-control', 'placeholder'=>'Top')) }}
                {{ Form::text('cr_right', Input::old('cr_right'), array('class'=>'form-control', 'placeholder'=>'Right')) }}
                {{ Form::text('cr_bottom', Input::old('cr_bottom'), array('class'=>'form-control', 'placeholder'=>'Bottom')) }}
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Create', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('products.edit', 'Cancel', $product_id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop