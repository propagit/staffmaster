<? if (!isset($forecast)) { ?>
<div class="alert alert-warning">No data</div>
<? } else { ?>
<div id="chart-job-profit" style="height: 400px; min-width: 300px; margin: 0 auto;"></div>
<table id="datatable" class="hide">
	<thead>
		<tr>
			<th></th>
			<th>Bill to-date</th>
			<th>Total Estimation</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Invoice</th>
			<td><?=$invoice;?></td>
			<td><?=$forecast['invoice'];?></td>
		</tr>
		<tr>
			<th>Staff Pay</th>
			<td><?=$staff;?></td>
			<td><?=$forecast['staff'];?></td>
		</tr>
		<tr>
			<th>Staff Expenses</th>
			<td><?=$expense;?></td>
			<td><?=$forecast['expense'];?></td>
		</tr>
		<tr>
			<th>Profit</th>
			<td><?=$invoice - $staff - $expense;?></td>
			<td><?=$forecast['invoice'] - $forecast['staff'] - $forecast['expense'];?></td>
		</tr>
	</tbody>
</table>
<script>
$(function(){
	var chart = new Highcharts.Chart({
        data: {
            table: document.getElementById('datatable')
        },
        chart: {
        	renderTo: 'chart-job-profit',
            type: 'column'
        },
        title: {
            text: ''
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: ''
            }
        },
        tooltip: {
            formatter: function() {
                return this.series.name +' '+ this.point.name + ':<br/>' + 
                    '<b>$' + this.point.y + '</b>';
            }
        }
    });
})
</script>
<? } ?>