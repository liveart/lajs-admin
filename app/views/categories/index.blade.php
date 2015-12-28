@extends('layouts.scaffold')

@section('main')

<h1>All Categories</h1>

<p>{{ link_to_route('categories.create', 'Add New Category', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($categories->count())
	<table class="table table-striped">
		<thead>
			<tr>
                <th>Thumbnail</th>
				<th>Name</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($categories as $category)
				<tr>
                    <td>{{ HTML::image(URL::to($category->thumb->url()), null, array('style' => 'width: 100px;')) }}</td>
					<td>{{ $category->name }}</td>
                    <td>
                        {{ link_to_route('categories.edit', 'Edit', array($category->id), array('class' => 'btn btn-info')) }}
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $category->id))) }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no categories
@endif

@stop
