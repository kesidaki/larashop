@extends('layouts.app')

@section('content')

<style>
.card-error {
	border: 2px solid red;
	border-radius: 10px;
	text-align: center;
	margin-bottom: 40px;
	padding: 20px;
	font-size: 16px;
}
td.item-name, td.item-price, td.item-action {
	font-size: 18px;
}
td.item-name img {
	height: 80px;
}
.next-btn-content {
	position: relative;
	top: -2px;
}
</style>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Καλάθι Αγορών</h1>
		</div>

		@if (session()->has('error'))
		<div class="col-sm-12">
			<div class="card card-error">
				<div class="card-content">
					{{session('error')}}
				</div>
			</div>
		</div>
		@endif

		<div class="col-sm-12">
			<div class="row">
				@if (count($cart))
				<div class="col-sm-12">
					<table class="table">
						<thead>
							<th>Προϊόν</th>
							<th>Ποσότητα</th>
							<th>Τιμή</th>
							<th></th>
						</thead>
						<tbody>
							@foreach ($cart as $item)
							<tr>
								<td class="align-middle item-name">
									<img src="{{asset('public/thumbnail/'.$item->options->img)}}">
									{{$item->name}}
								</td> 
								</td>
								<td class="align-middle item-qty">
									<div class="btn-group" role="group" aria-label="Basic example">
										<a href="{{url('cart/dec?id='.$item->id)}}" class="btn btn-info"><i class="fas fa-minus"></i></a>
										<a class="btn">{{$item->qty}}</a>
										<a href="{{url('cart/inc?id='.$item->id)}}" class="btn btn-info"><i class="fas fa-plus"></i></a>
									</div>
								</td>
								<td class="align-middle item-price">{{$item->total(2, ',', '.')}}&euro;</td>
								<td class="align-middle item-action">
									<a href="{{url('cart/dlt?id='.$item->id)}}" class="btn btn-danger">
										<i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="col-sm-12 col-md-6">
					<table class="table">
						<tr>
							<th>Σύνολο</th>
							<td>{{$subtotal}} &euro;</td>
						</tr>
						<tr>
							<th>ΦΠΑ</th>
							<td>{{$tax}} &euro;</td>
						</tr>
						<tr>
							<th>Τελικό Ποσό</th>
							<td>{{$total}} &euro;</td>
						</tr>
					</table>
				</div>

				<div class="col-sm-12 col-md-6">
					<a href="{{url('/checkout')}}" class="btn btn-success btn-lg btn-block"><span class="next-btn-content">Συνέχεια στην ολοκλήρωση αγοράς</span> <i class="fas fa-chevron-right"></i></a>
				</div>
				@else
				<p>Το καλάθι σας είναι άδειο!</p>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection