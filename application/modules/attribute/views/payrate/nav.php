<? if (count($payrates) > 0) { 
	foreach($payrates as $payrate) { ?>
	<div class="btn-group btn-nav">
		<button type="button" class="btn btn-<?=($payrate_id == $payrate['payrate_id']) ? 'core' : 'default';?>" onclick="load_nav_payrates(<?=$payrate['payrate_id'];?>)"><?=$payrate['name'];?></button>
		<button type="button" class="btn btn-<?=($payrate_id == $payrate['payrate_id']) ? 'core' : 'default';?> dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a onclick="edit_payrate_name(<?=$payrate['payrate_id'];?>)"><i class="fa fa-pencil-square-o"></i> Edit name</a></li>
			<!-- <li><a>Duplicate</a></li> -->
			<li><a onclick="delete_payrate(<?=$payrate['payrate_id'];?>)"><i class="fa fa-times"></i> Delete</a></li>
		</ul>
	</div>
	<? }
} ?>

<script>
function edit_payrate_name(payrate_id) {
	$('.bs-modal-lg').modal({
		remote: "<?=base_url();?>attribute/ajax_payrate/load_edit_name_modal/" + payrate_id,
		show: true
	});
}
function delete_payrate(payrate_id) {
	$('.bs-modal-lg').modal({
		remote: "<?=base_url();?>attribute/ajax_payrate/load_delete_modal/" + payrate_id,
		show: true
	});
}
</script>
