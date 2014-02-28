<? if ($invoice['status'] == INVOICE_GENERATED) { ?>
<div class="btn-group" >
	<button type="button" class="btn btn-danger menu-label">Unpaid</button>
	<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a onclick="mark_as_paid(<?=$invoice['invoice_id'];?>)">Mark as Paid</a></li>
	</ul>
</div>
<? } else if ($invoice['status'] == INVOICE_PAID) { ?>
<div class="btn-group" >
	<button type="button" class="btn btn-success menu-label">Paid</button>
	<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a onclick="mark_as_unpaid(<?=$invoice['invoice_id'];?>)">Mark as Unpaid</a></li>
	</ul>
</div>
<? } ?>