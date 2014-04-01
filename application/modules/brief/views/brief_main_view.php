<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Brief Builder</h2>
		 <p>
         	Your brief builder is designed to deliver different types of content to your staff such as document downloads, file requests, training videos or questions answered.
			A shift can have multiple briefs applied and a breif you create can be multiple times across multiple campaigns. 
        </p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="col-md-4 white-box">
            <div class="inner-box transparent-bg">
                <h2>Build Your Brief</h2>
                <p>Use the below functions to build your brief</p>
                
                <div class="brief-functions">
                	<dl id="brief-elements" class="brief-func-dl">
                    	<dt>Text</dt>
                        	<dd data-brief="header">Add Header</dd>
                            <dd data-brief="desc-text">Add Descriptive text</dd>
                    	<dt>Upload File For Upload</dt>
                        	<dd data-brief="file-download">File Download</dd>
                    </dl>
                </div>
                
            </div>
        </div>
        
        <div class="col-md-8 white-box">
            <div class="inner-box brief-floating-box">
            	<h2>Your Brief Elements</h2>
                <p>As you add your brief elements, it will appear here.</p>
            	<form id="add-brief-form"  enctype="multipart/form-data" action="<?=base_url();?>brief/ajax/add_brief" method="POST">
                    <div class="brief-elements" id="brief-generator">
                       
                    </div>
                    <input id="brief-element-type" type="hidden" name="element_type" value="" />
                    <input id="brief-id" type="hidden" name="brief_id" value="<?=$brief_id;?>" />
                    <div class="form-group brief-add-btn-wrap">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <button class="btn btn-info" type="submit" id="add-brief-element">Add</button>
                        </div>
                    </div>
                </form>
            </div>

           <div id="brief-preview-container"></div>

        </div>
    </div>
</div>
<!--end bottom box -->

<script>
$(function(){
	$('#brief-elements dd').on('click',function(){
		brief_elements($(this).attr('data-brief'));
	});
	
	load_brief_preview(<?=$brief_id;?>);
	
	$(document).on('submit','#add-brief-form',function(){
		preloading($('body'));
		$(this).ajaxSubmit(function(html){
			$('#wrapper_loading').remove();
			$('#brief-id').val(html);
			empty_brief_generator_box();
			load_brief_preview(html);
		});	
		return false;
	});
	
});//ready

function empty_brief_generator_box()
{
	$('#brief-generator').html('');
	$('.brief-add-btn-wrap').hide();
}

function brief_elements(element_type)
{
	var element = '';
	var element_label = '';
	switch(element_type){
		case 'header':
			element = '<input type="text" class="form-control brief-elem" name="brief_content"  />';
			element_label = 'Header';
		break;	
		
		case 'desc-text':
			element = '<textarea class="form-control brief-elem" name="brief_content"></textarea>';
			element_label = 'Description';
		break;
		
		case 'file-download':
			element = '<div class="fileupload fileupload-staff brief-elem" data-provides="fileupload"><span class="btn btn-file"><i class="fa fa-cloud-upload"></i><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="userfile"/></span><span class="fileupload-preview"></span><a href="#" class="fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i></a></div> ';
			element_label = 'File download';
		break;
	}
	
	$('#brief-element-type').val(element_type);
	$('.brief-add-btn-wrap').show();
	var form_row = '<div class="form-group remove-min-height"><label for="brief-header" class="col-sm-2 control-label remove-left-padding">'+element_label+'</label><div class="col-sm-10">'+element+'</div></div>';
	$('#brief-generator').html(form_row);
	
	if(element_type == 'desc-text'){
	  var brief_content = CKEDITOR.replace('brief_content',{
		height:100
	  });	
	}
}

function load_brief_preview(brief_id)
{
	preloading($('#brief-preview-container'));
	$.ajax({
	type: "POST",
	url: "<?=base_url();?>brief/ajax/load_brief_preview",
	data: {brief_id:brief_id},
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#brief-preview-container').html(html);
		}
	});
}


CKEDITOR.config.toolbar = [
    <?=LIVE_SERVER ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

function update_ckeditor()
{
	for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
    }	
}

</script>