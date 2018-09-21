<div class="col-sm-12">
    <div class="jumbotron">
        <h2>Κινήσεις Προϊόντος</h2>
        <input type="hidden" id="productInfoId" value="{{ $productId }}">
        <select id="productInfoSelect" class="form-control" style="max-width: 300px;">
            <option value="7">Τελευταίες 7 ημέρες</option>
            <option value="30" selected>Τελευταίες 30 ημέρες</option>
            <option value="365">Τελευταίος Χρόνος</option>
        </select>

        <div id="productInfoCanvasContainer">
            <canvas id="productInfoCanvas" width="400" height="400"></canvas>
        </div>

    </div>
</div>

<script type="text/delayscript">
$(function(){
    populateVisitForDaysCanvas();

    $('#productInfoSelect').change(function(){
        populateVisitForDaysCanvas();
    });

    function populateVisitForDaysCanvas() {
        $.ajax({
            dataType: "json",
            url: APP_URL + '/request/statistics/product/' + $('#productInfoId').val(),
            data: { forDays: $('#productInfoSelect').val() },
            success: function(data){
                console.log(data);
                respondCanvas('productInfoCanvas', 'productInfoCanvasContainer', data.label, data.value, 'Επισκέψεις');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                console.warn(xhr.responseText);
            },
            async: false
        });
    }
});
</script>