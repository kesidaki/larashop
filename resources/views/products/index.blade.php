@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		@include('products._filter-form')

		<!-- Products List -->
		<div class="col-sm-12">
			<div class="row mb-5">
				@if ($products)
					@foreach ($products as $i=>$product)
						@include('templates.product-card', [
							'product'  => $product, 
							'colClass' => 'col-sm-12 col-md-6 col-lg-3 mb-4'
						])
					@endforeach
				@else
					<h2>products not found!</h2>
				@endif
			</div>

			<div class="row">
				{{ $products->appends(request()->except(['page','_token']))->links() }}
			</div>
		</div>
	</div>
</div>

@endsection