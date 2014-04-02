<div class="brief-preview">
    <?=modules::run('setting/company_logo');?>
    <div id="brief-body" class="brief-body">
    <?php 
		if(isset($brief_elements) && $brief_elements){
			foreach($brief_elements as $elm){
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
				?>
                	<table class="table table-bordered table-hover table-middle table-expanded brief-table">
                        <thead>
                        <tr class="heading">
                            <th class="left">File Name</th>
                            <th class="center col-md-1">Download</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left"><a href="<?=base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><?=$elm->document_name;?></a></td>
                                <td class="center"><a href="<?=base_url().'uploads/brief/'.md5('brief'.$elm->brief_id).'/'.$elm->element_content;?>"><i class="fa fa-download grey-text"></i></a></td>
                            </tr>

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