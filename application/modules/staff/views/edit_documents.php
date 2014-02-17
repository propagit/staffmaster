<script src="<?=base_url();?>assets/js/fileupload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url();?>assets/js/fileupload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url();?>assets/js/fileupload/js/jquery.fileupload.js"></script>
<div class="staff-profile-detail-box">
	<h2> Documents </h2>
	<p> Staff can choose the "Documents" </p>
</div>
<div class="col-md-12">
<form class="form-horizontal" role="form" id="staff-custom-attributes-form" enctype="multipart/form-data">
<input type="hidden" name="user_staff_id" value="<?=$staff['user_id'];?>" />
	<?=modules::run('formbuilder/custom_file_uploads_for_staff_profile',$staff['user_id']);?>
    <div class="row">
	<div class="form-group">
		<div class="col-md-12">
			<div class="alert alert-success hide" id="msg-update-custom-attributes"><i class="fa fa-check"></i> &nbsp; Custom attributes successfully updated</div>
		</div>
	</div>
</div>
</form>
<div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
</div>
</div>
<script>
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = <?=base_url();?>'staff/ajax';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>