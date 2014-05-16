<table cellpadding="0" cellspacing="0" width="100%">
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr class="dotted-border">
	<td><h1 class="invoice-h1-margin-top">Total Due</h1></td>	
	<td align="right"><h1 class="invoice-h1-margin-top"><?=modules::run('common/format_money',$total);?></h1></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td><h2>Due Date</h2></td>	
	<td align="right"><a href="#" class="inv_company_due_date prim-color-to-txt-color" data-type="date"  data-pk="<?=$invoice['invoice_id']?>" data-title="Due Date"><h4><?=date('dS M Y', strtotime($invoice['due_date']));?></h4></a></td>
</tr>
<tr>
	<td class="padding-gst">GST</td>			
	<td align="right" class="padding-gst"><?=modules::run('common/format_money',$gst);?></td>
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
