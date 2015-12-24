@extends('layouts.scaffold', array('page_title'=>'Editing product'))
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

{{ Form::model($product, array('class' => 'form-horizontal', 'method' => 'PATCH', 'files' => true, 'route' => array('products.update', $product->id))) }}

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="tabs">
  <li class="active"><a href="#main" role="tab" data-toggle="tab">Main</a></li>
  <li><a href="#locations" role="tab" data-toggle="tab">Locations</a></li>
  <li><a href="#colors" role="tab" data-toggle="tab">Colors</a></li>
  <li><a href="#colorizable" role="tab" data-toggle="tab">Colorizable Elements</a></li>
  <li class="hidden"><a href="#pcl" role="tab" data-toggle="tab">Product Color Images</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active panel-body" id="main">
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
              {{ Form::file('thumbFile') }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('description', 'Description:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description')) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('minDPU', 'Minimal Image DPI Requirement:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::number('minDPU', Input::old('minDPU'), array('min'=>0, 'class'=>'form-control', 'placeholder'=>'150')) }}
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
            {{ Form::label('sizes', 'Sizes:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('sizes', Input::old('sizes'), array('class'=>'form-control', 'placeholder'=>'E.g. S,M,L,XL')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
              {{ link_to_route('products.show', 'Cancel', $product->id, array('class' => 'btn btn-lg btn-default')) }}
            </div>
        </div>
  </div>
  <div class="tab-pane panel-body" id="locations">
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
                                <td>{{ $loc->name }}</td>
                                <td>{{ $loc->editableArea }}</td>
                                <td>
                                    {{ link_to_route('locations.edit', 'Edit', array($loc->id), array('class' => 'btn btn-info')) }}
                                    {{ link_to_route('locations.delete', 'Delete', array($loc->id), array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
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
  </div>
  <div class="tab-pane panel-body" id="colors">
    <div class="form-group">
            {{ Form::label('colors', 'Colors:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                <p>{{ link_to_route('colors.create', 'New Product Color', 
                            array('id'=>$product->id, 'type'=>'Product'), 
                            array('class' => 'btn btn-sm btn-primary')) }}</p>
                @if ($product->colors->count())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Color RGB</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->colors as $color)
                                <tr>
                                    <td>{{ $color->name }}</td>
                                    <td>
                                        <div style="width:70px;height:30px;border:1px solid black;background-color:{{ $color->value }};"></div>
                                        {{ $color->value }}
                                    </td>
                                    <td>
                                        {{ link_to_route('colors.edit', 'Edit', array($color->id), array('class' => 'btn btn-info')) }}
                                        {{ link_to_route('colors.delete', 'Delete', array($color->id), array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    No colors defined yet.
                @endif
            </div>
        </div>
  </div>
  <div class="tab-pane panel-body" id="colorizable">
            <div class="form-group">
            {{ Form::label('colorizableElements', 'Colorizable Elements:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                <p>{{ link_to_route('colorizableElements.create', 'New Colorizable Element', 
                            array('id'=>$product->id, 'type'=>'Product'), 
                            array('class' => 'btn btn-sm btn-primary')) }}</p>
                @if ($product->colorizables->count())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>CSS ID</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->colorizables as $el)
                                <tr>
                                    <td>{{ $el->name }}</td>
                                    <td>{{ $el->css_id }}</td>
                                    <td>
                                        {{ link_to_route('colorizableElements.edit', 'Edit', array($el->id), array('class' => 'btn btn-info')) }}
                                        {{ link_to_route('colorizableElements.delete', 'Delete', array($el->id), array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
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
  </div>
  <!-- TODO refactor to jquery and api call to add pcli, then enable this panel back -->
  <div class="tab-pane panel-body hidden" id="pcl">
      <!-- At least one location and one color should be defined to start with PCLI -->
      @if (($product->colors->count())&&($product->locations->count()))
          <table class="table table-striped">
              <thead>
                <tr>
                    <th>Location</th>
                    <th>Color</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($product->pclis->count())
                @foreach($product->pclis as $pcli)
                    <tr>
                        <td>{{ ($pcli->location != null) ? $pcli->location->name : 'Missing!'}}</td>
                        <td>{{ ($pcli->color != null) ? $pcli->color->name : 'Missing!'}}</td>
                        <td>{{$pcli->image}}</td>
                        <td>
                            {{ link_to_route('pclis.delete', 'Delete', array($pcli->id), array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
                        </td>
                    </tr>
                @endforeach
                @endif
                    <?php $locs = array(); foreach ($product->locations as $loc) { $locs[$loc->id] = $loc->name; } ?>
                    <?php $cls = array(); foreach ($product->colors as $cl) { $cls[$cl->id] = $cl->name; } ?>
                    {{ Form::open(array('route' => 'pclis.store', 'style' => 'display: inline-block;')) }}
                    {{ Form::hidden('product_id',$product->id) }}
                    <tr>
                        <td>{{ Form::select('location_id', $locs, null, array('class'=>'form-control')) }}</td>
                        <td>{{ Form::select('color_id', $cls, null, array('class'=>'form-control')) }}</td>
                        <td>{{ Form::text('image', Input::old('image'), array('class'=>'form-control', 'placeholder'=>'Location URL or Path')) }}</td>
                        <td>{{ Form::submit('Add', array('class' => 'btn btn-sm')) }}</td>
                    </tr>
                    {{ Form::close() }}
              </tbody>
          </table>
      @else
          Add at least one color and location before working with images.
      @endif
  </div>
</div>
<script>
    $('#tabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
</script>

{{ Form::close() }}

@stop