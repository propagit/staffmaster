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
			<!-- <span class="btn btn-core pull-right visible-md visible-lg add-left-margin"><i class="fa fa-print"></i> Print Rosters</span> -->
			<span class="btn btn-core pull-right hidden-xs add-left-margin"><i class="fa fa-envelope-o"></i> Email Rosters</span>
			<!-- <span class="btn btn-core pull-right visible-md visible-lg"><i class="fa fa-download"></i> Download Rosters</span> -->
		</div>
		
		<div id="nav_rosters">
			<?
				$data = array(
					array('value' => 'confirm', 'label' => '<i class="fa fa-thumbs-o-up"></i> Confirm Selected'),
					array('value' => 'reject', 'label' => '<i class="fa fa-thumbs-o-down"></i> Reject Selected')
				);
				echo modules::run('common/menu_dropdown', $data, 'roster-action', 'Actions');
			?>
			<div class="btn-group btn-nav tab-respond">
				<ul class="nav nav-tabs tab-respond">
					<? foreach($months as $month) { ?>
					<li<?=($month == strtotime($active_month)) ? ' class="active"' : '';?>><a onclick="load_month_rosters(this,<?=$month;?>)"><?=date('M Y', $month); ?></a></li>
					<? } ?>
				</ul>
			</div>
		</div>
		<div id="list_rosters" class="clear"></div>
	</div>
	</div>
</div>


<script>
$(function(){
	load_rosters();
})

function load_rosters() {
	preloading($('#list_rosters'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>roster/ajax/load_rosters",
		success: function(html) {
			loaded($('#list_rosters'),html);
		}
	})
}
function load_month_rosters(obj,ts) {
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