/*
Admin Console - Product Buttons
*/
var baseUrl = 'http://127.0.0.1:8000';

$(document).on('click', '.deleteProductPrice', function(){
	var parent = $(this).parent().parent();
	parent.remove();
});

$('#newProductPrice').click(function(){
	var container = $('#productPricesModalBody');
	var content   = '<div class="form-group row">';
		content  += '<div class="col-sm-3">';
		content  += '<label for="price[]">Τιμή (&euro;)</label>';
		content  += '<input type="number" step="0.01" name="price[]" class="form-control">';
		content  += '</div>';
		content  += '<div class="col-sm-5">';
		content  += '<label for="description[]">Περιγραφή</label>';
		content  += '<input type="text" name="description[]" class="form-control">';
		content  += '</div>';
		content  += '<div class="col-sm-4">';
		content  += '<label>&nbsp;</label>';
		content  += '<button type="button" class="btn btn-warning deleteProductPrice">Διαγραφή Τιμής</button>';
		content  += '</div>';
		content  += '</div>';
	container.append(content);
});

$('#newCategoryBtn').click(function(){
	var value     = $('#newCategory').val();
	var container = $('#productCategoriesContainer');
	var content   = '<div class="read-only-input">';
		content  += '<input type="text" value="'+value+'" name="categories[]" readonly>';
		content  += '<span class="catDeleteIcon" aria-hidden="true">&times;</span>';
		content  += '</div>';
	container.append(content);
});

$('#newSubCategoryBtn').click(function(){
	var value     = $('#newSubCategory').val();
	var container = $('#productSubCategoriesContainer');
	var content   = '<div class="read-only-input">';
		content  += '<input type="text" value="'+value+'" name="subcategories[]" readonly>';
		content  += '<span class="catDeleteIcon" aria-hidden="true">&times;</span>';
		content  += '</div>';
	container.append(content);
});

$(document).on('click', '.catDeleteIcon', function(){
	var parent = $(this).parent();
	parent.remove();
});

$('.category-item').click(function() {
	$('#editCatId').val($(this).data('id'));
	$('#editCatName').val($(this).data('name'));
	$('#editCatSlug').val($(this).data('slug'));
	$('#editCatDescription').val($(this).data('description'));
	$('#category-link').attr("href", baseUrl + "/admin/category/"+$(this).data('id'));

	$('#editCategoryModal').modal('show');
});

$('.subcategory-item').click(function() {
	$('#editSubCatId').val($(this).data('id'));
	$('#editSubCatName').val($(this).data('name'));
	$('#editSubCatSlug').val($(this).data('slug'));
	$('#editSubCatDescription').val($(this).data('description'));

	$('#editSubcategoryModal').modal('show');
});

$('.editBrandButton').click(function() {
	$('#editBrandId').val($(this).data('id'));
	$('#editBrandName').val($(this).data('name'));
	$('#editBrandSlug').val($(this).data('slug'));
	$('#editBrandDescription').val($(this).data('desc'));

	$('#editBrandModal').modal('show');
});

$('#searchOrderButton').click(function() {
	var value = $('#searchOrderTerm').val();

	if (value != '') {
		window.location.href = APP_URL + '/admin/orders?term=' + value;
	}
});

$(document).on('click', '.discardItemFromAdminCart', function(){
	var line = $(this).parent().parent();
		line.remove();
});

$('#searchProductToAddButton').click(function(){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: APP_URL + '/request/products',
        type: "GET",
        dataType: "json",
        data: { _token: CSRF_TOKEN, term: $('#searchProductToAdd').val() },
        header: { 
            Accept:         'application/json'
        },
        success: function (response) {
            console.log(response);

            $.each(response, function(i, data){
				str = "";
				str += '<tr>';
				str += '<td>' + data.sku + '</td>';
				str += '<td>' + data.name + '</td>';
				str += '<td>' + data.product_price + '&euro; </td>';
				str += '<td> <button type="button" class="btn btn-outline-success btn-block addToBuyingList" data-pid="' + data.id + '" data-name="' + data.name + '" data-price="' + data.product_price + '" data-thumb = "' + data.thumb + '"><i class="fa fa-shopping-cart"></i></button></td>';
				str += '</tr>';
				$("#searchProductToAddResults").append(str);
			});
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            console.warn(xhr.responseText);
        }
    });
});

$(document).on('click', '.addToBuyingList', function(){
	var id    = $(this).data('pid');
	var thumb = $(this).data('thumb');
	var name  = $(this).data('name');
	var qty   = 1;
	var price = $(this).data('price');

	var str = "";
	str += '<tr>';
	str += '<td class="td-img"><img src="' + APP_URL + '/public/thumbnail/' + thumb + '"></td>';
	str += '<td><input type="hidden" name="pId[]" value="' + id + '"><input type="text" name="pName[]" class="form-control" value="' + name + '" readonly/></td>';
	str += '<td><input type="number" name="pQty[]" class="form-control" value="' + qty + '" min="1"/></td>';
	str += '<td><input type="number" step="0.01" name="pPrice[]" class="form-control" value="' + price + '" readonly/></td>';
	str += '<td><a class="discardItemFromAdminCart"><i class="fas fa-trash"></i></a></td>';
	str += '</tr>';

	$('#listOfOrderProducts').append(str);
});

$('#createParastatikoForReceipt').click(function(){
	$('#createParastatikoForReceipt').hide();
	$('#newOrderProductButton').hide();
});

function respondCanvas(canvas, container, inp_label, inp_data, title, type='bar') {
	// Destroy - Recreate Canvas
	$('#' + canvas).remove();
	$('#' + container).append('<canvas id="' + canvas + '"><canvas>');
 
	// Get Random Colors
	var colors = [];
	for (i=0; i<inp_label.length; i++) {
		colors.push(getRandomColor());
	}

	// Generate Chart
	var ctx      = $('#' + canvas);
	var BarChart = new Chart(ctx, {
		type: type,
		data: {
			labels: inp_label,
			datasets: [{
				label: title,
				backgroundColor: 'rgba(100, 181, 246, 0.5)',
				borderColor: '#1e88e5',
				data: inp_data,
	            borderWidth: 1,
	            scaleOverride:true,
	            scaleSteps:9,
	            scaleStartValue:0,
	            scaleStepWidth:1
			}]
		},
		options: {
			segmentShowStroke : false,
	    	animateScale : true,
	    	scales: {
	    		xAxes: [{
					gridLines: {
	                    display:false
	                }
				}],
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
}

function getRandomColor() {
	var letters = '0123456789ABCDEF'.split('');
	var color = '#';
	for (var i = 0; i < 6; i++ ) {
	    color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}