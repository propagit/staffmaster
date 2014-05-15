<?php
echo header('Content-type: text/css');
$primary_colour = $styles['primary_colour'];
$secondary_colour = $styles['secondary_colour'];
$rollover_colour = $styles['rollover_colour'];
$text_colour = $styles['text_colour'];

$primary_rgb = modules::run('custom_styles/hex_2_rgb',$primary_colour);
$secondary_rgb = modules::run('custom_styles/hex_2_rgb',$secondary_colour);
$rollover_rgb = modules::run('custom_styles/hex_2_rgb',$rollover_colour);
$text_rgb = modules::run('custom_styles/hex_2_rgb',$text_colour);
?>
html,
body,
.box h2,
.info-row > .title{
	color:<?=$text_colour?>;
}
.box h2.s30{
	color:<?=$text_colour?>;
}
a,
.forgot-password,
.action_image,
.text-blue,
.profile-menu ul li a{
	color:<?=$primary_colour?>;
}
a:hover,
.forgot-password:hover,
.profile-menu ul li a:hover,
.action_image :hover{
	color:<?=$rollover_colour?>;
}

/* 	navs */

#nav-wrap{
	background-color:<?=$primary_colour?>;
    border-bottom:1px solid <?=$primary_colour?>;
}
.top-nav > li > a:hover{
	background-color:<?=$primary_colour?>;
}
.top-nav > li > a{
	color:<?=$secondary_colour?>;
}

.btn-info,
.btn-core{
	background-color:<?=$primary_colour?> !important;
    color:<?=$secondary_colour?>;
}
.btn-info:hover,
.btn-core:hover{
	background-color:<?=$primary_colour?> !important;
    color:<?=$secondary_colour?>;
}
.nav-tabs > li.active a:hover,
.nav-tabs > li.active a,
.nav-tabs > li.active a:focus {
	background-color:<?=$primary_colour?>;
    border-color:<?=$primary_colour?> !important;
    color:<?=$secondary_colour?> !important;
}
.nav-tabs li a{
	color:<?=$text_colour?> !important;
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

.sample-email-btn{
	background-color:<?=$primary_colour?>;
    color:<?=$secondary_colour?>;
}
.sample-email-btn:hover{
	background-color:<?=$primary_colour?>;
    color:<?=$secondary_colour?>;
}
span.mob-menu-head{
	color:<?=$secondary_colour?>;
}
.btn-navbar .fa{
	color:<?=$secondary_colour;?>
}

/* select 2 */

.select2-results .select2-highlighted{
	background:<?=$primary_colour?>;
}

/* modal */

.modal-body-title, .modal-title{
	color:<?=$text_colour?>;
}

/* avatar picture */

.default-profile-photo,
.default-avatar-photo > .fa{
	color:<?=$primary_colour?>;
}

/* brief */
.brief-func-dl dd{
	color:<?=$primary_colour?>;
}
.brief-func-dl dd:hover{
	color:<?=$rollover_colour?>;
}

/* invoice */
.wp-page-invoice,
.wp-page-invoice h1,
.wp-page-invoice h2,
.brief-table, .brief-body h1, .brief-body p{
	color:<?=$text_colour?>;
}
.charge-box-header,
.wp-page-invoice .charge-box-header{
	background:<?=$primary_colour?>;
    color:<?=$secondary_colour?>;
}

.email-brief,
.grey-text{
	color:<?=$primary_colour?>;
}
.email-brief:hover,
.grey-text:hover{
	color:<?=$rollover_colour?>;
}
.staff-submit,
.break-submit,
.editable-submit{
	background-color:<?=$primary_colour?>;
	border:1px solid <?=$primary_colour?>;
    color:<?=$secondary_colour?>;
}
.staff-submit:hover,
.break-submit:hover,
.editable-submit:hover{
	background-color:<?=$primary_colour?>;
	border:1px solid <?=$primary_colour?>;
    color:<?=$secondary_colour?>;
    background-image:none;
}
#sm-footer-wrap,
.footer-go-to-top-btn{
	background-color:rgba(<?=implode(',',$primary_rgb)?>,0.25);
}
.footer-go-to-top-arrow{
	color:<?=$secondary_colour?>;
}
.box_credits .title_bc{
	background:<?=$primary_colour?>;
}

/* primary color overwritten with text color, mostly where anchor color needs to be ovewriten */
.update_link, 
.prim-color-to-txt-color{
	color:<?=$text_colour?> !important;
}
.update_link:hover,
.prim-color-to-txt-color:hover{
	color:<?=$rollover_colour?> !important;
}

/* pagination  */
.custom-pagination > .active > a,
.custom-pagination > .active > a:focus,
.custom-pagination > .active > a:hover{
	background-color:<?=$primary_colour?>;
    border-color:<?=$primary_colour?>;
}

