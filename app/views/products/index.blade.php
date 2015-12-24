@extends('layouts.scaffold')

@section('main')

<h1>All Products</h1>

<p>{{ link_to_route('products.create', 'Add New Product', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($products->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name/Options</th>
				<th>Category</th>
				<th>Description</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($products as $product)
				<tr>
					<td>
						{{{ $product->name }}}
						@if ($product->multicolor)
							<span class="badge">multicolor</span>
						@endif
						@if ($product->resizable)
							<span class="badge">resizable</span>
						@endif
						@if ($product->showRuler)
							<span class="badge">showRuler</span>
						@endif
						@if ($product->namesNumbersEnabled)
							<span class="badge">namesNumbersEnabled</span>
						@endif
					</td>
					<td>{{{ $product->category->name }}}</td>
					<td class="col-md-7">{{{ $product->description }}}</td>
                    <td>
                        {{ link_to_route('products.edit', 'Edit', array($product->id), array('class' => 'btn btn-info')) }}
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('products.destroy', $product->id))) }}
							{{ Form::submit('Delete', array('class' => 'btn btn-danger', 'onclick' => 'javascript:confirm("Are you sure?");')) }}
						{{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no products
@endif

@stop
