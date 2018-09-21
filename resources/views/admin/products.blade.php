@extends('layouts.app')

@section('content')

<style>
.list-group-item a {
    display: block;
    color: black;
    text-decoration: none;
}
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/home')}}">Διαχείριση</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Προϊόντα
            </li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <button type="button" class="btn btn-outline-success btn-lg" data-toggle="modal" data-target="#newProductModal">Νέο Προϊόν</button>
        </div>
        <div class="col-sm-12">
            <ul class="list-group">
                @foreach ($products as $product)
                    <li class="list-group-item">   
                        <a href="{{url('admin/product/'.$product->slug)}}">
                            {{$product->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Modal Prices -->
<div class="modal fade" id="newProductModal" tabindex="-1" role="dialog" aria-labelledby="newProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductModalLabel">Νέο Προϊόν</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Product FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/create/product') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <!--sku-->
                            <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                                <label for="sku" class="col-sm-12 control-label">Κωδικός Προϊόντος</label>
                                <div class="col-sm-12">
                                    <input type="text" id="sku" name="sku" class="form-control" required>

                                    @if ($errors->has('sku'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sku') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--name-->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-12 control-label">Όνομα</label>
                                <div class="col-sm-12">
                                    <input type="text" id="name" name="name" class="form-control" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--slug-->
                            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="slug" class="col-sm-12 control-label">Url</label>
                                <div class="col-sm-12">
                                    <input type="text" id="slug" name="slug" class="form-control" required>

                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--quantity-->
                            <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label for="quantity" class="col-sm-12 control-label">Ποσότητα</label>
                                <div class="col-sm-12">
                                    <input type="number" id="quantity" name="quantity" class="form-control" required>

                                    @if ($errors->has('quantity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-footer">
                                    <input type="file" name="image" id="image" />
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--description-->
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-sm-12 control-label">Περιγραφή</label>
                        <div class="col-sm-12">
                            <textarea class="form-control tinymce" id="description" name="description"></textarea>

                            @if ($errors->has('sku'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sku') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-large btn-primary">Αποθήκευση</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection