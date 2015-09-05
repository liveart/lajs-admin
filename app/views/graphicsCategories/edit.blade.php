@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Graphics Category</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($graphicsCategory, array('class' => 'form-horizontal', 'method' => 'PATCH', 'files' => true, 'route' => array('graphicsCategories.update', $graphicsCategory->id))) }}

        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>
        <?php
            $cats = array(0 => 'None');
            foreach (GraphicsCategory::get(array('id', 'name', 'parent')) as $cat) {
                // simple loop and cycle check
                if (($cat->name != $graphicsCategory->name) && ($cat->parent != $graphicsCategory->id)) {
                    $cats[$cat->id] = $cat->name;
                }
            }
        ?>
        <div class="form-group">
            {{ Form::label('parent', 'Parent category:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('parent', $cats, Input::old('parent'), array('class'=>'form-control')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('thumb', 'Thumbnail Image:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                @if ($graphicsCategory->thumb->originalFilename())
                    {{ HTML::image($graphicsCategory->thumb->url()) }}
                @endif
                {{ Form::file('thumb') }}
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('graphicsCategories.show', 'Cancel', $graphicsCategory->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop