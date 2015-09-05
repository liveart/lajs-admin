@extends('layouts.scaffold')

@section('main')

<h1>All Graphics Categories</h1>

<p>{{ link_to_route('graphicsCategories.create', 'Add New Category', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($graphicsCategories->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Thumb</th>
				<th>Name</th>
				<th>Parent Category</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($graphicsCategories as $graphicsCategory)
				<tr>
					<td>{{ HTML::image($graphicsCategory->thumb->url()) }}</td>
                    <td>{{{ $graphicsCategory->name }}}</td>
                    <td>
                        @if (is_a($graphicsCategory->parentCategory, 'GraphicsCategory'))
                            {{{ $graphicsCategory->parentCategory->name }}}
                        @else
                            None
                        @endif
                    </td>
                    <td>
                        {{ link_to_route('graphicsCategories.edit', 'Edit', array($graphicsCategory->id), array('class' => 'btn btn-info')) }}
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('graphicsCategories.destroy', $graphicsCategory->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no artwork categories
@endif

@stop
