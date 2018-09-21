@extends('layouts.app', ['nouislider' => true])

@section('content')

<div class="container">
	<div class="row">
		<!-- Products List -->
		<div class="col-sm-12">
			<div class="row mb-5">
				@if ($products)
					@foreach ($products as $product)
						@include('templates.product-card', [
								'term' => $product, 
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