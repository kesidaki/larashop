<div class="col-sm-12">
    <div class="jumbotron">
        <h2>Επισκέψεις στη Σελίδα</h2>
        <select id="visitsForDaysChartSelect" class="form-control" style="max-width: 300px;">
            <option value="7">Τελευταίες 7 ημέρες</option>
            <option value="30" selected>Τελευταίες 30 ημέρες</option>
            <option value="365">Τελευταίος Χρόνος</option>
        </select>

        <div id="visitForDaysCanvasContainer">
            <canvas id="visitForDaysCanvas" width="400" height="400"></canvas>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Σελίδα</th>
                    <th>Επισκέψεις</th>
                </tr>
            </thead>
            <tbody id="visitForDaysTable">
                
            </tbody>
        </table>
    </div>
</div>

<script type="text/delayscript">
$(function(){
    populateVisitForDaysCanvas();

    $('#visitsForDaysChartSelect').change(function(){
        populateVisitForDaysCanvas();
    });

    function populateVisitForDaysCanvas() {
        $.ajax({
            dataType: "json",
            url: APP_URL + '/request/statistics/visits',
            data: { forDays: $('#visitsForDaysChartSelect').val() },
            success: function(data){
                respondCanvas('visitForDaysCanvas', 'visitForDaysCanvasContainer', data.label, data.value, 'Επισκέψεις');

                var str = '';
                $.each(data.label, function(i, line){
                    str += "<tr>";
                    str += '<td> <a href="' + APP_URL + '/' + line + '?ref=console" target="_blank">' + line + '</a></td>';
                    str += "<td>" + data.value[i] + "</td>";
                    str += "</tr>";
                });
                $("#visitForDaysTable").html(str);
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