@extends('layouts.app', ['tinymce' => $tinymce, 'chart' => true])

@section('content')

<style>
.list-group-item a {
    display: block;
    color: black;
    text-decoration: none;
}
.read-only-input {
    display: inline-block;
    position: relative;
    color: white;
    margin-top: 5px;
}
.read-only-input input {
    padding: 5px 12px;
    background-color: #c34271;
    color: white;
    border: none;
    border-radius: 15px;
}
.read-only-input .catDeleteIcon {
    position: absolute;
    right: 10px;
    top: 4px;
    cursor: pointer;
}
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/home')}}">Διαχείριση</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{url('admin/products')}}">Προϊόντα</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{$product->name}}
            </li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-12">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#productPrices">
                <i class="fas fa-euro-sign"></i> Τιμές
            </button>
            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#productCategories">
                <i class="fas fa-tasks"></i> Κατηγορίες
            </button>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#productSubCategories">
                <i class="fas fa-tasks"></i> Υπο-Κατηγορίες
            </button>
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#productStatisticsModal">
                <i class="fas fa-chart-bar"></i> Στατιστικά
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <!-- Product Information FORM -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/update/product/info') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$product->id}}">

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="card"> 
                            @if ($product->image != '')
                                <img class="card-img-top" src="{{asset('products/'.$product->image)}}">
                            @else
                                <div class="card-body">
                                    <p>Δεν υπάρχει εικόνα ακόμα!</p>
                                </div>
                            @endif
                            <div class="card-footer">
                                <div class="form-group">
                                    <input type="file" class="form-control-file" name="image" id="image" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-8">
                        <!--sku-->
                        <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                            <label for="sku" class="col-sm-12 control-label">Κωδικός Προϊόντος</label>
                            <div class="col-sm-12">
                                <input type="text" id="sku" name="sku" class="form-control" value="{{$product->sku}}" required>

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
                                <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}" required>

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
                                <input type="text" id="slug" name="slug" class="form-control" value="{{$product->slug}}" required>

                                @if ($errors->has('slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--brand-->
                        <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
                            <label for="brand" class="col-sm-12 control-label">Κατασκευαστής</label>
                            <div class="col-sm-12">
                                <select name="brand" id="brand" class="form-control">
                                    <option {{(is_null($product->brand_id))?'selected':''}} value="">---</option>
                                    @foreach ($brands as $brand)
                                    <option {{($product->brand_id == $brand->id)?'selected':''}} value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select> 

                                @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--quantity-->
                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label for="quantity" class="col-sm-12 control-label">Ποσότητα</label>
                            <div class="col-sm-12">
                                <input type="number" id="quantity" name="quantity" class="form-control" value="{{$product->quantity}}" required>

                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
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
                        <textarea class="form-control tinymce" id="description" name="description" required="">{{$product->description}}</textarea>

                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
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

<!-- Modal Prices -->
<div class="modal fade" id="productPrices" tabindex="-1" role="dialog" aria-labelledby="productPricesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productPricesLabel">Τιμές Προϊόντος</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Product Prices FORM -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/update/product/prices') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="modal-body" id="productPricesModalBody">
                    @foreach ($product->prices as $price)
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="price[]">Τιμή (&euro;)</label>
                                <input type="number" step="0.01" name="price[]" value="{{$price->price}}" class="form-control">
                            </div>
                            <div class="col-sm-5">
                                <label for="description[]">Περιγραφή</label>
                                <input type="text" name="description[]" value="{{$price->description}}" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-warning deleteProductPrice">Διαγραφή Τιμής</button>
                            </div>
                        </div>
                    @endforeach                
                </div>
                <div class="modal-footer">
                    <button type="button" id="newProductPrice" class="btn btn-success">Νέα Τιμή</button>
                    <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Categories -->
<div class="modal fade" id="productCategories" tabindex="-1" role="dialog" aria-labelledby="productCategoriesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productCategoriesLabel">Κατηγορίες Προϊόντος</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Product Categories FORM -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/update/product/categories') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="modal-body" id="productCategoriesModalBody">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-9">
                            <select id="newCategory" class="form-control">
                                <option disabled selected>Επιλέξτε Κατηγορία</option>
                                @foreach ($categories as $cat)
                                    <option>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <button type="button" id="newCategoryBtn" class="btn btn-block">Add</button>
                        </div>
                    </div>

                    <div id="productCategoriesContainer"> 
                        @foreach ($product->categories as $category)
                            <div class="read-only-input">
                                <input type="text" value="{{$category->name}}" name="categories[]" readonly>
                                <span class="catDeleteIcon" aria-hidden="true">&times;</span>
                            </div>
                        @endforeach
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sub Categories -->
<div class="modal fade" id="productSubCategories" tabindex="-1" role="dialog" aria-labelledby="productSubCategoriesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productSubCategoriesLabel">Υπο Κατηγορίες Προϊόντος</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Product Categories FORM -->
            <form class="form-horizontal" method="POST" action="{{ url('admin/update/product/subcategories') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="modal-body" id="productCategoriesModalBody">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-9">
                            <select id="newSubCategory" class="form-control">
                                <option disabled selected>Επιλέξτε Κατηγορία</option>
                                @foreach ($subcategories as $sub)
                                    <optgroup label="{{$sub['category']}}">
                                        @foreach ($sub['subcategories'] as $s)
                                            <option>{{$s->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <button type="button" id="newSubCategoryBtn" class="btn btn-block">Add</button>
                        </div>
                    </div>

                    <div id="productSubCategoriesContainer"> 
                        @foreach ($product->subcategories as $subcategory)
                            <div class="read-only-input">
                                <input type="text" value="{{$subcategory->name}}" name="subcategories[]" readonly>
                                <span class="catDeleteIcon" aria-hidden="true">&times;</span>
                            </div>
                        @endforeach
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sub Categories -->
<div class="modal fade" id="productStatisticsModal" tabindex="-1" role="dialog" aria-labelledby="productStatisticsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productStatisticsModalLabel">Στατιστικά Προϊόντος</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Product Categories FORM -->
            <div class="modal-body">
                @include('templates.statistics.product-info', ['productId' => $product->id]);
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
    </div>
</div>

@endsection