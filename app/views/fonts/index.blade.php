@extends('layouts.scaffold')

@section('main')

<h1>All Fonts</h1>

<p>{{ link_to_route('fonts.create', 'Add New Font', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($fonts->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>FontFamily</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($fonts as $font)
				<tr>
					<td>
						{{{ $font->name }}}
						@if ($font->boldAllowed)
							<span class="badge">bold</span>
						@endif
						@if ($font->italicAllowed)
							<span class="badge">italic</span>
						@endif
					</td>
					<td>{{{ $font->fontFamily }}}</td>
                    <td>
						{{ link_to_route('fonts.edit', 'Edit', array($font->id), array('class' => 'btn btn-info')) }}
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('fonts.destroy', $font->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no fonts
@endif

@stop
