$(function(){
	$('#searchTermForm').submit(function(e) {
		e.preventDefault();
        var term = $("#search-term").val();
        if (term != '') {
           window.location.href = APP_URL + '/search/' + term;
        }
    });

	$('#checkoutShipping').change(function() {
		var value = $(this).find(':selected').data('cost');
		var cost  = $('#table-summary-cost').html();

		$('#table-summary-shipping').html(value);
		var total = parseFloat(value) + parseFloat(cost);
		$('#table-summary-total').html(total);
	});

	$('#orderPayment').change(function(){
		var value = $(this).val();
		if (value == 'Απόδειξη') {
			$('#profession-container, #doy-container, #afm-container').hide();
		}
		else if (value == 'Τιμολόγιο') {
			$('#profession-container, #doy-container, #afm-container').show();
		}
	});

	$("input:checkbox").on('click', function() {
		var $box = $(this);
		if ($box.is(":checked")) {
		var group = "input:checkbox[name='" + $box.attr("name") + "']";
		$(group).prop("checked", false);
			$box.prop("checked", true);
		} else {
			$box.prop("checked", false);
		}
	});
});