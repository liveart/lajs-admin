@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Create Gallery Item</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'graphicsItems.store', 'files' => true, 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>

        <?php 
            $cats = array(0 => 'Choose category');
            foreach (GraphicsCategory::get(array('id', 'name')) as $cat) {
            $cats[$cat->id] = $cat->name;
        } ?>
        <div class="form-group">
            {{ Form::label('cat_id', 'Category:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('category_id', $cats, Input::old('category_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('description', 'Description:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('colorize', 'Colorize:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::checkbox('colorize', Input::old('colorize')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('colors', 'Colors:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'colors', Input::old('colors'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('thumbFile', 'Thumbnail Image:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::file('thumbFile') }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('imageFile', 'Image:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::file('imageFile') }}
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Create', array('class' => 'btn btn-lg btn-primary')) }}
    </div>
</div>

{{ Form::close() }}

@stop


