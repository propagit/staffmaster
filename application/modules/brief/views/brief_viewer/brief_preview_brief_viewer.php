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
                    echo '<img src="'.base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content.'" />';	
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
                            <td class="left"><a href="<?=base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><?=$elm->document_name;?></a></td>
                            <td class="center"><a href="<?=base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><i class="fa fa-download grey-text"></i></a></td>
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
                                <td class="left"><a href="<?=base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><?=$elm->document_name;?></a></td>
                                <td class="center"><a href="<?=base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><i class="fa fa-download grey-text"></i></a></td>
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
