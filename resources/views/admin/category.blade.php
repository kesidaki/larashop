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
                <a href="{{url('admin/categories')}}">Κατηγορίες</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{$category->name}}
            </li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <button type="button" class="btn btn-outline-success btn-lg" data-toggle="modal" data-target="#newSubcategoryModal">Νέα Υπο Κατηγορία</button>
        </div>
        <div class="col-sm-12">
            <ul class="category-items">
            @foreach ($subcategories as $subcategory)
                <li class="subcategory-item" data-id="{{$subcategory->id}}" data-name="{{$subcategory->name}}" data-slug="{{$subcategory->slug}}" data-description="{{$subcategory->description}}">   
                    {{$subcategory->name}}
                </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Modal New Category -->
<div class="modal fade" id="newSubcategoryModal" tabindex="-1" role="dialog" aria-labelledby="newSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubcategoryModalLabel">Νέα Υπο-Κατηγορία</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Product FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/create/subcategory') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="category_id" value="{{$category->id}}">
                    
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
<div class="modal fade" id="editSubcategoryModal" tabindex="-1" role="dialog" aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubcategoryModalLabel">Επεξεργασία Υπο-Κατηγορίας</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPricesModalBody">
                <!-- New Category FORM -->
                <form class="form-horizontal" method="POST" action="{{ url('admin/update/subcategory') }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="editSubCatId" name="id">
                    
                    <!--name-->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-12 control-label">Όνομα</label>
                        <div class="col-sm-12">
                            <input type="text" id="editSubCatName" name="name" class="form-control" required>

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
                            <input type="text" id="editSubCatSlug" name="slug" class="form-control" required>

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
                            <textarea class="form-control" id="editSubCatDescription" name="description"></textarea>

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