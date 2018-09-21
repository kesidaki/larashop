@extends('layouts.app')

@section('content')
<style>
.error {
	font-size: 8rem;
	text-shadow: 2px 2px #666;
}
</style>

<div class="container">
    <div class="row">
    	<div class="col-sm-12">
        	<h1 class="text-center">Σφάλμα</h1>
        </div>
    	<div class="col-sm-12 my-3">
    		<h1 class="text-center green-text error">404</h1>
    	</div>
        <div class="col-sm-12">
        	<h3 class="text-center">Η Σελίδα που ζητήσατε δε βρέθηκε</h3>
        </div>
    </div>
</div>
@endsection