<div class="col-md-12">
	<div class="box top-box">
		<h2>Apply For Work</h2>
		<p>Below you will find a range of jobs that are are currently available. Please apply for any job you would like to work on. Applying for a job doesn’t mean you are automatically placed to work on that shift. Please check your roster to see what jobs you are working on.</p>
	</div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
    		<div id="nav_works">
    			<?
    				if (count($months) > 0) {
    					$data = array(
    						array('value' => 'apply', 'label' => '<i class="fa fa-thumbs-o-up"></i> Apply Selected')
						);
    					echo modules::run('common/menu_dropdown', $data, 'work-action', 'Actions');
    				}
    			?>
    			<div class="btn-group btn-nav tab-respond">
    				<ul class="nav nav-tabs tab-respond">
						<? foreach($months as $month) { ?>
						<li<?=($month == strtotime($active_month)) ? ' class="active"' : '';?>><a onclick="load_month_works(this,<?=$month;?>)"><?=date('M Y', $month); ?></a></li>
						<? } ?>
					</ul>
    			</div>
    		</div>
			
			<div id="list_works" class="clear"></div>
		</div>
	</div>
</div>


<script>
$(function(){
	load_works();
	$('#menu-work-action ul li a[data-value="apply"]').click(function(){
		var selected_shifts = new Array();
		$('.select_shift:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		apply_shifts(selected_shifts);
	});
	
})

function load_works() {
	preloading($('#list_works'));
	$.ajax({
		url: "<?=base_url();?>work/ajax/load_works",
		success: function(html) {
			loaded($('#list_works'), html);
		}
	})
}
function load_month_works(obj, ts) {
	$(obj).parent().parent().find('li').removeClass('active');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>work/ajax/load_month_works",
		data: {ts: ts},
		success: function(data) {
			$(obj).parent().addClass('active');
			load_works();
		}
	})
}
</script>