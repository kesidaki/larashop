@extends('layouts.app')

@section('content')

<style>
.card-added {
	border: 3px solid #439f76;
	border-radius: 10px;
	text-align: center;
	margin-bottom: 40px;
	padding: 15px;
}
.product-header h1 {
	display: block;
	padding-bottom: 10px;
	border-bottom: 2px solid #439f76;
}
ul.cats {
	list-style-type: none;
}
ul.cats li {
	display: inline-block;
	font-size: 20px;
	color: #666;
}
ul.cats li:after {
	content: ' | ';
}
ul.cats li:last-child:after {
	content: '';
}
.product-body {
	margin-top: 40px;
}
h3.price-tag {
	font-size: 35px;
	margin-bottom: 20px;
}
p.availability {
	font-weight: bold;
	margin-top: 20px;
}
.product-info h3 {
	border-bottom: 1px solid #666;
	padding-bottom: 10px;
}
.product-info-text p,
.product-info-text li,
.product-info-text td {
	font-size: 20px;
}
span.crossed-out-price {
	font-size: 22px;
}
span.grey-text { color: #666; }
span.bold { font-size: 28px; position: relative; top: -8px; }
.modal-right-side { background-color: #f5f5f5; }
.no-padding { padding: 0 !important; }
.no-padding .my-col { padding: 1rem !important; }
</style>

<div class="container">
	@if (Auth::check() && Auth::user()->isAdmin())
		<div class="row mb-5">
			<div class="col-sm-12">
				<a href="{{ url('admin/product/'.$product->id) }}" class="btn btn-lg btn-block btn-outline-dark">Admin Panel</a>
			</div>
		</div>
	@endif
	

	<div class="row mb-5">
		<div class="col-sm-12 col-md-5 col-lg-4 h-100">
			<div class="card">
				<img class="card-img-top" src="{{asset('public/products/'.$product->image)}}" alt="{{$product->name}}">
			</div>
		</div>

		<div class="col-sm-12 col-md-7 col-lg-8 h-100">
			<div class="product-header">
				<h1>{{$product->name}}</h1>
				<ul class="cats">
					@foreach ($product->categories as $category) <li>{{$category->name}}</li> @endforeach
				</ul>
			</div>
			<div class="product-body">
				<h3 class="price-tag green-text">
					Τιμή {{ (count($product->prices) == 1) ? '' : ' από' }}<br>
					@if ($product->discount)
						<span class="crossed-out-price">{{ $product->product_price_wt }} &euro;</span>
						{{ round($product->discounted, 2) }} &euro;
					@else
						{{ $product->product_price_wt }} &euro;
					@endif
				</h3>

				<!-- Product Price & Buy Button -->
				@if (count($product->prices) == 1)
					<form method="POST" action="{{url('cart')}}">
						{{ csrf_field() }}
	                    <input type="hidden" name="product_id" value="{{$product->id}}">
	                    <input type="hidden" name="product_price" value="{{$product->product_price}}">
	                    <button type="submit" class="btn btn-lg btn-success">
	                        <i class="fa fa-shopping-cart"></i> Αγορά
	                    </button>
	                </form>
	            @else
					<button 
					type="button" 
					class="btn btn-lg btn-success" 
					data-toggle="modal" 
					data-target="#multiplePricesModal">
						Αγορά
					</button>
				@endif

                <p class="availability green-text">
                	<i class="fas fa-shipping-fast"></i> {{($product->quantity > 0) ? 'Άμεσα Διαθέσιμο':'Διαθέσιμο κατόπιν παραγγελίας'}}
                </p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 product-info">
			<h3>Περιγραφή</h3>
			<div class="product-info-text">{!!$product->description!!}</div>
		</div>
	</div>
		
</div>

<!-- Multiple Prices Modal -->
@if (count($product->prices) > 1)
<div class="modal fade" 
id="multiplePricesModal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="multiplePricesModal"
 aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="multiplePricesModal">Αγορά {{ $product->name }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body no-padding">
				<!-- form start -->
				<form method="post" action="{{url('cart')}}">
					{{ csrf_field() }}
	                <input type="hidden" name="product_id" value="{{$product->id}}">

					<!-- modal content -->
					<div class="container-fluid">
						<div class="row">
							<!-- left column (prices) -->
							<div class="my-col col-sm-12 col-md-6">
								@foreach ($product->prices as $i => $price)
								<div class="form-check">
									<div class="custom-control form-control-lg custom-checkbox">
										<input type="radio" class="custom-control-input filter-price" name="product_price" id="pickPrice{{ $i }}" value="{{ $price->price }}" {{ ($i == 0) ? 'checked' : '' }}>
										<label class="custom-control-label" for="pickPrice{{ $i }}">
											<span class="green-text bold">{{ $price->with_tax }}&euro;</span> <br/>
											<span class="grey-text">{{ $price->description }}</span>
										</label>
									</div>
								</div>
								@endforeach
							</div>
							<!-- right column (info + button) -->
							<div class="my-col col-sm-12 col-md-6 modal-right-side">
								<button type="submit" class="btn btn-lg btn-block btn-success">
			                        <i class="fa fa-shopping-cart"></i> Αγορά
			                    </button>
							</div>
						</div>
					</div>
					<!-- end of modal content -->
				</form>
				<!-- form end -->
			</div>
		</div>
	</div>
</div>
@endif

@endsection