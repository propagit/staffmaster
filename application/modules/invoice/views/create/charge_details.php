<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td><h3>Total Due</h3></td>	
	<td align="right"><h3>$<?=money_format('%i', $total);?></h3></td>
</tr>
<tr>
	<td><h4>Due Date</h4></td>	
	<td align="right"><a href="#" class="inv_company_due_date" data-type="date"  data-pk="<?=$invoice['invoice_id']?>" data-title="Due Date"><h4><?=date('dS M Y', strtotime($invoice['due_date']));?></h4></a></td>
</tr>
<tr>
	<td class="padding-gst">GST</td>			
	<td align="right" class="padding-gst">$<?=money_format('%i', $gst);?></td>
</tr> 
</table>
<script>
$('.inv_company_due_date').editable({
	  format: 'yyyy-mm-dd hh:ii',
	  viewformat: 'dd M yyyy',
	  datepicker: {
		 weekStart: 1
	  }	,	
	  url: '<?=base_url();?>invoice/ajax/edit_client_invoice_due_date',
	  
});
</script>
