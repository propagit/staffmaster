<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td><h3>Total Due</h3></td>	
	<td align="right"><h3>$<?=money_format('%i', $total);?></h3></td>
</tr>
<tr>
	<td><h4>Due Date</h4></td>	
	<td align="right"><h4><?=date('dS M Y', strtotime($invoice['due_date']));?></h4></td>
</tr>
<tr>
	<td class="padding-gst">GST</td>			
	<td align="right" class="padding-gst">$<?=money_format('%i', $gst);?></td>
</tr> 
</table>