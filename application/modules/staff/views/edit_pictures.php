<div class="staff-profile-detail-box">
	<h2> Your Images </h2>
	<p> Upload photos of yourself so we have a visual refferance of you. 
	<br />Set your <b>primary profile image</b> by rolling over the images in your gallery and clicking the <i class="fa fa-heart"></i>
	<br />To <b>delete images</b>  roll over one of the images in your gallery and click the <i class="fa fa-times"></i>                        	
	</p>
</div>


<button type="button" class="btn btn-info" onclick="$('#addImage').modal('show');"><i class="fa fa-upload"></i> Upload Image</button>
<br /><br />

<div id="picture_photo"></div>


<!-- Add Venue Modal -->
<div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="addImageLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add Venue</h4>
			</div>
            <div class="col-md-12">
                <div class="modal-body">
                	<?=modules::run('staff/form_upload_photo', $staff['user_id']);?>
                </div>
            </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
$(function(){
	load_picture(<?=$staff['user_id']?>);
});
function load_picture(user_id)
{
	preloading($('#picture_photo'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/load_picture",
		data: {user_id: user_id},
		success: function(html) {			
			loaded($('#picture_photo'), html);
		}
	})
}
</script>