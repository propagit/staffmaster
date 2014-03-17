<? if ($expense['status'] == EXPENSE_UNPAID) { ?>
<div class="btn-group" >
	<button type="button" class="btn btn-warning menu-label">Unpaid</button>
	<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a onclick="update_expense_status(<?=$expense['expense_id'];?>, <?=EXPENSE_PAID;?>)">Mark as Paid</a></li>
		<li><a onclick="update_expense_status(<?=$expense['expense_id'];?>, <?=EXPENSE_DELETED;?>)">Mark as Deleted</a></li>
	</ul>
</div>
<? } else if ($expense['status'] == EXPENSE_PAID) { ?>
<div class="btn-group" >
	<button type="button" class="btn btn-success menu-label">Paid</button>
	<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a onclick="update_expense_status(<?=$expense['expense_id'];?>, <?=EXPENSE_UNPAID;?>)">Mark as Unpaid</a></li>
		<li><a onclick="update_expense_status(<?=$expense['expense_id'];?>, <?=EXPENSE_DELETED;?>)">Mark as Deleted</a></li>
	</ul>
</div>
<? } else if ($expense['status'] == EXPENSE_DELETED) { ?>
<div class="btn-group" >
	<button type="button" class="btn btn-danger menu-label">Deleted</button>
	<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a onclick="update_expense_status(<?=$expense['expense_id'];?>, <?=EXPENSE_UNPAID;?>)">Mark as Unpaid</a></li>
		<li><a onclick="update_expense_status(<?=$expense['expense_id'];?>, <?=EXPENSE_PAID;?>)">Mark as Paid</a></li>
	</ul>
</div>
<? } ?>