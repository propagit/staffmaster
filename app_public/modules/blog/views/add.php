<?php
	//if mode is edit
	$title = '';
	$slug = '';
	$date = '';
	$blog_id = '';
	$gallery = '';
	$preview = '';
	$content = '';
	$testimonial = '';
	$image = '';
	$doc = '';
	$folder = '';
	$meta_title = '';
	$meta_desc = '';
	$meta_keywords = '';
	$process_link = 'add_new_case_studies';
	if(isset($case_study)){
		$title = $case_study->title;
		$slug = $case_study->slug;
		$date = date('d-m-Y',strtotime($case_study->study_date));
		$blog_id = $case_study->id;
		$gallery = $case_study->gallery;
		$preview = $case_study->preview;
		$content = $case_study->content;
		$testimonial = $case_study->testimonial;
		$image = $case_study->image;
		$doc = $case_study->doc;
		$folder = md5('blog'.$blog_id);
		$meta_title = $case_study->meta_title;
		$meta_desc = $case_study->meta_description;
		$meta_keywords = $case_study->meta_keywords;
		$process_link = 'update_case_studies';	
	}


?>
<div class="row row-bottom-margin">
	<div class="col-md-12">
        <div class="title-page">Case Studies</div>
        <div class="sub-title">Add new article here</div>
		<div style="clear: both"></div>
		
        <div class="grey-box">
		<button class="btn btn-info" onclick="window.location = '<?=base_url()?>blog';"><i class="fa fa-hand-o-left"></i> Back To Case Studies</button>
        </div>
		<div class="subtitle-page">Basic Detail</div>
    </div> 
    <form id="add_blog" method="post" action="<?=base_url();?>blog/<?=$process_link;?>" enctype="multipart/form-data">
    <input type="hidden" name="update_id" value="<?=$blog_id;?>" id="blog_id" />
    <!-- <div class="col-md-12"> -->
        <div class="col-md-6 ">
        	<div class="article-form-row">
				<div class="article-label">Article Title</div>
				<div class="article-input">
					<input class="article-txt-box" type="text" id="title" name="title" value="<?=$title;?>" data="required"/>
				</div>
				<div style="clear: both"></div>
			</div>
            
            <div class="article-form-row">
				<div class="article-label">Link Title (No space,'/','&') </div>
				<div class="article-input">
					<input class="article-txt-box" type="text" id="slug" name="slug" value="<?=$slug;?>" data="required"/>
				</div>
			</div>
            
            <div class="article-form-row">
				<div class="article-label">Article Date</div>
				<div class="article-input">
					<input id="date" name="date" class="article-txt-box cursor" type="text" value="<?=$date;?>" readonly="readonly">
					<span class="add-on grey-bg"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
            
            <?php if(0){ ?>
            <?php
            	//disabled for this project
            ?>
            <!--<div class="article-form-row">
				<div class="article-label">Article Thumbnail</div>
				<div class="article-input">
                    <div class="fileupload fileupload-new article-upload-field" data-provides="fileupload">
                    <span class="btn btn-file">
                        <i class="fa fa-cloud-upload"></i>
                        <span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>         
                        <input type="file" name="userfile_thumb"/>
                    </span>
                    <span class="fileupload-preview"></span>
                    <a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i></a>
               	    </div>
                    <?php if($image) { ?>
                         <div class="file-preview" id="image-preview">
                                <span><?=$image;?></span> <i class="fa fa-search cursor" onmouseover="blog.toggle_gallery_tooltip('tool_img_<?=$blog_id;?>','show');" onmouseout="blog.toggle_gallery_tooltip('tool_img_<?=$blog_id;?>','hide');"></i> 
                                <i onclick="blog.confirm_delete_image('<?=$image;?>');" class="fa fa-trash-o cursor"></i>
                                <img id="tool_img_<?=$blog_id;?>" class="img-tooltip" src="<?=base_url();?>uploads/case_studies/<?=$folder;?>/thumb/<?=$image;?>"/>
                         </div>   
                    <?php } ?>
				</div>
			</div>
            
            <div class="article-form-row">
				<div class="article-label">Article Download</div>
                
				<div class="article-input">
                	<div class="fileupload fileupload-new article-upload-field" data-provides="fileupload">
                    <span class="btn btn-file">
                        <i class="fa fa-cloud-upload"></i>
                        <span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>         
                        <input type="file" name="userfile_download"/>
                    </span>
                    <span class="fileupload-preview"></span>
                    <a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i></a>
               	    </div>
					<?php if($doc) { ?>
                         <div class="file-preview" id="doc-preview">
                                <span><?=$doc;?></span> <a target="_blank" href="<?=base_url();?>uploads/case_studies/<?=$folder;?>/doc/<?=$doc;?>"><i class="fa fa-search cursor"></i></a>
                                <i onclick="blog.confirm_delete_doc('<?=$doc;?>');" class="fa fa-trash-o cursor"></i>
                         </div>   
                    <?php } ?>
				</div>
			</div>
            
            <div class="article-form-row">
				<div class="article-label">Article Gallery</div>
				<div class="article-input">
					<select class="custom-select" id="gallery_id" name="gallery_id">
	                   <? //$this->blog_model->load_gallery_options($gallery);?>
					</select>  
				</div>
			</div>-->
            
            <?php } ?>
            
            <div class="article-form-row">
				<div class="article-label">&nbsp;</div>
				<div class="article-input">
					<button type="button" class="btn btn-info" onclick="help.validate_form('add_blog');"><i class="fa fa-plus"></i> Save</button> 
				</div>
			</div>
        </div>
        
        <div class="col-md-6 ">
            <div class="grey-box article-cat-grey-box remove-margin-top" style="width: 100%; float: left; padding-bottom:10px; height:auto;">
                <div class="title-page">Article Categories <span>(Check the categories this post should appear in)</span></div>
            </div>
            <table class="article-cat-table">
            	<thead>
                	<tr class="list-tr">
                    	<th class="th-title">Category</th>
                        <th class="th-status">Active</th>
                        <th class="th-delete">Delete</th>
                    </tr>
                </thead>
                
                <tbody id="blog_tbody">
                	<?=$this->blog_model->create_category_list($blog_id);?>
                </tbody>
            </table>
            <div class="grey-box add-new-cat-grey-box">
                <div class="title-page cursor" id="add_category"><i class="fa fa-plus"></i> Add Categories</div>
            </div>
        </div>
        

	<!-- </div> -->
    <div style="clear: both"></div>
    <div class="col-md-12">
    	<div class="grey-box">
        	<div class="title-page">Article Content</div>
        </div>
        
        <div class="title-page">Article Preview Text</div>
        <div class="sub-title">The prview text is used to show a small amount of the full articles so the viewer can decide if they would like to read more</div>
		<div class="article-fullwidth-row">
    		<textarea id="preview_article" class="article-preview-txt-area" name="preview_article"><?=$preview;?></textarea>
        </div>
        
        <div class="title-page">Complete Article</div>
        <div class="sub-title">Write your complete article here</div>
		<div class="article-fullwidth-row">
    		<textarea id="complete_article" class="article-preview-txt-area" name="complete_article"><?=$content;?></textarea>
        </div>
        
        <div class="title-page">Testimonial</div>
        <div class="sub-title">Write your testimonial here</div>
		<div class="article-fullwidth-row">
    		<textarea id="testimonial" class="article-preview-txt-area" name="testimonial"><?=$testimonial;?></textarea>
        </div>

    </div>
    
    <div style="clear: both"></div>
    <div class="col-md-12">
    	<div class="grey-box">
        	<button class="btn btn-info"  type="button" id="add-meta-data"><i class="fa fa-plus"></i> Meta Data</button>
        </div>
        
        <div id="meta-data-box">
            <div class="title-page">Meta Title</div>
            <div class="sub-title">This will appear as the title for the web browser</div>
            <div class="article-fullwidth-row">
                <input class="article-txt-box full-width" type="text" name="meta_title" value="<?=$meta_title;?>" maxlength="255" />
            </div>
            
             <div class="title-page">Meta Description</div>
            <div class="sub-title">This will be used to describe the page content in brief for SEO bots</div>
            <div class="article-fullwidth-row">
                <input class="article-txt-box full-width" type="text" name="meta_desc" value="<?=$meta_desc;?>" maxlength="255" />
            </div>
            
             <div class="title-page">Meta Keywords</div>
            <div class="sub-title">This will serve as keywords page</div>
            <div class="article-fullwidth-row">
                <input class="article-txt-box full-width" type="text" name="meta_keywords" value="<?=$meta_keywords;?>" maxlength="255" />
            </div>
        </div>
		<div class="article-fullwidth-row">
    		<button type="button" class="btn btn-info" onclick="help.validate_form('add_blog');"><i class="fa fa-plus"></i> Save</button> 
        </div>

    </div>
    
    </form>
</div>
<script>
	$(function(){
		$('.custom-select').selectpicker();
		
	    /* $('#date').datepicker({
			format: "dd-mm-yyyy",
			todayBtn: "linked",
			autoclose: true	  
	    }); */

       $('#date').datetimepicker({
			pickTime:false   
	   });

	  help.custom_checkbox('.checker');
	  
	  help.make_permalink('#title','#slug'); 
	  
	  $('#title').keyup(function(){
		    var permalink = $('#slug').val();
		 	help.permalink_exists('<?=base_url();?>blog/ajax/permalink_exists',permalink,'#slug'); 
	  });
	  
	  $('#slug').keyup(function(){
		    var permalink = $('#slug').val();
		 	help.permalink_exists('<?=base_url();?>blog/ajax/permalink_exists',permalink,'#slug'); 
	  });
	  
	  $('#add_category').click(function(){
		  $('#new_category_model').modal('show'); 
	  });
	  
	  $('#add-meta-data').click(function(){
		 $('#meta-data-box').toggle(); 
	  });
	});//ready

var blog = {
	//add category
	add_new_category:function(){
		var name = $('#blog_category_name').val();
		var blog_id = $('#blog_id').val();
		if(title != ''){
			$.ajax({
				url: '<?=base_url();?>blog/ajax/add_new_category',
				type: 'POST',
				data: {name:name,blog_id:blog_id},
				success: function(html) {
					if(html != 'failed'){
						$('#blog_tbody').html(html);	
						$('#blog_category_name').val('');
						$('#new_category_model').modal('hide');
						help.custom_checkbox('.checker');
					}else{
						alert('Failed to add new category! Please try again!!!');
						$('#new_category_model').modal('hide');	
					}
				},
				error:function(){
					alert('Something went wrong! Please try again!!!');
					$('#new_category_model').modal('hide');
				}
			});	
		}
	},
	
	confirm_delete_category:function(category_id,category_name){
		if(category_id && category_name){
			$('#delete_category_name').html(category_name);
			$('#delete_category_id').val(category_id);	
			$('#delete_category_model').modal('show'); 
		}
		
	},
	
	//delete category
	delete_case_study_category:function(){
		var category_id = $('#delete_category_id').val();
		var blog_id = $('#blog_id').val();
		if(category_id){
			$.ajax({
				url: '<?=base_url();?>blog/ajax/delete_category',
				type: 'POST',
				data: {category_id:category_id,blog_id:blog_id},
				success: function(html) {
					if(html != 'failed'){
						$('#blog_tbody').html(html);
						$('#delete_category_model').modal('hide');
						help.custom_checkbox('.checker');
					}else{
						alert('Failed to add new category! Please try again!!!');
						$('#delete_category_model').modal('hide');	
					}
				},
				error:function(){
					alert('Something went wrong! Please try again!!!');
					$('#delete_category_model').modal('hide');
				}
			});		
		}
	},
	
	confirm_delete_image:function(image_name){
		if(image_name){
			$('#delete_image_name_span').html(image_name);
			$('#delete_blog_image_model').modal('show'); 
		}
		
	},
	
	delete_blog_image:function(){
		var blog_id = $('#blog_id').val();
		if(blog_id){
			$.ajax({
				url: '<?=base_url();?>blog/ajax/delete_blog_image',
				type: 'POST',
				data: {blog_id:blog_id},
				success: function(html) {
					if(html != 'failed'){
						$('#image-preview').remove();
						$('#delete_blog_image_model').modal('hide');
					}else{
						alert('Failed to add new category! Please try again!!!');
						$('#delete_blog_image_model').modal('hide');	
					}
				},
				error:function(){
					alert('Something went wrong! Please try again!!!');
					$('#delete_blog_image_model').modal('hide');
				}
			});		
		}
	},
	
	confirm_delete_doc:function(doc_name){
		if(doc_name){
			$('#delete_doc_name_span').html(doc_name);
			$('#delete_blog_doc_model').modal('show'); 
		}
		
	},
	
	delete_case_study_doc:function(){
		var blog_id = $('#blog_id').val();
		if(blog_id){
			$.ajax({
				url: '<?=base_url();?>blog/ajax/delete_case_study_doc',
				type: 'POST',
				data: {blog_id:blog_id},
				success: function(html) {
					if(html != 'failed'){
						$('#doc-preview').remove();
						$('#delete_blog_doc_model').modal('hide');
					}else{
						alert('Failed to add new category! Please try again!!!');
						$('#delete_blog_doc_model').modal('hide');	
					}
				},
				error:function(){
					alert('Something went wrong! Please try again!!!');
					$('#delete_blog_doc_model').modal('hide');
				}
			});		
		}
	},
	
	toggle_gallery_tooltip:function(gallery_tooltip_id,toggle_type){
		if(toggle_type == 'show'){
			$('#'+gallery_tooltip_id).show();
		}else{
			$('#'+gallery_tooltip_id).hide();
		}
	}
};

	
var preview_article = CKEDITOR.replace('preview_article',{
  height:100
});
var complete_article = CKEDITOR.replace('complete_article',{
  height:300
});
var testimonial = CKEDITOR.replace('testimonial',{
  height:100
});

CKEDITOR.config.toolbar = [
   ['Source'],['Styles'], ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ],['Link', 'Unlink','Anchor'],['Image'],['list', 'indent', 'blocks', 'align', 'bidi' ],[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'],['Paste', 'PasteText', 'PasteFromWord']
] ;
CKFinder.setupCKEditor( preview_article, '<?=base_url()?>assets/ckfinder/' );
CKFinder.setupCKEditor( complete_article, '<?=base_url()?>assets/ckfinder/' );
CKFinder.setupCKEditor( testimonial, '<?=base_url()?>assets/ckfinder/' );
</script>



<!--begin add categories-->
<div id="new_category_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h3 id="myModalLabel">Add New Category</h3>
            </div>
            <div class="modal-body">
                
                <div class="left-side modal-label">
                    Category Name
                </div>
                <div class="left-side">
                    <input class="form-control input-text" type="text" id="blog_category_name" value=""/>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-info" onclick="blog.add_new_category();"><i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
    </div>
</div>
<!--end add categories-->

<!--begin delete categories-->
<div id="delete_category_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h3 id="myModalLabel">Delete Category</h3>
            </div>
            <div class="modal-body">
                
                <p>
                    You are about to delete <span class="title-page" id="delete_category_name"></span> category. Confirm delete?
                    <input type="hidden" id="delete_category_id" />
                </p>
                <div class="cleardiv"></div>
               
            </div>
            <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-info" onclick="blog.delete_case_study_category();"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
<!--end delete categories-->

<!--begin delete image-->
<div id="delete_blog_image_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h3 id="myModalLabel">Delete Image</h3>
            </div>
            <div class="modal-body">
                
                <p>
                    You are about to delete <strong><span id="delete_image_name_span"></span></strong>. Confirm delete?
                </p>
                <div class="cleardiv"></div>
               
            </div>
            <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-info" onclick="blog.delete_blog_image();"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
<!--end delete image-->

<!--begin delete image-->
<div id="delete_blog_doc_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h3 id="myModalLabel">Delete Document</h3>
            </div>
            <div class="modal-body">
                
                <p>
                    You are about to delete <strong><span id="delete_doc_name_span"></span></strong>. Confirm delete?
                </p>
                <div class="cleardiv"></div>
               
            </div>
            <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-info" onclick="blog.delete_case_study_doc();"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
<!--end delete image-->

