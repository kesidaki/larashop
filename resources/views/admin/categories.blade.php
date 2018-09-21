@extends('layouts.app')

@section('content')

<style>
ul.category-items {
    list-style-type: none;
}
ul.category-items li {
    display: inline-block;
    cursor: pointer;
    font-size: 20px;
    background-color: #c34271;
    color: white;
    padding: 5px 15px;
    border-radius: 15px;
    margin-top: 5px;
}
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/home')}}">Διαχείριση</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Κατηγορίες
            </li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <button type="button" class="btn btn-outline-success btn-lg" data-toggle="modal" data-target="#newCategoryModal">Νέα Κατηγορία</button>
        </div>
        <div class="col-sm-12">
            <ul class="category-items">
                @foreach ($categories as $category)
                    <li class="category-item" data-id="{{$category->id}}" data-name="{{$category->name}}" data-slug="{{$category->slug}}" data-description="{{$category->description}}">   
                        {{$category->name}}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Modal New Category -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCategoryModalLabel">Νέα Κατηγορία</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Product FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/create/category') }}">
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
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Επεξεργασία Κατηγορίας</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Category FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/update/category') }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="editCatId" name="id">
                    
                    <!--name-->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-12 control-label">Όνομα</label>
                        <div class="col-sm-12">
                            <input type="text" id="editCatName" name="name" class="form-control" required>

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
                            <input type="text" id="editCatSlug" name="slug" class="form-control" required>

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
                            <textarea class="form-control" id="editCatDescription" name="description"></textarea>

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
                        <a id="category-link" class="btn btn-lg btn-outline-info">Κατηγορία</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection