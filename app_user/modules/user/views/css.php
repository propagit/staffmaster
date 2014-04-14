<?php
header('Content-type: text/css');
$colour_primary = ($user['colour_primary']) ? $user['colour_primary'] : COLOR_PRIM;
$colour_secondary = ($user['colour_secondary']) ? $user['colour_secondary'] : COLOR_SECO;
$colour_highlight = ($user['colour_highlight']) ? $user['colour_highlight'] : COLOR_HILI;
$colour_midtone = ($user['colour_midtone']) ? $user['colour_midtone'] : COLOR_MIDT;
$colour_dark = ($user['colour_dark']) ? $user['colour_dark'] : COLOR_DARK;
?>
html,
body,
#footer a,
.menu ul li a {
	color: <?=$colour_midtone?>;
}
#footer,
.page-title {	
	background: <?=$colour_secondary;?>;
}
.dark {
	color: <?=$colour_dark;?>;
}
a,
.c1,
.c3,
.c6,
#tweets ul li small {
	color: <?=$colour_primary;?>;
}
.c4,
.table .heading {
	color: <?=$colour_dark;?>;
}
.menu ul li.active, 
.btn-primary {
	/* Safari 4-5, Chrome 1-9 */ 
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?=$colour_primary;?>), to(<?=$colour_secondary;?>)); 
	/* Safari 5.1, Chrome 10+ */ 
	background: -webkit-linear-gradient(top, <?=$colour_primary;?>, <?=$colour_secondary;?>); 
	/* Firefox 3.6+ */ 
	background: -moz-linear-gradient(top, <?=$colour_primary;?>, <?=$colour_secondary;?>); 
	/* IE 10 */ 
	background: -ms-linear-gradient(top, <?=$colour_primary;?>, <?=$colour_secondary;?>); 
	/* Opera 11.10+ */ 
	background: -o-linear-gradient(top, <?=$colour_primary;?>, <?=$colour_secondary;?>);
}
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.btn-primary.disabled,
.btn-primary[disabled] {
	/* Safari 4-5, Chrome 1-9 */ 
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?=$colour_secondary;?>), to(<?=$colour_primary;?>)); 
	/* Safari 5.1, Chrome 10+ */ 
	background: -webkit-linear-gradient(top, <?=$colour_secondary;?>, <?=$colour_primary;?>); 
	/* Firefox 3.6+ */ 
	background: -moz-linear-gradient(top, <?=$colour_secondary;?>, <?=$colour_primary;?>); 
	/* IE 10 */ 
	background: -ms-linear-gradient(top, <?=$colour_secondary;?>, <?=$colour_primary;?>); 
	/* Opera 11.10+ */ 
	background: -o-linear-gradient(top, <?=$colour_secondary;?>, <?=$colour_primary;?>);
}

.page-title h2,
.menu ul li.active a {
	color: <?=$colour_highlight;?>;
}
#footer, #footer a {
	color: <?=$colour_highlight;?>;
}