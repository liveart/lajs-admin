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

{{ Form::model($location, array('class' => 'form-horizontal', 'method' => 'PATCH', 'files' => true, 'route' => array('locations.update', $location->id))) }}
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
                {{ Form::number('left', $left, array('id'=>'left', 'class'=>'form-control', 'placeholder'=>'Left')) }}
                {{ Form::number('top', $top, array('id'=>'top', 'class'=>'form-control', 'placeholder'=>'Top')) }}
                {{ Form::number('right', $right, array('id'=>'right', 'class'=>'form-control', 'placeholder'=>'Right')) }}
                {{ Form::number('bottom', $bottom, array('id'=>'bottom', 'class'=>'form-control', 'placeholder'=>'Bottom')) }}
                <button class="btn" data-toggle="modal" data-target="#area-modal" type="button">Select Editable Area</button>
                <div class="modal fade" id="area-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="bootstrap-modal-label">Select Editable Area</h4>
                            </div>
                            <div class="modal-body">
                                <div id="area-editor">
                                    <img src="{{ $location->image }}" alt="Location Image">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var $image = $('#area-editor > img'),
                        cropBoxData = {
                            left: parseInt($("#left").val()),
                            top: parseInt($("#top").val()),
                            width: parseInt($("#right").val()),
                            height: parseInt($("#bottom").val())
                        };
                    // adjust the coords for cropbox properly
                    cropBoxData.width -= cropBoxData.left;
                    cropBoxData.height -= cropBoxData.top;

                    $('#area-modal').on('shown.bs.modal', function () {
                        $image.cropper({
                            zoomable: false,
                            built: function() {
                                $image.cropper('setCropBoxData', cropBoxData);
                            },
                            crop: function(data) {
                                $("#left").val(Math.round(data.x));
                                $("#top").val(Math.round(data.y));
                                $("#bottom").val(Math.round(data.height + data.y));
                                $("#right").val(Math.round(data.width + data.x));
                            }
                        });
                    }).on('hidden.bs.modal', function () {
                        $image.cropper('destroy');
                    });
                </script>
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