@extends('layouts.app')

@section('content')

<style type="text/css">
@media (min-width: 576px) {
    .jumbotron {
        padding: 2rem 2rem;
    }
}
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/home')}}">Διαχείριση</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Παραγγελίες
            </li>
        </ol>
    </nav>
</div>

<div class="container">

    <div class="row mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Αναζήτηση με Όνομα, Διεύθυνση ή Τηλέφωνο.." id="searchOrderTerm" value="{{$term}}">
        <div class="input-group-append">
            <button id="searchOrderButton" class="btn btn-outline-dark btn-block">Αναζήτηση</button>
        </div>
        </div>
    </div>

    <div class="row mb-3">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Ημ/νια</th>
                    <th>Όνομα</th>
                    <th>Διεύθυνση</th>
                    <th>Σύνολο</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->address.','.$order->city  }}</td>
                    <td>{{ $order->total }} &euro;</td>
                    <td>
                        <a href="{{ url('admin/order/'.$order->id) }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        {{ $orders->render() }}
    </div>

</div>

@endsection