@extends('layouts.scaffold')

@section('main')

<h1>Show Font</h1>

<p>{{ link_to_route('fonts.index', 'Return to All fonts', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
				<th>FontFamily</th>
				<th>Ascent</th>
				<th>Vector</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $font->name }}}</td>
					<td>{{{ $font->fontFamily }}}</td>
					<td>{{{ $font->ascent }}}</td>
					<td>{{{ $font->vector }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('fonts.destroy', $font->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('fonts.edit', 'Edit', array($font->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
