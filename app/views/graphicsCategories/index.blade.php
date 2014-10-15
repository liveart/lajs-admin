@extends('layouts.scaffold')

@section('main')

<h1>All Graphics Categories</h1>

<p>{{ link_to_route('graphicsCategories.create', 'Add New Category', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($graphicsCategories->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($graphicsCategories as $graphicsCategory)
				<tr>
					<td>{{{ $graphicsCategory->name }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('graphicsCategories.destroy', $graphicsCategory->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('graphicsCategories.edit', 'Edit', array($graphicsCategory->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no graphicsCategories
@endif

@stop
