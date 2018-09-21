@extends('layouts.app', ['chart' => true])

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
            <li class="breadcrumb-item active" aria-current="page">Διαχείριση</li>
        </ol>
    </nav>
</div>

<div class="container">

    <div class="row mb-3">
        <!--Top Buttons-->
        <div class="col-sm">
            <a href="{{ url('admin/products') }}" class="btn btn-primary btn-lg btn-block active">
                Προϊόντα
            </a>
        </div>
        <div class="col-sm">
            <a href="{{ url('admin/categories') }}" class="btn btn-primary btn-lg btn-block active">
                Κατηγορίες
            </a>
        </div>
        <div class="col-sm">
            <a href="{{ url('admin/brands') }}" class="btn btn-primary btn-lg btn-block active">
                Κατασκευαστές
            </a>
        </div>
        <!--End of Top Buttons-->
    </div>

    <div class="row">
        <!--Recent Orders-->
        <div class="col-sm-12">
            <div class="jumbotron">
                <h2>Πρόσφατες Παραγγελίες</h2>
                <table class="table">
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
                </table>

                <a href="{{ url('admin/orders') }}" class="btn btn-secondary">Όλες οι παραγγελίες</a>
            </div>
        </div>
        <!--End of Recent Orders-->
    </div>

    <div class="row">
        @include('templates.statistics.visit-for-days');
    </div>

</div>

@endsection