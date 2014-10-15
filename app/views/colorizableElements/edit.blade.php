@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit ColorizableElement</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($colorizableElement, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('colorizableElements.update', $colorizableElement->id))) }}

        <div class="form-group">
            <div class="col-md-2">Attached to:</div>
            <div class="col-sm-10">
                <!-- TODO Output product or graphic item here -->
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('css_id', 'Css_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('css_id', Input::old('css_id'), array('class'=>'form-control', 'placeholder'=>'Css_id')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('colors', 'Pick Colors:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                <table class="table table-striped">
                    {{ Form::select(
                        'color_ids[]',
                        App::make('Color')->lists('name', 'id'),
                        $colorizableElement->colors()->select('colors.id AS id')->lists('id'),
                        [
                            'class' => 'form-control',
                            'multiple'
                        ]
                    ) }}
                </table>
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('colorizableElements.show', 'Cancel', $colorizableElement->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop