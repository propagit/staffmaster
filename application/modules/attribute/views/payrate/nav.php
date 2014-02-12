<? if (count($payrates) > 0) { 
	foreach($payrates as $payrate) { ?>
	<div class="btn-group btn-nav">
		<button type="button" class="btn btn-<?=($payrate_id == $payrate['payrate_id']) ? 'core' : 'default';?>" onclick="load_nav_payrates(<?=$payrate['payrate_id'];?>)"><?=$payrate['name'];?></button>
		<button type="button" class="btn btn-<?=($payrate_id == $payrate['payrate_id']) ? 'core' : 'default';?> dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a>Edit name</a></li>
			<li><a>Duplicate</a></li>
			<li><a>Delete</a></li>
		</ul>
	</div>
	<? }
} ?>

<script>

</script>
