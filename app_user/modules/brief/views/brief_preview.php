<div class="brief-preview">
    <?=modules::run('setting/company_logo');?>
    <div id="brief-body" class="brief-body">
    <?php 
		if(isset($brief_elements) && $brief_elements){
			for($i = 0;$i < count($brief_elements); $i++){
				$elm = $brief_elements[$i];
				$delete_btn = true;
				echo '<div class="brief-preview-row">';
				switch($elm->element_type){
					case 'header':
						echo '<h1><a href="#" class="edit-brief-header" data-type="text"  data-pk="'.$elm->brief_element_id.'" data-title="'.$elm->element_content.'">'.$elm->element_content.'</a></h1>';
					break;
					
					case 'desc-text':
						echo '<div class="ck-edit" id="ck-edit-'.$elm->brief_element_id.'" data-pk="'.$elm->brief_element_id.'" contenteditable="true">'.$elm->element_content.'</div>';
						echo '<script>var editor = CKEDITOR.inline( document.getElementById("ck-edit-'.$elm->brief_element_id.'") );</script>';
					break;
					
					case 'image':
						echo '<img src="'.base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content.'" />';	
					break;
					
					case 'document':
					$doc_loop = true;
					$delete_btn = false;
				?>
              
                	<table class="table table-bordered table-hover table-middle table-expanded brief-table">
                        <thead>
                        <tr class="heading">
                            <th class="left">Document Title</th>
                            <th class="center col-md-1">Delete</th>
                            <th class="center col-md-1">Download</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left"><a href="<?=base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><?=$elm->document_name;?></a></td>
                                <td class="center"><a class="delete-brief-element" delete-data-id="<?=$elm->brief_element_id;?>"><i class="fa fa-times"></i></a></td>
                                <td class="center"><a href="<?=base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><i class="fa fa-download grey-text"></i></a></td>
                            </tr>
				  <?php
				      // if the next element is a document as well attach this with the previous document 
					  // else proceed with loop
				  	  $count = $i;
					  while($doc_loop){
						  $count++;
						  if(isset($brief_elements[$count])){
							  $elm = $brief_elements[$count];
							  if($elm->element_type == 'document'){
				  ?>
                                <tr>
                                    <td class="left"><a href="<?=base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><?=$elm->document_name;?></a></td>
                                    <td class="center"><a class="delete-brief-element" delete-data-id="<?=$elm->brief_element_id;?>"><i class="fa fa-times"></i></a></td>
                                    <td class="center"><a href="<?=base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><i class="fa fa-download grey-text"></i></a></td>
                                </tr>
                  <?php
				  			  $i++;
							  }else{ 
								$doc_loop = false;
							  }
						  }else{
							 $doc_loop = false; 
						  }
					  }
	
				  ?>
                        </tbody>
                    </table>
                <?php
					break;
				}
				if($delete_btn){
				echo '<div class="brief-elements-edit-wrap">
							<div class="editable-buttons">
							   <button type="button" class="btn btn-danger btn-sm editable-cancel delete-brief-element" delete-data-id="'.$elm->brief_element_id.'"><i class="glyphicon glyphicon-remove"></i></button>
							</div>
					   </div>';
				}
				echo '</div>';
			}
		}
	?>
    </div>
</div>

<script>
$(function(){
	//inline editing for header elements
	$('.edit-brief-header').editable({
		url: '<?=base_url();?>brief/ajax/edit_brief_element',		
	});

	//delete brief element
	$('.delete-brief-element').on('click',function(){
		var title = 'Delete Brief Element';
		var message ='Are you sure you would like to delete this Brief Element';
		var brief_element_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				delete_brief_element(brief_element_id);
			 }
		});
	});
	
	//update ck content
	$('.ck-edit').focusout(function(){
		edit_brief_element($(this));
	});
	
	
});//ready

</script>