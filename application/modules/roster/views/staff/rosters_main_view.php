<div class="box">
	<h2>Your Roster</h2>
	<p>Your roster is displayed below. Please confirm or reject shifts we have planned for you. Please read the job details carefully and check back regularly for updates to your roster.</p>
</div>

<div class="box">
	<div class="table_action">		
		<span class="btn btn-core pull-right visible-md visible-lg"><i class="fa fa-print"></i> Print Rosters</span>
		<span class="btn btn-core pull-right hidden-xs"><i class="fa fa-envelope-o"></i> Email Rosters</span>
		<span class="btn btn-core pull-right visible-md visible-lg"><i class="fa fa-download"></i> Download Rosters</span>
		<ul class="nav nav-tabs">
			<? foreach($months as $month) { ?>
			<li<?=($month == strtotime($active_month)) ? ' class="active"' : '';?>><a onclick="load_month_rosters(this,<?=$month;?>)"><?=date('M Y', $month); ?></a></li>
			<? } ?>
		</ul>
	</div>
	
	<div id="list_rosters" class="clear"></div>
	
</div>

<script>
$(function(){
	load_rosters();
})

function load_rosters()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>roster/ajax/load_rosters",
		success: function(html) {
			$('#list_rosters').html(html);
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