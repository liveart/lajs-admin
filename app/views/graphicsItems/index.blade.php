@extends('layouts.scaffold')

@section('main')

<h1>All Graphics Items</h1>

<p>{{ link_to_route('graphicsItems.create', 'Add New Graphics', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($graphicsItems->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
                <th>Category</th>
				<th>Description</th>
				<th>Colors</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($graphicsItems as $graphicsItem)
				<tr>
					<td>{{{ $graphicsItem->name }}}</td>
                    <td>{{{ $graphicsItem->category->name }}}</td>
					<td>{{{ $graphicsItem->description }}}</td>
					<td>{{{ $graphicsItem->colors }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('graphicsItems.destroy', $graphicsItem->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('graphicsItems.edit', 'Edit', array($graphicsItem->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no graphicsItems
@endif

@stop
