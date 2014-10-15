@extends('layouts.scaffold')

@section('main')

<h1>All Colors</h1>

<p>{{ link_to_route('colors.create', 'Add New Color', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($colors->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Color RGB</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($colors as $color)
				<tr>
					<td>{{{ $color->name }}}</td>
					<td>
						<div style="width:70px;height:30px;border:1px solid black;background-color:{{{ $color->value }}};"></div>
						{{{ $color->value }}}
					</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('colors.destroy', $color->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('colors.edit', 'Edit', array($color->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no colors defined.
@endif

@stop