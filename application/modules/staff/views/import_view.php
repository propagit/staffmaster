<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Import Staff</h2>
    	 <p>To import your staff, download <a>Sample File</a> and open it in a program such as Microsoft Excel. Enter your own information and save the file as a .csv then click the upload file button.</p>
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
			<h2>Step 1: Select File</h2>
			<form class="form-inline" role="form" id="upload-staff-csv-form" enctype="multipart/form-data" action="<?=base_url();?>staff/ajax/upload_staff_csv" method="POST">
			<div class="pull-left">
				<div class="fileupload fileupload-staff" data-provides="fileupload" >        
					<span class="btn btn-file">
						<i class="fa fa-paperclip"></i>
						<span class="fileupload-new"> Attach File</span>
						<span class="fileupload-exists">Change</span>         
						<input type="file" name="userfile"/>
					</span>
					<span class="fileupload-preview"></span>
					<a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i> &nbsp; </a>
				</div>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-core btn-block" id="btn-upload-staff-csv"><i class="fa fa-upload"></i> Upload</button>
			</div>
				<span class="help-block" id="upload-result"></span>
			</form>
        </div>
    </div>
</div>
<!--end bottom box -->

<script>
$(function(){
	$(document).on('click','#btn-upload-staff-csv',function(){
		if(help.validate_form('upload-staff-csv-form')){
			$('#upload-staff-csv-form').submit();	
		}
	});

	$(document).on('submit','#upload-staff-csv-form',function(){
		$(this).ajaxSubmit(function(html){
			$('#upload-result').html(html);
			setTimeout(function(){
				//$('#msg-conversation-started-successfully').addClass('hide');
			}, 2000);
			//help.reload_conversations(container_id,action_url);	
			//$('#wrapper_loading').remove();
		});	
		return false;
	});
})
</script>