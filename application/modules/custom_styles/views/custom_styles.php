<?php
echo header('Content-type: text/css');
$primary_colour = $styles['primary_colour'];
$secondary_colour = $styles['secondary_colour'];
$rollover_colour = $styles['rollover_colour'];
$text_colour = $styles['text_colour'];
?>
html,
body,
.box h2,
.info-row > .title{
	color:<?=$text_colour;?>;
}

#nav-wrap{
	background-color:<?=$primary_colour?>;
    border-bottom:1px solid <?=$primary_colour?>;
}
.top-nav > li > a:hover{
	background-color:<?=$rollover_colour?>;
}
.top-nav > li > a{
	color:<?=$secondary_colour?>;
}


a,
.action_image,
.text-blue,
.profile-menu ul li a{
	color:<?=$primary_colour?>;
}
a:hover,
.profile-menu ul li a:hover,
.action_image :hover{
	color:<?=$rollover_colour?>;
}
.btn-info{
	background-color:<?=$primary_colour?> !important;
    color:<?=$secondary_colour?>;
}
.btn-info:hover{
	background-color:<?=$rollover_colour?> !important;
    color:<?=$secondary_colour?>;
}
.btn-core{
	background:<?=$primary_colour?>;
    color:<?=$secondary_colour?>;
}
.btn-core:hover{
	background:<?=$rollover_colour?>;
    color:<?=$secondary_colour?>;
}
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
	background:<?=$primary_colour?>;
    border-color:<?=$primary_colour?>;
}
.select2-results .select2-highlighted{
	background:<?=$rollover_colour?>;
}
.modal-body-title, .modal-title{
	color:<?=$primary_colour?>;
}
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
	color:<?=$secondary_colour?>;
}
.editable-click, a.editable-click{
	color:<?=$primary_colour?>;
}
a.editable-click:hover{
	color:<?=$rollover_colour?>;
}
.nav-tabs > li a, .nav-tabs > li a:hover{
	color:<?=$secondary_colour?>;
}


