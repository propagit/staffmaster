<div class="col-md-12">
	<div class="box top-box">
		<h2>Your Roster</h2>
	<p>Your roster is displayed below. Please confirm or reject shifts we have planned for you. Please read the job details carefully and check back regularly for updates to your roster.</p>
	</div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
		<div class="table_action">		
			<span class="btn btn-core pull-right visible-md visible-lg"><i class="fa fa-print"></i> Print Rosters</span>
			<span class="btn btn-core pull-right hidden-xs"><i class="fa fa-envelope-o"></i> Email Rosters</span>
			<span class="btn btn-core pull-right visible-md visible-lg"><i class="fa fa-download"></i> Download Rosters</span>
			<ul class="nav nav-tabs nav-action">
				<li class="dropdown">
					<a id="multi-rosters" class="dropdown-toggle" data-toggle="dropdown" href="#">Action <b class="caret"></b></a>
					<ul class="dropdown-menu" aria-labelledby="multi-rosters" role="menu">
						<li><a class="multi_confirm">Confirm Selected</a></li>
						<li><a class="multi_reject">Reject Selected</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav nav-tabs">
				<? foreach($months as $month) { ?>
				<li<?=($month == strtotime($active_month)) ? ' class="active"' : '';?>><a onclick="load_month_rosters(this,<?=$month;?>)"><?=date('M Y', $month); ?></a></li>
				<? } ?>
			</ul>
		</div>
		
		<div id="list_rosters" class="clear"></div>
	</div>
	</div>
</div>


<script>
$(function(){
	load_rosters();
})

function load_rosters()
{
	preloading($('#list_rosters'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>roster/ajax/load_rosters",
		success: function(html) {
			loaded($('#list_rosters'),html);
		}
	})
}
function load_month_rosters(obj,ts)
{
	$(obj).parent().parent().find('li').removeClass('active');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>roster/ajax/load_month_rosters",
		data: {ts:ts},
		success: function(data) {
			$(obj).parent().addClass('active');
			load_rosters();
		}
	})
}
</script>