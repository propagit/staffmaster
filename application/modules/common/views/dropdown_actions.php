<div class="btn-group">
	<button type="button" class="btn btn-info">Action</button>
	<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<? foreach($actions as $key => $label) { ?>
		<li><a class="menu_<?=$key;?>_<?=$target;?>"><?=$label;?></a></li>
		<? } ?>
	</ul>
</div>