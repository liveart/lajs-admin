@extends('layouts.scaffold')

@section('main')

<h1>All Products</h1>

<p>{{ link_to_route('products.create', 'Add New Product', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($products->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($products as $product)
				<tr>
					<td>{{{ $product->name }}}</td>
					<td>{{{ $product->description }}}</td>
					<td>{{{ $product->price }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('products.destroy', $product->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('products.edit', 'Edit', array($product->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no products
@endif

@stop
