@extends('layouts.scaffold')

@section('main')

<h1>Show Colorizable Element</h1>

<p>{{ link_to_route('colorizableElements.index', 'Return to All colorizableElements', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Css_id</th>
				<th>Name</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
