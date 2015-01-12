<div id="reject-timesheet-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Reject Time Shift</h4>
            </div>
            <div class="col-md-12">			
                <div class="modal-body modal-form">
    				  <h4 class="modal-title">Why are you rejecting this timesheet?</h4>
                      <p>
                      	If it is just the start time, finish time or break leangth then please edit the time sheet and approve it to payroll
                      </p>
                      <form id="reject-timesheet-form">
                            <div class="form-group editor-wrap">
                                 <div class="col-sm-12 remove-gutters">
                                     <textarea class="form-control" name="reject_note" placeholder="Please provide a reason for rejecting this timesheet" rows="6"></textarea> 
                                 </div>
                             </div>
   
                             <div class="form-group editor-wrap">
                                 <div class="col-sm-12 remove-gutters">
                                     <button type="button" class="btn btn-info" id="confirm-reject"><i class="fa fa-times"></i> Reject Shift</button>
                                 </div>
                             </div>
                           	 <input type="hidden" name="ts_id" id="ts-id" value="0">
                             
                              <div class="form-group add-top-margin-20 hide"  id="error-rejecting-shift">
                                  <div class="col-sm-6 remove-gutters">
                                       <div class="alert alert-danger"><i class="fa fa-times"></i> &nbsp; <span id="reject-error-msg"></span></div>
                                  </div>
                             </div>
                      </form>
    
     
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
$(function(){
	$('#confirm-reject').click(function(){
		var ts_id = $('#ts-id').val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>pts/rj_ts",
			data: $('#reject-timesheet-form').serialize(),
			success: function(html) {
				if(html == 'ok'){
					$('#ts-r-'+ts_id).remove();
					$('#reject-timesheet-modal').modal('hide');
				}else{
					$('#reject-error-msg').html(html);
					$('#error-rejecting-shift').removeClass('hide');
					setTimeout(function(){
						$('#error-rejecting-shift').addClass('hide');
					}, 2000);
				}	
			}
		})
	});
});//ready
</script>