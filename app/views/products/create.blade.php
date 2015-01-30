@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Create Product</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'products.store', 'class' => 'form-horizontal')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
          {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
        </div>
    </div>
    <?php $categories = array(0 => 'Choose category');
    foreach (Category::get(array('id', 'name')) as $cat) {
        $categories[$cat->id] = $cat->name;
    } ?>
    <div class="form-group">
        {{ Form::label('cat_id', 'Category:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('categoryId', $categories, Input::old('categoryId'), array('class'=>'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('thumbUrl', 'Thumb URL:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
          {{ Form::text('thumbUrl', Input::old('thumbUrl'), array('class'=>'form-control', 'placeholder'=>'Thumbnail URL')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('description', 'Description:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
          {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('options', 'Options:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::label('multicolor', 'Is multicolor', array('class'=>'control-label')) }}
            {{ Form::checkbox('multicolor', Input::old('multicolor')) }}<br/>
            {{ Form::label('resizable', 'Is resizable', array('class'=>'control-label')) }}
            {{ Form::checkbox('resizable', Input::old('resizable')) }}<br/>
            {{ Form::label('showRuler', 'Show ruler', array('class'=>'control-label')) }}
            {{ Form::checkbox('showRuler', Input::old('showRuler')) }}<br/>
            {{ Form::label('namesNumbersEnabled', 'Enable Names/Numbers', array('class'=>'control-label')) }}
            {{ Form::checkbox('namesNumbersEnabled', Input::old('namesNumbersEnabled')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('data', 'Custom Data(json):', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('data', Input::old('data'), array('class'=>'form-control', 'placeholder'=>'{"price": "29", "material": "Cotton"}')) }}
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


