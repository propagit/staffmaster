<? if (count($payrates) > 0) { ?>
<ul class="nav nav-tabs tab-respond">
	<? foreach($payrates as $payrate) { ?>
	<li<?=($payrate_id == $payrate['payrate_id']) ? ' class="active"' : '';?>><a onclick="load_pay_rates(<?=$payrate['payrate_id'];?>)"><?=$payrate['name'];?></a></li>
	<? } ?>
</ul>
<? } ?>