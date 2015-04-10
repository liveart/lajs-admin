@extends('layouts.scaffold')

@section('main')

<h1>All Colorizable Elements</h1>

<p>{{ link_to_route('colorizableElements.create', 'Add New ColorizableElement', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($colorizableElements->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Css_id</th>
				<th>Name</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($colorizableElements as $colorizableElement)
				<tr>
					<td>{{{ $colorizableElement->css_id }}}</td>
					<td>{{{ $colorizableElement->name }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('colorizableElements.destroy', $colorizableElement->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('colorizableElements.edit', 'Edit', array($colorizableElement->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no colorizableElements
@endif

@stop
