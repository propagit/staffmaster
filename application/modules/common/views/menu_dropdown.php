<div class="btn-group btn-nav mob-class" id="menu-<?=$id;?>">
	<button type="button" class="btn btn-core menu-label"><?=$label;?></button>
	<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
	<? foreach($data as $e) { ?>
	<li><a data-value="<?=$e['value'];?>"><?=$e['label'];?></a></li>
	<? } ?>
	</ul>
</div>