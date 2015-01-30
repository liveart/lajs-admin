@extends('layouts.scaffold')

@section('main')

<h1>Show Product</h1>

<p>{{ link_to_route('products.index', 'Return to All products', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
				<th>Description</th>
				<th>Price</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $product->name }}}</td>
					<td>{{{ $product->description }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('products.destroy', $product->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('products.edit', 'Edit', array($product->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
