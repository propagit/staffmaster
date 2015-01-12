<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Approve Time Sheets</h2>
		<p>The below time time sheets need to be approved before being submitted to payroll. Start times, finish times, breaks and 
expenses can be edited by clicking on them. Please amend the timesheet to be correct or provide a reason for rejecting the time sheet </p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">

                <div id="wrapper_ts">
                    <!-- Filter Menus -->
                    <div id="menu-timesheet-action">
                        <?
                            $data = array(
                                array('value' => 'approve', 'label' => '<i class="fa fa-arrow-right"></i> Approve Selected')
                            );
                            echo modules::run('common/menu_dropdown', $data, 'menu-timesheet-action', 'Actions');
                        ?>		
                    </div><!-- End Filter Menus -->
                    <table class="table table-bordered table-hover table-middle" width="100%">
                        <thead>
                            <th class="center" width="20"><input type="checkbox" class="selected_all_timesheets" /></th>
                            <th class="center">Date</th>
                            <th>Client</th>
                            <th>Venue</th>
                            <th>Staff</th>
                            <th class="center">Start - Finish</th>
                            <th class="center">Break</th>
                            <th class="center">Pay rate</th>
                            <th class="center">Expenses</th>
                            <th class="center" width="40">View</th>
                            <th class="center" width="140">Approve</th>
                            <th class="center" width="140">Reject</th>
                        </thead>
                        <tbody>
                            <? foreach($timesheets as $timesheet) { 
                                    $data['timesheet_id'] = $timesheet['timesheet_id'];
                                    $this->load->view('public/timesheet/timesheet_row_view',$data);
                            } ?>
                        </tbody>
                    </table>
                    </div>
                    <div id="wrapper_ts_break" class="hide"></div>
                    <div id="wrapper_ts_payrate" class="hide"></div>
                    <div id="wrapper_ts_staff" class="hide"></div>
                </div>
			
		</div>
	</div>
</div>

<?php $this->load->view('public/timesheet/reject_modal_view');?>

<script>
$(function(){
	
	init_edit();
	$('#menu-timesheet-action ul li a[data-value="approve"]').click(function(){
		var selected_timesheets = new Array();
		$('.selected_timesheet:checked').each(function(){
			//selected_timesheets.push($(this).val());
			approve_timesheet($(this).val());
		});
	});
	
	// approve
	$('.approve').click(function(){
		approve_timesheet($(this).attr('data-ts'));
	});
	
	//reject
	$('.reject').click(function(){
		var $this = $(this);
		var ts_id = $this.attr('data-ts');
		$('#ts-id').val(ts_id);
		$('#reject-timesheet-modal').modal('show');
	});
	
	
	
	
	
});//ready


function init_edit() {
	$('.selected_all_timesheets').click(function(){
		$(this).parent().parent().parent().parent().find('input.selected_timesheet').prop('checked', this.checked);		
	});
	
	$('.ts_start_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
		url: '<?=base_url();?>pts/update_timesheet_start_time',
        success: function(response, newValue) {
	        if (response.status == 'error') {
				return response.msg;
			}
			else {
				refrest_timesheet($(this).attr('data-pk'));
			}
        }
    });
    $('.ts_finish_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
        url: '<?=base_url();?>pts/update_timesheet_finish_time',
        success: function(response, newValue) {
	        if (response.status == 'error') {
				return response.msg;
			}
			else {
				refrest_timesheet($(this).attr('data-pk'));
			}
        }
    });

	var tmp = $.fn.popover.Constructor.prototype.show;
	$.fn.popover.Constructor.prototype.show = function () {
	  tmp.call(this);
	  if (this.options.callback) {
	    this.options.callback();
	  }
	}
	$('.ts_breaks').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Break',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_ts_break').html();
		}
	});
	$('body').on('click', function (e) {
	    $('[data-toggle=popover]').each(function () {
	        // hide any open popovers when the anywhere else in the body is clicked
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	            $(this).popover('hide');
	        }
	    });
    });
	
}
function approve_timesheet(ts_id){
	  $.ajax({
		  type: "POST",
		  url: "<?=base_url();?>pts/ap_ts",
		  data: {ts_id: ts_id,ts_k:'<?=$key;?>',us_tp:'<?=$key_type?>'},
		  success: function(html) {
			  if(html == 'ok'){
				  $('#ts-r-'+ts_id).remove();
			  }
		  }
	  });
}
function refrest_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>pts/refresh_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			$('#ts-r-' + timesheet_id).replaceWith(html);
			init_edit();
		}
	})
}
function load_ts_breaks(obj) {
	$('#wrapper_ts_break').html('');
	$('#wrapper_ts').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>pts/load_ts_breaks",
		data: {pk: pk},
		success: function(html) {
			$('#wrapper_ts_break').html(html);
		}
	}).done(function(){
		$(obj).popover('show');
		$('.break-add').click(function(){
			var list_breaks = $(this).parent().find('#list-breaks');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>pts/add_ts_break",
				data: {pk: pk},
				success: function(html) {
					$(list_breaks).append(html);
				}
			})			
		});		
		$('.break-submit').click(function(){
			$.ajax({
		    	type: "POST",
		    	url: "<?=base_url();?>pts/update_ts_breaks",
		    	data: $('#form_update_ts_breaks').serialize(),
				success: function(data) {
					data = $.parseJSON(data);
					if (!data.ok) {	
						$('.editable-breaks').each(function(i,obj) {
							$(obj).removeClass('has-error');
							if (i== data.number) {
								$(obj).addClass('has-error');
							}
						});
					}
					else {
						$('.ts_breaks').popover('hide');
						refrest_timesheet(pk);
					}
					
				}			
			})
		})
		$('.break-cancel').click(function(){
			$('.ts_breaks').popover('hide');
		})
	})
}
</script>
	