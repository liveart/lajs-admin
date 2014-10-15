@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Product</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($product, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('products.update', $product->id))) }}

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
            {{ Form::label('price', 'Price:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'price', Input::old('price'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('sizes', 'Sizes:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('sizes', Input::old('sizes'), array('class'=>'form-control', 'placeholder'=>'E.g. S,M,L,XL')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('locations', 'Locations:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                <p>{{ link_to_route('locations.create', 'New Location', 
                            array('product_id'=>$product->id), 
                            array('class' => 'btn btn-sm btn-primary')) }}</p>
                @if ($product->locations->count())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Editable Area</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->locations as $loc)
                                <tr>
                                    <td>{{{ $loc->name }}}</td>
                                    <td>{{{ $loc->editableArea }}}</td>
                                    <td>
                                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('locations.destroy', $loc->id))) }}
                                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                        {{ Form::close() }}
                                        {{ link_to_route('locations.edit', 'Edit', array($loc->id), array('class' => 'btn btn-info')) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    No locations defined yet.
                @endif
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('products.show', 'Cancel', $product->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop