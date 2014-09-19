<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-activityLogs"></i> &nbsp; Activity Logs</h2>
    	 <p>You can find all records of your activities on the system.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <? foreach($dates as $date) { 
	            $logs = modules::run('log/get_logs_by_date', $date['date']);
            ?>
            <div class="row">
            	<div class="col-md-1"><?=date('d-M-Y', strtotime($date['date']));?></div>
            	<div class="col-md-11">
            		<table class="table table-condensed table-middle">
	            	<? foreach($logs as $log) { ?>
            		<tr><td>
	            	<?=modules::run('log/display', $log);?>
            		</td></tr>
	            	<? } ?>
            		</table>
            	</div>
            </div>
            <? } ?>          
        </div>
    </div>
</div>
<!--end bottom box -->