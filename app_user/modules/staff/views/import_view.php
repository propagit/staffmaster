<?=modules::run('wizard/main_view', 'staff');?>

<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Import Staff</h2>
    	 <p>To import your staff, download the <a href="<?=base_url();?>assets/sample_docs/StaffImport.csv">Sample File</a> and open it in a program such as Microsoft Excel. Enter your own information and save the file as a .csv then click the upload file button.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <ul class="nav nav-tabs tab-respond">
            	<li class="pull-right"><a href="<?=base_url();?>staff/add">Add Staff</a></li>
				<li class="mobile-tab active"><a>Import Multiple Staff</a></li>
			</ul>
			<br />
			<h2>Select File</h2>
			<br />
			<form class="form-inline" role="form" id="upload-staff-csv-form" enctype="multipart/form-data" action="<?=base_url();?>staff/ajax_import/upload_csv" method="POST">
			<div class="pull-left">
				<div class="fileupload fileupload-staff" data-provides="fileupload" >        
					<span class="btn btn-file">
						<i class="fa fa-paperclip"></i>
						<span class="fileupload-new"> Attach File</span>
						<span class="fileupload-exists">Change</span>         
						<input type="file" name="userfile"/>
					</span>
					<span class="fileupload-preview"></span> &nbsp; 
					<a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i> &nbsp; </a>
				</div>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-core btn-block" id="btn-upload-staff-csv"><i class="fa fa-upload"></i> Upload</button>
			</div>
			<div class="clearfix"></div>
			<div class="alert alert-danger hide" id="upload-result"></div>
			</form>
			
			<hr />
			<div id="wp-configure-import" class="tab-export"></div>
        </div>
    </div>
</div>
<!--end bottom box -->

<script>
$(function(){
	$('#btn-upload-staff-csv').click(function(){
		$('#upload-staff-csv-form').ajaxSubmit(function(json){
			json = $.parseJSON(json);
			if (!json.ok) {
				$('#upload-result').html(json.msg);
				$('#upload-result').removeClass('hide');
			}
			else {
				$('#upload-result').addClass('hide');
				configure_import(json.upload_id);
			}
		});
		return false;
	});
})
function configure_import(upload_id)
{
	preloading($('#wp-configure-import'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax_import/configure_import",
		data: {upload_id: upload_id},
		success: function(html) {
			loaded($('#wp-configure-import'), html);
		}
	})
}
</script>