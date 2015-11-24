@extends('layouts.scaffold')

@section('main')

<h1>Show GraphicsItem</h1>

<p>{{ link_to_route('graphicsItems.index', 'Return to All graphicsItems', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
				<th>Description</th>
				<th>Colors</th>
				<th>Thumb</th>
				<th>Image</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $graphicsItem->name }}}</td>
					<td>{{{ $graphicsItem->description }}}</td>
					<td>{{{ $graphicsItem->colors }}}</td>
					<td>{{{ $graphicsItem->thumb }}}</td>
					<td>{{{ $graphicsItem->image }}}</td>
                    <td>
                        {{ link_to_route('graphicsItems.edit', 'Edit', array($graphicsItem->id), array('class' => 'btn btn-info')) }}
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('graphicsItems.destroy', $graphicsItem->id))) }}
							{{ Form::submit('Delete', array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
						{{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
