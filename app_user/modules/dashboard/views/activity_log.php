<h2>Activity Log</h2>
<p>Your activity log will inform you of important activities and iterations from your users.</p>
<? if (count($logs) > 0) { ?>
<div id="activity_lists" class="clear">
	<div id="wrapper-outer">
		<div id="wrap-list">
		<? foreach($logs as $log) { ?>
			<div class="row">
				<div class="col-md-1 col-xs-1 wrap-list-date">                        
					<span class="wk_date"><?=date('d', strtotime($log['created_on']));?></span>
					<span class="wk_month"><?=date('M', strtotime($log['created_on']))?></span>
				</div>
				<div class="col-md-10 col-xs-8 wrap-list-activity">
					<?=modules::run('log/display_notification', $log);?>
				</div>
			</div>
		<? } ?>
		</div>
	</div>
</div>            
<? } else { ?>
<div class="alert alert-warning">No activity log</div>
<? } ?>