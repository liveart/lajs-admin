@extends('layouts.scaffold')

@section('main')

<h1>Show Graphics Category</h1>

<p>{{ link_to_route('graphicsCategories.index', 'Return to All graphicsCategories', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $graphicsCategory->name }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('graphicsCategories.destroy', $graphicsCategory->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('graphicsCategories.edit', 'Edit', array($graphicsCategory->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
