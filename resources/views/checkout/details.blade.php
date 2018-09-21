@extends('layouts.app')

@section('content')

<style>
h2 { color: #439f76; padding-bottom: 10px; margin-bottom: 20px; border-bottom: 2px solid #439f76; }
#bank-payment-info { margin-bottom: 40px; display: none; }
#doy-container, #afm-container { display: none; }
table.not-full-width { width: auto; }
</style>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2>Η Παραγγελία σας ολοκληρώθηκε!</h2>
		</div>

		<div class="col-sm-12">
			<p>Θα επικοινωνήσουμε σύντομα μαζί σας για συνεννόηση για την αποστολή της</p>
		</div>

		<div class="col-sm-12">
			<h2>Στοιχεία Παραλαβής</h2>
			<table class="table">
				<tr>
					<th>Όνομα</th>
					<td>{{ $order->name }}</td>
				</tr>
				@if ($order->doy != '')
				<tr>
					<th>ΔΟΥ</th>
					<td>{{ $order->doy }}</td>
				</tr>
				@endif
				@if ($order->afm != '')
				<tr>
					<th>ΑΦΜ</th>
					<td>{{ $order->afm }}</td>
				</tr>
				@endif
				<tr>
					<th>Διεύθυνση</th>
					<td>{{ $order->address }}, {{ $order->tk }}</td>
				</tr>
				<tr>
					<th>Περιοχή</th>
					<td>{{ $order->city }}, {{ $order->state }}</td>
				</tr>
				<tr>
					<th>Τηλέφωνο</th>
					<td>{{ $order->phone }} {{ $order->phone2 }}</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>{{ $order->email }}</td>
				</tr>
			</table>
		</div>

		<div class="col-sm-12">
			<h2>Προϊόντα</h2>

			<table class="table">
				<thead>
					<tr>
						<th>Προϊόν</th>
						<th>#</th>
						<th>Τιμή</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($info as $item)
					<tr>
						<td>{{ $item->product->name }}</td>
						<td>{{ $item->quantity }}</td>
						<td>{{ $item->total }} &euro;</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<table class="table not-full-width">
				<tr>
					<th>Κόστος</th>
					<td>{{ $order->subtotal }} &euro;</td>
				</tr>
				<tr>
					<th>ΦΠΑ</th>
					<td>{{ $order->tax }} &euro;</td>
				</tr>
				<tr>
					<th>Μεταφορικά</th>
					<td>{{ $order->shipping }} &euro;</td>
				</tr>
				<tr>
					<th>Σύνολο</th>
					<td>{{ $order->total }} &euro;</td>
				</tr>
			</table>
		</div>
	</div>
</div>

@endsection