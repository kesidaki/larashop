@extends('layouts.mail')

@section('content')

	<p>Αγαπητέ/ή, {{ $data['name'] }}</p>

	<p>Σας ευχαριστούμε για τη παραγγελία σας. Θα ενημερωθείτε σύντομα για τη οιρεία της από το τμήμα παραγγελιών μας.</p>
	
	<br>
	<table class="table" width="100%">
		<thead>
			<tr>
				<th>Προϊόν</th>
				<th>Τεμ.</th>
				<th>Τιμή</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $item)
			<tr>
				<td><b>{{ $item->name }}</b></td>
				<td>{{ $item->qty }}</td>
				<td>{{ $item->total(2, ',', '.') }} &euro;</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<br>
	<table class="table">
		<tr>
			<td><b>Σύνολο</b></td>
			<td>{{$subtotal}} &euro;</td>
		</tr>
		<tr>
			<td><b>ΦΠΑ</b></td>
			<td>{{$tax}} &euro;</td>
		</tr>
		<tr>
			<td><b>Τελικό Ποσό</b>&nbsp;&nbsp;&nbsp;</td>
			<td>{{$total}} &euro;</td>
		</tr>
	</table>

	<br>
	<p>Για μεταβολές στη παραγγελία σας παρακαλώ επικοινωνήστε μαζί μας στο <b>Τηλέφωνο</b> ή στο email <b>Email</b></p>

@endsection