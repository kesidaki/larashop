<div class="row mb-4">
	<div class="col-sm-12">
		<button type="button" id="sidebarCollapse" class="btn btn-info">
		    <i class="fas fa-sliders-h"></i>
		    <span>Φίλτρα</span>
		</button>
	</div>
</div>

<nav id="sidebar">
	
	<div id="dismiss">
		<i class="fas fa-arrow-left"></i>
	</div>

	<div class="sidebar-header">
        <h3>Φίλτρα</h3>
    </div>

    <form method="GET" class="form-custom" id="filterForm">
		<input type="hidden" id="filterFormCategory" value="{{ $categories }}" />
		<input type="hidden" id="filterFormSubcat" value="{{ $active['subcategories'] }}" />
		<input type="hidden" id="filterFormBrand" value="{{ $active['brand'] }}" />
		<input type="hidden" id="filterFormMinPrice" value="{{ $active['minPrice'] }}" />
		<input type="hidden" id="filterFormMaxPrice" value="{{ $active['maxPrice'] }}" />

	    <ul class="list-unstyled components">

	    	<!-- Filter by Category -->
	    	@if (count($filter['avSubcategories']) > 1)
	        <li class="filter-group">
	        	<h4>Κατηγορία</h4>
	        	@foreach ($filter['avSubcategories'] as $i=>$fs)
				<div class="form-check">
					<div class="custom-control form-control-lg custom-checkbox">
						<input 
						type="checkbox" 
						class="custom-control-input filter-subcategory" 
						name="subcategory" 
						id="filterCat{{$i}}" 
						value="{{$fs['slug']}}" 
						{{ ( ($active['subcategories']) && (strpos($active['subcategories'], $fs['slug']) !== false ) ) ?'checked':''}}>
						<label class="custom-control-label" for="filterCat{{$i}}">{{$fs['name']}}</label>
					</div>
				</div>
				@endforeach
	        </li>
	        @endif
	        
	        <!-- Filter By Prices -->
	        {{-- <li class="filter-group">
	        	<h4>Εύρος Τιμής</h4>
	        	<div class="row">
					<div class="col">
						<div id="range"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<input type="float" step="0.1" id="minPrice" class="form-control" value="{{$filter['prices']['minPrice']}}">
					</div>
					<div class="col-sm-6">
						<input type="float" step="0.1" id="maxPrice" class="form-control" value="{{$filter['prices']['maxPrice']}}">
					</div>
				</div>
	        </li> --}}

	        <!-- Filter by Brand -->
			@if (count($filter['brands']) > 1)
			<li class="filter-group">
				<h4>Μάρκες</h4>
				@foreach ($filter['brands'] as $i=>$b)
				@if ($b != '')
					<div class="form-check">
						<div class="custom-control form-control-lg custom-checkbox">
							<input type="checkbox" class="custom-control-input filter-brand" name="brand" id="filterBrand{{$i}}" value="{{$b}}" 
							{{ ( $active['brand'] == $b ) ?'checked':''}}>
							<label class="custom-control-label" for="filterBrand{{$i}}">{{$b}}</label>
						</div>
					</div>
				@endif
				@endforeach
			</li>
			@endif

	    </ul>

</nav>

<script type="text/delayscript">
$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        // hide sidebar
        $('#sidebar').removeClass('active');
        // hide overlay
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        // open sidebar
        $('#sidebar').addClass('active');
        // fade in the overlay
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    $("input:checkbox.filter-subcategory").click(function(){
    	generateProductsUrl();
	});

	$("input:checkbox.filter-brand").click(function(){
    	generateProductsUrl();
	});

	function generateProductsUrl() {
		// Get Filter Values
		// var minPrice = $('#minPrice').val();
		// var maxPrice = $('#maxPrice').val();

		var route      = $('#filterFormCategory').val();
		var categories = $('input[name="subcategory"]:checked').val();
		var brand      = $('input[name="brand"]:checked').val();

		console.log(categories);
		console.log(brand);

		// Generate Params
		var variables  = {};
		// variables.minPrice = minPrice;
		// variables.maxPrice = maxPrice;
		if (categories != undefined) {
			variables.categories = categories;
		}
		if (brand != undefined) {
			variables.brand = brand;
		}
		var params     = jQuery.param(variables);

		let url   = APP_URL + '/products/' + route + '?' + params;

		window.location.href = url;
		// console.log(url);
	}
});
</script>