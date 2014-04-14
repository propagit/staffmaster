<div class="col-md-12">
	<div class="wp-page-invoice full-width push">
    	<h1 class="brief-viewer-header" id="brief-viewer-header">Job Brief</h1>

        <div class="col-md-6 brief-list remove-gutters">
            <table id="brief-list-table" class="table table-bordered table-hover table-middle table-expanded">
                <thead>
                    <tr>
                        <th class="left">Title</th>
                        <th class="center" width="80">View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="brief-tr active-brief" data-brief-id="<?=$brief->brief_id;?>" id="brief-tr-<?=$brief->brief_id;?>">
                        <td class="left"><?=$brief->name;?></td>
                        <td class="center"><i class="fa fa-eye"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <hr class="full-width push" />

        <div id="ajax-brief-preview" class="push full-width">
        	<h2 class="s30"><?=$brief->name;?></h2>
            <div id="brief-body" class="brief-body">
            <?php 
                if(isset($brief_elements) && $brief_elements){
                    for($i = 0;$i < count($brief_elements); $i++){
                        $elm = $brief_elements[$i];
                        switch($elm->element_type){
                            case 'header':
                                echo '<h1>'.$elm->element_content.'</h1>';
                            break;
                            
                            case 'desc-text':
                                echo $elm->element_content;
                            break;
                            
                            case 'image':
                                echo '<img src="'.base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content.'" />';	
                            break;
                            
                            case 'document':
                            $doc_loop = true;
                        ?>
                      
                            <table class="table table-bordered table-hover table-middle table-expanded brief-table">
                                <thead>
                                <tr class="heading">
                                    <th class="left">Document Title</th>
                                    <th class="center col-md-1">Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="left"><a href="<?=base_url().UPLOADS_URL.'/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><?=$elm->document_name;?></a></td>
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
                    }
                }
            ?>
            </div>

        </div>
    </div>
</div>
<script>
$(function(){
	//update header
	$('#brief-shift-info').html('<?=$brief->name;?>');
	
});//ready

</script>