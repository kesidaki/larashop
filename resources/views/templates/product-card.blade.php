<div class="{{ $colClass }}">
	<div class="card product-card h-100 lift">
	<!--<div class="card product-card h-100 lift">-->

		@if ($product->discount)
		<div class="card-discount">
			<p>{{ $product->discount }}%</p>
		</div>
		@endif

		<!--<div class="card-image">-->
		<div class="card-image">
			<a href="{{url('product/'.$product->slug)}}">
				<img class="card-img-top" src="{{asset('thumbnail/'.$product->image)}}" alt="{{ $product->name }}">
			</a>
		</div>
		<div class="card-body">
			<a href="{{url('product/'.$product->slug)}}">
				<h5 class="card-title text-center">{{$product->name}}</h5>
			</a>
		</div>
		<div class="card-footer">
			@if ($product->quantity > 0)
			<p class="availability green-text text-center">
            	<i class="fas fa-shipping-fast"></i> Άμεσα Διαθέσιμο
            </p>
            @else 
            <p class="availability grey-text text-center">
            	Διαθέσιμο κατόπιν παραγγελίας
            </p>
            @endif

			<p class="text-center product-price font-weight-bold align-bottom">
				@if ($product->discount)
					<span class="crossed-out-price">{{ $product->product_price_wt }} &euro;</span>
					{{ round($product->discounted, 2) }} &euro;
				@else
					{{ $product->product_price_wt }} &euro;
				@endif
			</p>

			@if (count($product->prices) == 1)
				<form method="POST" action="{{url('cart')}}">
					{{ csrf_field() }}
	                <input type="hidden" name="product_id" value="{{$product->id}}">
	                <input type="hidden" name="product_price" value="{{$product->product_price}}">
	                <button type="submit" class="btn btn-block btn-success">
	                    <i class="fa fa-shopping-cart"></i> Αγορά
	                </button>
	            </form>
	        @else
	        	<a href="{{url('product/'.$product->slug)}}" class="btn btn-block btn-success">Πληροφορίες</a>
	        @endif
		</div>
	</div>
</div>