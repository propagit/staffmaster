<table width="100%" cellpadding="10">
<tr>
    <td colspan="3"><h2>Expense Break Down</h2></td>
</tr>

<tr>
    <td width="50%">Description</td>
    <td align="right" width="15%">GST</td>
    <td align="right">Sub Total</td>
    <td align="right">Total</td>
    <td width="20"></td>
</tr>
<? foreach($items as $item) { if($item['job_id']) { ?>
<tr>
	<td>
		<a href="#" class="edit_item_title prim-color-to-txt-color" data-type="text"  data-pk="<?=$item['item_id']?>" data-title="Item Title"> 
		
		<? if ($item['include_timesheets']) { ?>
		<b><?=$item['title'];?></b>
		<? } else { ?>
		<span class="indent"> <?=$item['title'];?></span>
		<? } ?>
		
		</a>
	</td>
	<td align="right">
		<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
        <?=modules::run('common/format_money',($item['amount']/11));?>
		<? } else { echo '$0.<sub class="amount-cents-subscript">00</sub>'; } ?>
	</td>
	<td align="right">
		<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
        <?=modules::run('common/format_money',($item['amount']/11*10));?>
		<? } else { ?>
        <?=modules::run('common/format_money',$item['amount']);?>
        <? } ?>
	</td>
	<td align="right"><?=modules::run('common/format_money',$item['amount']);?></td>
	<td align="right"><a onclick="delete_item(<?=$item['item_id'];?>)"><i class="fa fa-times"></i></a></td>
</tr>            
<? } } ?>

<? foreach($items as $item) { if(!$item['job_id']) { ?>
<tr>
	<td>
		<a href="#" class="edit_item_title prim-color-to-txt-color" data-type="text"  data-pk="<?=$item['item_id']?>" data-title="Item Title"><?=$item['title'];?></a>
	</td>
	<td align="right">
		<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
        <?=modules::run('common/format_money',($item['amount']/11));?>
		<? } ?>
	</td>
	<td align="right">
		<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
        <?=modules::run('common/format_money',($item['amount']/11*10));?>
		<? } ?>
	</td>
	<td align="right">
		<? if($item['amount'] != 0) { ?>
        <?=modules::run('common/format_money',$item['amount']);?>
		<? } ?>
	</td>
	<td align="right"><a onclick="delete_item(<?=$item['item_id'];?>)"><i class="fa fa-times"></i></a></td>
</tr> 
<? } } ?>
</table>
<script>
$(function(){
	$('.edit_item_title').editable({
		url: '<?=base_url();?>invoice/ajax/edit_invoice_item_title',		
	});
})
</script>