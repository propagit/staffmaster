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


<!-- Add Staff Picture Modal -->
<div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="addImageLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add Photo</h4>
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

function update_avatar(user_id)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>staff/ajax/reload_avatar',
		data:{user_id:user_id},
		success: function(html) {
			$('#profile-bar-avatar').html(html);
		}
	});		
}

function set_hero(photo_id)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>staff/ajax/set_hero_photo',
		data:{user_staff_picture_id:photo_id,user_id:<?=$staff['user_id'];?>},
		success: function(html) {
			update_avatars();
		}
	});		
}
function uset_hero(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>staff/ajax/unset_hero_photo',
		data:{user_id:<?=$staff['user_id'];?>},
		success: function(html) {
			update_avatars();
		}
	});	
}
function update_staff_edit_page_avatar(user_staff_id)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>staff/ajax/reload_staff_edit_page_avatar',
		data:{user_id:user_staff_id},
		success: function(html) {
			$('#staff-edit-page-avatar').html(html);
		}
	});	
}
function delete_photo(photo_id){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>staff/ajax/delete_photo',
		data:{photo_id:photo_id},
		success: function(html) {
			update_avatars();
		}
	});	 
}

function update_avatars()
{
	load_picture(<?=$staff['user_id'];?>);
	update_avatar(<?=$staff['user_id'];?>);
	update_staff_edit_page_avatar(<?=$staff['user_id'];?>);	
}

function respond_staff_profile_pictures()
{
	var ideal_width = 1715;
	var profile_pic_fallback_width = 285;
	var innerbox_width = $('.inner-box').width();
	var gallery_width = '';
	if(innerbox_width < 1715){
		if(innerbox_width < 886){
			gallery_width = '';
		}else{
			gallery_width = innerbox_width - (profile_pic_fallback_width);
		}
	}else{
		profile_pic_fallback_width = '';	
	}
	
	
	$('.staff-profile-hero-wrap').css({'width':profile_pic_fallback_width});
	$('.staff-profile-gallery-wrap').css({'width':gallery_width});	
}
</script>