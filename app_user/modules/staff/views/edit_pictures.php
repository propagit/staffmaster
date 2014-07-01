<div class="staff-profile-detail-box">
	<h2> Your Pictures</h2>
	<p>Upload photos of yourself so we have a visual reference of you.
	<br />Set your <b>primary profile photo</b> by rolling over the images in your gallery and clicking the <i class="fa fa-heart"></i>
	<br />To <b>delete images</b>  roll over one of the images in your gallery and click the <i class="fa fa-times"></i></p>
</div>

<div id="filelist"><!-- Your browser doesn't have Flash, Silverlight or HTML5 support. --></div>
<div class="progress progress-striped active" style="visibility: hidden;">
	<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="upload-progress">0%</div>
</div>
<div id="upload_container">
    <button type="button" id="pickfiles" href="javascript:;" class="btn btn-core">Select files</button>
    <button type="button" id="uploadfiles" href="javascript:;" class="btn btn-core"><i class="fa fa-upload"></i> Upload files</button>
    <span id="console"></span>
</div>

<br /><br />

<div id="picture_photo"></div>


<script>
$(function(){
	load_picture();
});
function load_picture()
{
	preloading($('#picture_photo'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/load_picture",
		data: {user_id: <?=$staff['user_id']?>},
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
	load_picture();
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

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('upload_container'), // ... or DOM Element itself
	url : '<?=base_url();?>staff/ajax/upload_picture/<?=$staff['user_id'];?>',
	chunk_size: '400kb',
    max_retries: 5,
	flash_swf_url : '<?=base_url();?>assets/js/plupload/Moxie.swf',
	silverlight_xap_url : '<?=base_url();?>assets/js/plupload/Moxie.xap',

	filters : {
		max_file_size : '20mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"}
		]
	},

	init: {
		PostInit: function() {
			$('#console').html('');
			$('#filelist').html('');
			$('#uploadfiles').click(function() {
				uploader.start();
				return false;
			});
		},

		FilesAdded: function(up, files) {
			$('#upload-progress').parent().css("visibility", "visible");

			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$('#upload-progress').attr('aria-valuenow', 60);
			$('#upload-progress').css("width", file.percent + "%");
			$('#upload-progress').html(file.percent + '% completed');
		},
		UploadComplete: function() {
			// reload photos
			$('#upload-progress').parent().css("visibility", "hidden");
			$('#upload-progress').css("width", "0%");
			$('#upload-progress').html('0%');
			$('#console').html('');
			$('#filelist').html('');
			load_picture();
		},

		Error: function(up, err) {
			$('#console').html('\n&nbsp;<span class="text-danger">Error: ' + err.message + '</span>');
		}
	}
});

uploader.init();
</script>