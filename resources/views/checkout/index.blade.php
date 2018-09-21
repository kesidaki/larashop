@extends('layouts.app')

@section('content')

<style>
h2 { color: #439f76; padding-bottom: 10px; margin-bottom: 20px; border-bottom: 2px solid #439f76; }
#bank-payment-info { margin-bottom: 40px; display: none; }
#profession-container, #doy-container, #afm-container { display: none; }
</style>

<div class="container">
	<form method="post" action="{{url('checkout')}}" class="form-horizontal" >
		{{ csrf_field() }}

		<div class="row">
			<!--
			LEFT COLUMN - CUSTOMER INFO
			-->
			<div class="col-sm-12 col-md-7">
				<div class="row">
					<div class="col-sm-12">
						<h2>Στοιχεία Παραλήπτη</h2>
					</div>

					<!--type-->
		            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} col-sm-12 col-md-6">
		                <label for="type" class="col-sm-12 control-label">Έκδοση Παραστατικού</label>
		                <div class="col-sm-12">
		                    <select name="type" id="orderPayment" class="form-control" required>
		                    	<option selected>Απόδειξη</option>
		                    	<option {{ (old('type')=='Τιμολόγιο')?'selected':'' }}>Τιμολόγιο</option>
		                    </select>
		                </div>
		            </div>

					<!--name-->
		            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-sm-12">
		                <label for="name" class="col-sm-12 control-label">Όνομα και Επώνυμο*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>

		                    @if ($errors->has('name'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--profession-->
		            <div class="form-group{{ $errors->has('profession') ? ' has-error' : '' }} col-sm-12" id="profession-container">
		                <label for="profession" class="col-sm-12 control-label">Επάγγελμα*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="profession" name="profession" value="{{ old('profession') }}" class="form-control">

		                    @if ($errors->has('profession'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('profession') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--doy-->
		            <div class="form-group{{ $errors->has('doy') ? ' has-error' : '' }} col-sm-12 col-md-6" id="doy-container">
		                <label for="doy" class="col-sm-12 control-label">ΔΟΥ*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="doy" name="doy" value="{{ old('doy') }}" class="form-control">

		                    @if ($errors->has('doy'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('doy') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--afm-->
		            <div class="form-group{{ $errors->has('afm') ? ' has-error' : '' }} col-sm-12 col-md-6" id="afm-container">
		                <label for="afm" class="col-sm-12 control-label">ΑΦΜ*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="afm" name="afm" value="{{ old('afm') }}" class="form-control">

		                    @if ($errors->has('afm'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('afm') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--address-->
		            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-sm-9">
		                <label for="address" class="col-sm-12 control-label">Διεύιυνση*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control" required>

		                    @if ($errors->has('address'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('address') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--tk-->
		            <div class="form-group{{ $errors->has('tk') ? ' has-error' : '' }} col-sm-3">
		                <label for="tk" class="col-sm-12 control-label">ΤΚ*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="tk" name="tk" value="{{ old('tk') }}" class="form-control" required>

		                    @if ($errors->has('tk'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('tk') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--city-->
		            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }} col-sm-12 col-md-6">
		                <label for="city" class="col-sm-12 control-label">Περιοχή*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control" required>

		                    @if ($errors->has('city'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('city') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--state-->
		            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }} col-sm-12 col-md-6">
		                <label for="state" class="col-sm-12 control-label">Νομός*</label>
		                <div class="col-sm-12">
		                    <select name="state" id="state" class="form-control" required>
		                    	<option selected disabled>Επιλέξτε Νομό</option>
		                    @foreach ($states as $state)
		                    	<option {{ (old('state')==$state->name)?'selected':'' }}>{{$state->name}}</option>
		                    @endforeach
		                    </select>

		                    @if ($errors->has('state'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('state') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--phone-->
		            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-sm-12 col-md-6">
		                <label for="phone" class="col-sm-12 control-label">Τηλέφωνο (σταθερό)*</label>
		                <div class="col-sm-12">
		                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" required>

		                    @if ($errors->has('phone'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('phone') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--phone_2-->
		            <div class="form-group{{ $errors->has('phone_2') ? ' has-error' : '' }} col-sm-12 col-md-6">
		                <label for="phone_2" class="col-sm-12 control-label">Τηλέφωνο (κινητό)</label>
		                <div class="col-sm-12">
		                    <input type="text" id="phone_2" name="phone_2" value="{{ old('phone_2') }}" class="form-control">

		                    @if ($errors->has('phone_2'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('phone_2') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>

		            <!--email-->
		            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-sm-12">
		                <label for="email" class="col-sm-12 control-label">E-mail*</label>
		                <div class="col-sm-12">
		                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" required>

		                    @if ($errors->has('email'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('email') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>
		        </div>
		    </div>

		    <!--
			LEFT COLUMN - ORDER INFO
			-->
		    <div class="col-sm-12 col-md-5">
		    	<div class="row">
		    		<div class="col-sm-12">
		    			<h2>Στοιχεία Αποστολής</h2>
		    		</div>
		    		<div class="col-sm-12">
						<!--shipping_id-->
			            <div class="form-group{{ $errors->has('shipping_id') ? ' has-error' : '' }} col-sm-12">
			                <label for="shipping_id" class="col-sm-12 control-label">Αποστολή</label>
			                <div class="col-sm-12">
			                    <select class="form-control" name="shipping_id" id="checkoutShipping" required>
			                    	<option value="" selected disabled>Επιλέξτε Τρόπο Αποστολής</option>
			                    	@foreach ($shipping as $key=>$sh)
			                    	<option value="{{$sh->id}}" data-cost="{{$sh->cost}}" {{ (old('shipping_id')==$sh->id)?'selected':'' }}>{{$sh->description}} ({{$sh->cost}} &euro;)</option>
			                    	@endforeach
			                    </select> 

			                    @if ($errors->has('shipping_id'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('shipping_id') }}</strong>
			                        </span>
			                    @endif
			                </div>
			            </div>

			            <!--payment-->
			            <div class="form-group{{ $errors->has('payment') ? ' has-error' : '' }} col-sm-12">
			                <label for="payment" class="col-sm-12 control-label">Πληρωμή</label>
			                <div class="col-sm-12">
			                    <select class="form-control" name="payment" id="checkoutPayment" required>
			                    	<option value="" selected disabled>Επιλέξτε Τρόπο Πληρωμής</option>
			                    	<option {{ (old('shipping_id')=='Αντικαταβολή')?'selected':'' }}>Αντικαταβολή</option>
			                    	<option {{ (old('shipping_id')=='Κάρτα')?'selected':'' }} value="Κάρτα">Πιστωτική ή Χρεωστική Κάρτα</option>
			                    </select> 

			                    @if ($errors->has('payment'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('payment') }}</strong>
			                        </span>
			                    @endif
			                </div>
			            </div>

			            <!--costs repeated-->
			            <div class="col-sm-12 mb-2">
			            	<table class="table">
								<tr>
									<th>Σύνολο</th>
									<td><span id="table-summary-cost">{{$total}}</span> &euro;</td>
								</tr>
								<tr>
									<th>Αποστολή</th>
									<td><span id="table-summary-shipping">0</span> &euro;</td>
								</tr>
								<tr>
									<th>Τελικό Ποσό</th>
									<td><span id="table-summary-total">{{$total}}</span> &euro;</td>
								</tr>
							</table>
							<caption>* Υποχρεωτικά Πεδία</caption>
			            </div>

			            <div class="col-sm-12">
			            	<button type="submit" class="btn btn-primary btn-lg btn-block">Παραγγελία</button>
			            </div>
		    		</div>
		    	</div>
		    </div>
		</div>
	</form>
</div>

@endsection