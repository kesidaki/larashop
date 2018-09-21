@extends('layouts.app')

@section('content')

<style>

</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/home')}}">Διαχείριση</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Κατασκευαστές
            </li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <button type="button" class="btn btn-outline-success btn-lg" data-toggle="modal" data-target="#newBrandModal">Νέος Κατασκευαστής</button>
        </div>

        <div class="col-sm-12">
            <div class="table-responsive table-responsive-md">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Brand</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($brands as $key=>$brand)
                        <tr>
                            <td class="align-middle">{{$key+1}}</td>
                            <td class="align-middle">{{$brand->name}}</td>
                            <td>
                                <button type="button" 
                                class="btn btn-primary editBrandButton" 
                                data-id="{{$brand->id}}" 
                                data-name="{{$brand->name}}" 
                                data-slug="{{$brand->slug}}" 
                                data-desc="{{$brand->description}}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal New Category -->
<div class="modal fade" id="newBrandModal" tabindex="-1" role="dialog" aria-labelledby="nnewBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newBrandModalLabel">Νέο Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Product FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/create/brand') }}">
                    {{ csrf_field() }}
                    
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

                    <!--description-->
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-sm-12 control-label">Περιγραφή</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="description" name="description"></textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-lg btn-primary">Αποθήκευση</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Category -->
<div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">Επεξεργασία Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Category FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/update/brand') }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="editBrandId" name="id">
                    
                    <!--name-->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-12 control-label">Όνομα</label>
                        <div class="col-sm-12">
                            <input type="text" id="editBrandName" name="name" class="form-control" required>

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
                            <input type="text" id="editBrandSlug" name="slug" class="form-control" required>

                            @if ($errors->has('slug'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('slug') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--description-->
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-sm-12 control-label">Περιγραφή</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="editBrandDescription" name="description"></textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <button type="submit" name="submit" value="edit" class="btn btn-lg btn-primary">Αποθήκευση</button>
                        <button type="submit" name="submit" value="delete" class="btn btn-lg btn-outline-danger" onClick="return confirm('Είστε σιίγουρος ότι θέλετε να διαγράψετε τη κατηγορία?')">Διαγραφή</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection