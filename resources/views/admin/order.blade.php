@extends('layouts.app')

@section('content')

<style type="text/css">
@media (min-width: 576px) {
    .jumbotron {
        padding: 2rem 2rem;
    }
}
.td-img img {
    max-width: 50px;
}
.fa-trash { color: red; position: relative; top: 6px; cursor: pointer; }
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/home')}}">Διαχείριση</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/orders')}}">Παραγγελίες</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                #{{$order->id}}
            </li>
        </ol>
    </nav>
</div>

<div class="container">

    <div class="row mb-3">
        <div class="col-sm-12">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#parastatikaModal">
                Παραστατικά
            </button>
        </div>
    </div>

    <form method="post" action="{{ url('admin/order/update') }}">
        {{ csrf_field() }}

        <input type="hidden" name="order" value="{{ $order->id }}">
        
        <div class="accordion mb-4" id="accordion">
            <!--Order Info-->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button 
                        class="btn btn-link btn-block text-left" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#collapseOne" 
                        aria-expanded="true" 
                        aria-controls="collapseOne">
                            Στοιχεία Παραλαβής
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">

                            <!--type-->
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} col-sm-12 col-md-6">
                                <label for="type" class="col-sm-12 control-label">Έκδοση Παραστατικού</label>
                                <div class="col-sm-12">
                                    <select name="type" id="orderPayment" class="form-control" required>
                                        <option {{ ($order->type=='Απόδειξη')?'selected':'' }}>Απόδειξη</option>
                                        <option {{ ($order->type=='Τιμολόγιο')?'selected':'' }}>Τιμολόγιο</option>
                                    </select>
                                </div>
                            </div>

                            <!--name-->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-sm-12">
                                <label for="name" class="col-sm-12 control-label">Όνομα και Επώνυμο*</label>
                                <div class="col-sm-12">
                                    <input type="text" id="name" name="name" value="{{ $order->name }}" class="form-control" required>

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
                                    <input type="text" id="profession" name="profession" value="{{ $order->profession }}" class="form-control">

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
                                    <input type="text" id="doy" name="doy" value="{{ $order->doy }}" class="form-control">

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
                                    <input type="text" id="afm" name="afm" value="{{ $order->afm }}" class="form-control">

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
                                    <input type="text" id="address" name="address" value="{{ $order->address }}" class="form-control" required>

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
                                    <input type="text" id="tk" name="tk" value="{{ $order->tk }}" class="form-control" required>

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
                                    <input type="text" id="city" name="city" value="{{ $order->city }}" class="form-control" required>

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
                                        <option {{ ($order->state==$state->name)?'selected':'' }}>{{$state->name}}</option>
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
                                    <input type="text" id="phone" name="phone" value="{{ $order->phone }}" class="form-control" required>

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
                                    <input type="text" id="phone_2" name="phone_2" value="{{ $order->phone_2 }}" class="form-control">

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
                                    <input type="text" name="email" value="{{ $order->email }}" class="form-control" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--shipping_id-->
                            <div class="form-group{{ $errors->has('shipping_id') ? ' has-error' : '' }} col-sm-12">
                                <label for="shipping_id" class="col-sm-12 control-label">Αποστολή</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="shipping_id" id="checkoutShipping" required>
                                        <option value="" selected disabled>Επιλέξτε Τρόπο Αποστολής</option>
                                        @foreach ($shipping as $key=>$sh)
                                        <option value="{{$sh->id}}" {{ ($order->shipping_id==$sh->id)?'selected':'' }}>{{$sh->description}} ({{$sh->cost}} &euro;)</option>
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
                                        <option {{ ($order->payment=='Αντικαταβολή')?'selected':'' }}>Αντικαταβολή</option>
                                        <option {{ ($order->payment=='Κάρτα')?'selected':'' }} value="Κάρτα">Πιστωτική ή Χρεωστική Κάρτα</option>
                                    </select> 

                                    @if ($errors->has('payment'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('payment') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--End of Order Info-->

            <!--Order Products-->
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button 
                        class="btn btn-link btn-block text-left" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#collapseTwo" 
                        aria-expanded="true" 
                        aria-controls="collapseOne">
                            Προϊόντα
                        </button>
                    </h5>
                </div>

                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">

                        @if (count($receipts) == 0)
                        <button class="btn btn-dark" id="newOrderProductButton" type="button" data-toggle="modal" data-target="#addProductModal">Νέο Προϊόν</button>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Εικόνα</th>
                                    <th>Προϊόν</th>
                                    <th>#</th>
                                    <th>Τιμή (&euro;)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="listOfOrderProducts">
                                @foreach ($info as $item)
                                <tr>
                                    <td class="td-img"><img src="{{ asset('thumbnail/'.$item->product->thumb) }}"></td>
                                    <td>
                                        <input type="hidden" name="pId[]" value="{{ $item->product_id }}">
                                        <input 
                                        type="text" 
                                        name="pName[]" 
                                        class="form-control" 
                                        value="{{ $item->product->name }}" 
                                        readonly>
                                    </td>
                                    <td>
                                        <input 
                                        type="number" 
                                        name="pQty[]"
                                        class="form-control"
                                        value="{{ $item->quantity }}"
                                        min="1">
                                    </td>
                                    <td>
                                        <input 
                                        type="number" 
                                        step="0.01" 
                                        name="pPrice[]"
                                        class="form-control"
                                        value="{{ $item->total }}"
                                        readonly>
                                    </td>
                                    <td>
                                        <a class="discardItemFromAdminCart"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--End of Order Products-->

            <!--Money-->
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button 
                        class="btn btn-link btn-block text-left" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#collapseThree" 
                        aria-expanded="true" 
                        aria-controls="collapseOne">
                            Σύνολα
                        </button>
                    </h5>
                </div>

                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">

                        <table class="table">
                            <tr>
                                <th>Υποσύνολο</th>
                                <td>{{ $order->subtotal }} &euro;</td>
                            </tr>
                            <tr>
                                <th>Φόρος</th>
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
            <!--End of Money-->

        </div>
            
        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-block">Αποθήκευση</button>
            </div>
        </div>

    </form>

</div>

<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Προσθήκη Προϊόντος</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Αναζήτηση με Κωδικό, Όνομα ή Κατηγορία.." id="searchProductToAdd">
                            <div class="input-group-append">
                                <button id="searchProductToAddButton" class="btn btn-outline-dark btn-block">Αναζήτηση</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="width: 100%; padding: 0 20px; margin: 0;">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Όνομα</th>
                                    <th>Τιμή</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="searchProductToAddResults"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="parastatikaModal" tabindex="-1" role="dialog" aria-labelledby="parastatikaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="parastatikaModalLabel">Παραστατικά</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (count($receipts) == 0)
                    <a 
                    id="createParastatikoForReceipt" 
                    href="{{ url('admin/create-parastatiko/'.$order->id.'/'.$order->type) }}"
                    class="btn btn-info btn-lg"
                    target="_blank">
                    Έκδοση Παραστατικού
                    </a>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Τύπος</th>
                                <th></th>
                                <th>#</th>
                                <th>Ημ/νια</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->code }}</td>
                                <td>{{ $receipt->type }}</td>
                                <td>{{ $receipt->series }}{{ $receipt->number }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($receipt->created_at)) }}</td>
                                <td>
                                    <a href="{{ url('parastatiko/'.$receipt->id) }}" class="btn btn-primary btn-block" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                                <td>
                                    @if ($receipt->cancelled != 1)
                                        <form method="post" action="{{ url('cancelParastatiko') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{$receipt->id}}">
                                            <button type="submit" class="btn btn-danger btn-block">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                        </form>
                                    @endif 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
            </div>
        </div>
    </div>
</div>

@endsection