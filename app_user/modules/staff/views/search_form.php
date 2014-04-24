<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<?=modules::run('wizard/main_view', 'staff');?>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Search Staff</h2>
		 <p>Browse and search our staff profiles below.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Staff Attributes</h2>
		 	<br />            
			<form class="form-horizontal" id="form_search_staffs" role="form">
			<div class="row">
				<div class="form-group">
					<label for="staff_name" class="col-md-2 control-label">Name (Keyword):</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="keyword" name="keyword" tabindex="2" />
					</div>
					<? if (!$is_client) { ?>
					<label for="rating" class="col-md-2 control-label">Rating</label>
					<div class="col-md-4">
                        <?=modules::run('common/field_rating', 'rating', 0,'basic-search-form','wp-rating-0','no-user',false,false);?>
					</div>
					<? } ?>
				</div>
			</div>
						
			<? if (!$is_client) { ?>
			<div class="row">
				<div class="form-group">
					<label for="department_id" class="col-md-2 control-label">Group</label>
					<div class="col-md-4">
						<?=modules::run('attribute/group/field_select', 'group_id');?>
					</div>
					<label for="status" class="col-md-2 control-label">Status</label>
					<div class="col-md-4">
						<?=modules::run('staff/field_select_status', 'status');?>
					</div>
				</div>
			</div>
			<? } ?>
			<div class="row">
				<div class="form-group">
					<label for="state" class="col-md-2 control-label">State</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_states', 'state');?>
					</div>
					<label for="gender" class="col-md-2 control-label">Gender</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_genders', 'gender');?>
					</div>
				</div>
			</div>
            <div class="row">
				<div class="form-group">
					<label for="location" class="col-md-2 control-label">Availability</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select',$weekdays, 'availability');?>
					</div>
					<label for="position" class="col-md-2 control-label">Age</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select',$age_groups, 'age_groups');?>
					</div>
				</div>				
			</div>
			<div class="row">
				<div class="form-group">
					<label for="location" class="col-md-2 control-label">Location</label>
					<div class="col-md-4">
						<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
					</div>
					<label for="position" class="col-md-2 control-label">Role</label>
					<div class="col-md-4">
						<?=modules::run('attribute/role/field_select', 'role_id');?>
					</div>
				</div>				
			</div>
            
			<? if (!$is_client) { ?>
            <div class="row">
				<div class="form-group">
					<label for="date_from" class="col-md-2 control-label">Worked From</label>
					<div class="col-md-4">
						<div class="input-group date" id="date_from">
							<input type="text" class="form-control" name="date_from" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
					<label for="date_to" class="col-md-2 control-label">Worked To</label>
					<div class="col-md-4">
						<div class="input-group date" id="date_to">
							<input type="text" class="form-control" name="date_to" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>
			</div>
            <? } ?>
            
            <div class="row">
				<div class="form-group">
					<label for="location" class="col-md-2 control-label">Time Sheet in Payrun</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_yes_no','timesheet_in_payrun');?>
					</div>
				</div>				
			</div>
            
            <div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
                    	<a class="toggle-custom-attrs"><i id="toggle-custom-attrs-fa" class="fa fa-plus-square"></i> Custom Attributes</a>
					</div>
				</div>
			</div>
            
            <div id="custom-attr-search" class="custom-hidden">
            	<?=modules::run('staff/custom_attributes');?>
            </div>
            
			<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
						<button type="button" class="btn btn-core" id="btn_search_staffs"><i class="fa fa-search"></i> Search Staff</button>
						&nbsp;
						<button type="reset" id="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset Form</button>
					</div>
				</div>
			</div>
            
          
            
            			
			<input type="hidden" name="sort_by" id="sort-by" value="first_name" />
            <input type="hidden" name="sort_order" id="sort-order" value="asc" />
            <input type="hidden" name="current_page"  id="current_page" value="1"  />
			</form>
			
			<div id="staffs_search_results"></div>
		</div>
	</div>
</div>
<!--end bottom box -->


<!-- Multi Rating Modal-->
<div class="modal fade" id="updateMultiRating" tabindex="-1" role="dialog" aria-labelledby="updateRatingLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Update Selected Rating</h4>
			</div>
			<form id="add-new-venue-form">
            <div class="col-md-12">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ratings</label>
                        <div class="col-sm-10">
                            <?=modules::run('common/field_rating', 'rating_multiple', 5,'basic-staff-multi-rating','wp-rating-multi','no-user',false,false);?>
                        </div>
                    </div>
                    
                   
                     <div class="form-group">
                               <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                          <div class="col-sm-10">
                              <button onclick="update_multiple_selected_rating();" type="button" class="btn btn-info"><i class="fa fa-save"></i> Update Ratings</button>
                          </div>
                      </div>
                </div>
            </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Multi Status Modal-->
<div class="modal fade" id="updateMultiStatus" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Update Selected Status</h4>
			</div>
			<form id="add-new-venue-form">
            <div class="col-md-12">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <?=modules::run('staff/field_select_status', 'multi_status_update');?>
                        </div>
                    </div>
                    
                   
                     <div class="form-group">
                               <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                          <div class="col-sm-10">
                              <button onclick="update_multiple_selected_status();"  type="button" class="btn btn-info"><i class="fa fa-save"></i> Update Status</button>
                          </div>
                      </div>
                </div>
            </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="ajax-contact-staff-modal"></div>

<script>
var scroll_to_form = true;
$(function(){
	$('#date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
    
	//reset ratings
	$('#reset').click(function(){
		reset_page();
	});
	
	
	$('#btn_search_staffs').click(function(){
		reset_page();
		search_staffs();
		scroll_to_form = true;
	})
	
	//prevent form sumbit on enter and instead do ajax search
	$('#form_search_staffs').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
			e.preventDefault();
			reset_page();
			search_staffs();
		  }
	});
	
	//toggle custom attr search
	$('.toggle-custom-attrs').on('click',function(){
		$('#custom-attr-search').toggle();
		if($('#toggle-custom-attrs-fa').hasClass('fa-plus-square')){
			$('#toggle-custom-attrs-fa').removeClass('fa-plus-square').addClass('fa-minus-square');	
		}else{
			$('#toggle-custom-attrs-fa').removeClass('fa-minus-square').addClass('fa-plus-square');	
		}
	});
	
	//send email
	$(document).on('click','.send-email-from-modal',function(){
		send_email();
	});

})

function reset_page()
{
	$('.basic-search-form .jRatingAverage').css({'width':0});
	$('#rating').val(0);
	reset_current_page();
}

function search_staffs() {
	preloading($('#staffs_search_results'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/search_staffs",
		data: $('#form_search_staffs').serialize(),
		success: function(html) {
			loaded($('#staffs_search_results'), html);
			if(scroll_to_form){
				setTimeout(function(){
					$('body').scrollTo('#form_search_staffs', 800 );
				},200);
			} 
		}
	})
}
function delete_staff(user_id){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/delete_staff",
		data: {user_id:user_id},
		success: function(html) {
			$('#search-result-tr-'+user_id).remove();
		}
	})
}
function perform_multi_update(action){
	switch(action){
		case 'contact-multi-staff':
			contact_multi_staff();	
		break;
		case 'delete-multi-staff':
			delete_multi_staff();
		break;
		case 'update-multi-rating':
			$('#updateMultiRating').modal('show');
		break;
		case 'change-multi-status':
			$('#updateMultiStatus').modal('show');
		break;
		case 'export':
			export_staff();
		break;	
	}
}

function delete_multi_staff(){
		var title = 'Delete Staff';
		var message ='Are you sure you would like to delete these "Staff"';
		var user_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				$.ajax({
						type: "POST",
						url: "<?=base_url();?>staff/ajax/delete_multi_staffs",
						data: $('#staff-search-results-form').serialize(),
						success: function(html) {
							reset_page();
							search_staffs();
						}
					});
			 }
		});
}

function update_multiple_selected_rating()
{
	var new_rating = $('#rating_multiple').val();
	$('#staff-search-results-form').append('<input type="hidden" name="multi_rating" value="'+new_rating+'" />');
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>staff/ajax/update_rating_multi_staffs",
		  data: $('#staff-search-results-form').serialize(),
		  success: function(html) {
			  $('#updateMultiRating').modal('hide');
			  reset_page();
			  search_staffs();
		  }
	  }); 
}


function update_multiple_selected_status()
{
	var new_status = $('#multi_status_update').val();
	$('#staff-search-results-form').append('<input type="hidden" name="new_multi_status" value="'+new_status+'" />');	
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>staff/ajax/update_status_multi_staffs",
		  data: $('#staff-search-results-form').serialize(),
		  success: function(html) {
			  $('#updateMultiStatus').modal('hide');
			  reset_page();
			  search_staffs();
		  }
	  });
}

function contact_multi_staff(){
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/get_send_email_modal",
		  data: $('#staff-search-results-form').serialize(),
		  success: function(html) {
			  $('#ajax-contact-staff-modal').html(html);
			  $('#email-modal').modal('show');	
		  }
	  });
		
}

function export_staff() {
	var selected_staff = new Array();
	$('.checkbox-multi-action:checked').each(function(){
		selected_staff.push($(this).val());
	});
	$('.bs-modal-lg').modal({
		remote: "<?=base_url();?>staff/ajax/load_export_modal/" + selected_staff.join("~"),
		show: true
	});
}

function send_email()
{
	//update_ckeditor() function in send_email_modal view file
	preloading($('#send-email-modal-window'));
	update_ckeditor();
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>staff/ajax/send_email",
		  data: $('#send-email-modal-form').serialize(),
		  success: function(html) {
		    $('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);	
			setTimeout(function(){
				$('#email-modal').modal('hide');
			}, 4000);	
		  }
	  });	
}

</script>