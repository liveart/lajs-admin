@extends('layouts.scaffold')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Gallery Item</h1>
        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($graphicsItem, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('graphicsItems.update', $graphicsItem->id))) }}

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
            {{ Form::label('colors', 'Expected # of colors:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'colors', Input::old('colors'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('thumb', 'Thumb:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('thumb', Input::old('thumb'), array('class'=>'form-control', 'placeholder'=>'Thumb')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('image', 'Image:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('image', Input::old('image'), array('class'=>'form-control', 'placeholder'=>'Image')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('colorizableElements', 'Colorizable Elements:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                <p>{{ link_to_route('colorizableElements.create', 'New Colorizable Element', 
                            array('id'=>$graphicsItem->id, 'type'=>'GraphicsItem'), 
                            array('class' => 'btn btn-sm btn-primary')) }}</p>
                @if ($graphicsItem->colorizableElements->count())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>CSS ID</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($graphicsItem->colorizableElements as $el)
                                <tr>
                                    <td>{{{ $el->name }}}</td>
                                    <td>{{{ $el->css_id }}}</td>
                                    <td>
                                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('colorizableElements.destroy', $el->id))) }}
                                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                        {{ Form::close() }}
                                        {{ link_to_route('colorizableElements.edit', 'Edit', array($el->id), array('class' => 'btn btn-info')) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    No colorizable elements defined yet.
                @endif
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('graphicsItems.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop