<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Venues</h2>
		 <p>Venues are the location in which jobs take place. You can add multiple venues at once by importing a venue list as a .CSV file (<a href="<?=base_url();?>assets/sample_docs/Venues.csv">Download Sample File</a>). Enter your venue address accurately to ensure your map data gets plotted correctly. Staff select locations they can work in their profile information which relates to the locations of venues.</p>
		 <a class="btn btn-info btn-rt-margin" href="<?=base_url();?>attribute/venue"><i class="fa fa-plus"></i> Add New Venue</a>
		 <a class="btn btn-info" href="<?=base_url();?>attribute/venue/import"><i class="fa fa-upload"></i> Import Venues</a>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
			<h2>Select File</h2>
			<br />
			<form class="form-inline" role="form" id="upload-venue-csv-form" enctype="multipart/form-data" action="<?=base_url();?>attribute/ajax_venue/upload_csv" method="POST">
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
				<button type="button" class="btn btn-core btn-block" id="btn-upload-venue-csv"><i class="fa fa-upload"></i> Upload</button>
			</div>
			<div class="clearfix"></div>
			<div class="alert alert-danger hide" id="upload-result"></div>
			</form>
			<hr />
			<div id="wp-configure-import" class="tab-export"></div>
        </div>
    </div>
</div>

<script>
$(function(){
	$('#btn-upload-venue-csv').click(function(){
		$('#upload-venue-csv-form').ajaxSubmit(function(json){
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
		url: "<?=base_url();?>attribute/ajax_venue/configure_import",
		data: {upload_id: upload_id},
		success: function(html) {
			loaded($('#wp-configure-import'), html);
		}
	})
}
</script>