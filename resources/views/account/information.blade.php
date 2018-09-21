@extends('layouts.app')

@section('content')

<div class="container">

	<div class="row">
		<div class="col-sm-12">
			<h2>Στοιχεία Παράδοσης</h2>
		</div>

		<div class="col-sm-12">
			<form>
				{{ csrf_field() }}

				<div class="row">
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-sm-12">
						<label>Όνομα</label>
						<div class="col-sm-12">
							<input type="text" value="{{ ($info) ? $info->name : '' }}" name="name" class="form-control">
						</div>
					</div>

					<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-sm-9">
						<label>Διεύθυνση</label>
						<div class="col-sm-12">
							<input type="text" value="{{ ($info) ? $info->address : '' }}" name="address" class="form-control">
						</div>
					</div>

					<div class="form-group{{ $errors->has('tk') ? ' has-error' : '' }} col-sm-3">
						<label>Τ.Κ.</label>
						<div class="col-sm-12">
							<input type="text" value="{{ ($info) ? $info->tk : '' }}" name="tk" class="form-control">
						</div>
					</div>

					<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }} col-sm-12 col-md-6">
						<label>Νομός</label>
						<div class="col-sm-12">
							<select name="state" class="form-control">
								<option value="" disabled selected>Επιλέξτε Νομό</option>
								@foreach ($states as $state)
								<option {{ (($info) && ($info->state == $state->id)) ? 'selected': '' }} >{{ $state->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }} col-sm-12 col-md-6">
						<label>Περιοχή</label>
						<div class="col-sm-12">
							<input type="text" value="{{ ($info) ? $info->city : '' }}" name="city" class="form-control">
						</div>
					</div>

					<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-sm-12 col-md-6">
						<label>Τηλέφωνο (σταθερό)</label>
						<div class="col-sm-12">
							<input type="text" value="{{ ($info) ? $info->phone : '' }}" name="phone" class="form-control">
						</div>
					</div>

					<div class="form-group{{ $errors->has('phone_2') ? ' has-error' : '' }} col-sm-12 col-md-6">
						<label>Τηλέφωνο (κινητό)</label>
						<div class="col-sm-12">
							<input type="text" value="{{ ($info) ? $info->phone_2 : '' }}" name="phone_2" class="form-control">
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<button type="submit" class="btn btn-large btn-primary">Αποθήκευση</button>
				</div>

			</form>
		</div>
	</div>

</div>


@endsection