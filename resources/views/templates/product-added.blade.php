<div class="modal" id="productAddedModal" tabindex="-1" role="dialog" aria-labelledby="productAddedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-product-added" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-12 col-md-4">
                    <img class="card-img-top" 
                    src="{{asset('public/products/'.Session::get('productAdded')->image)}}" 
                    alt="{{Session::get('productAdded')->name}}">
                </div>
                <div class="col-sm-12 col-md-8">
                    <h2>{{Session::get('productAdded')->name}}</h2>
                    <p>Το προϊόν προστέθηκε στο καλάθι σας</p>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-block" role="group" aria-label="Product Added Modal">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fas fa-chevron-left mr-2"></i> Συνέχεια Αγορών
                    </button>
                    <a href="{{ url('cart') }}" class="btn btn-success">
                        <i class="fas fa-shopping-cart mr-2"></i> Καλάθι
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/delayscript">
$(function(){
  $('#productAddedModal').modal('show');
})
</script>