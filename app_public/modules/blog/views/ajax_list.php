 <div id="top-table">
    <div style="float: left">
        <div id="top-table-title">blog List <span><?=$total;?></span></div>
    </div>         
    <div style="clear: both"></div>
</div>
<table class="blog-list-table">
    <thead>
        <tr class="list-tr">
            <th class="list-case-title">Blog Title <i data-toggle="tooltip" title="Sort by title" class="fa fa-sort-alpha-asc cursor list-title-sort sort-icons my-tooltip" onclick="cs_search.sort_search('title');"></i></th>
            <th class="list-case-cat">Category</th>
            <th class="list-case-date">Date <i data-toggle="tooltip" title="Sort by date" class="fa fa-sort-alpha-desc cursor list-date-sort sort-icons status-active my-tooltip" onclick="cs_search.sort_search('date');"></i></th>
            <th class="list-case-status">Status <i data-toggle="tooltip" title="Sort by status" class="fa fa-sort-amount-asc cursor list-status-sort sort-icons my-tooltip" onclick="cs_search.sort_search('status');"></i></th>
            <th class="list-case-view">View | Edit</th>
            <th class="list-case-del">Delete</th>
        </tr>
    </thead>
    <tbody>
    	<?php 
			foreach($blogs as $blog){ 
				$clean_title = $case->title;
				$clean_title = str_replace('"', "", $clean_title);
				$clean_title = str_replace("'", "", $clean_title);
		?>
              <tr class="list-tr">
                  <td class="list-case-title"><a class="my-tooltip" data-toggle="tooltip" title="Edit article" href="<?=base_url();?>admin/blog/edit/<?=$case->id;?>"><?=$case->title;?></a> <a class="my-tooltip" data-toggle="tooltip" title="Preview article" target="_blank" href="<?=base_url();?>preview-story/<?=$case->slug;?>"><i class="fa fa-search"></i></a></th>
                  <td class="list-case-cat remove-left-padding"><? //$this->get_blog_categories($case->id);?></th>
                  <td class="list-case-date remove-left-padding">(<?=date('d-m-Y',strtotime($case->study_date));?>)</th>
                  <td class="list-case-status remove-left-padding">
                  <? if($case->status == 'active'){ ?>
                  <a class="my-tooltip" data-toggle="tooltip" title="Deactivate article" href="<?=base_url();?>admin/blog/deactivate/<?=$case->id;?>"><i class="fa fa-check-circle status-active"></i></a>
                  <? }else{ ?>
                   <a class="my-tooltip" data-toggle="tooltip" title="Activate article" href="<?=base_url();?>admin/blog/activate/<?=$case->id;?>"><i class="fa fa-times-circle status-inactive"></i></a>
                  <? } ?>
                 
                  </th>
                  <td class="list-case-view remove-left-padding"><a class="my-tooltip" data-toggle="tooltip" title="Edit article" href="<?=base_url();?>admin/blog/edit/<?=$case->id;?>"><i class="fa fa-edit"></i></a></th>
                  <td class="list-case-del remove-left-padding"><i data-toggle="tooltip" title="Delete article"onclick="case_std_list.confirm_delete_blog(\'<?=$clean_title;?>\',<?=$case->id;?>)" class="fa fa-trash-o cursor my-tooltip"></i></th>
              </tr>
        
        <?php } ?>
    </tbody>
</table>


<?php
	
		$arr[0] = '[ Total Records - 0 | Showing <?=$data_per_page;?> Records Per Search ]';
		$arr[1] = '';
		
		//output - no changes required here for any sql related changes
		if($blog){
			foreach($blog as $case){
				$clean_title = $case->title;
				$clean_title = str_replace('"', "", $clean_title);
				$clean_title = str_replace("'", "", $clean_title);
				$out .= '<tr class="list-tr">
							<td class="list-case-title"><a class="my-tooltip" data-toggle="tooltip" title="Edit article" href="<?=base_url();?>admin/blog/edit/<?=$case->id;?>"><?=$case->title;?></a> <a class="my-tooltip" data-toggle="tooltip" title="Preview article" target="_blank" href="<?=base_url();?>preview-story/<?=$case->slug;?>"><i class="fa fa-search"></i></a></th>
							<td class="list-case-cat remove-left-padding"><?=$this->get_blog_categories($case->id);?></th>
							<td class="list-case-date remove-left-padding">('.date('d-m-Y',strtotime($case->study_date));?>)</th>
							<td class="list-case-status remove-left-padding">'.($case->status == 'active' ? '<a class="my-tooltip" data-toggle="tooltip" title="Deactivate article" href="<?=base_url();?>admin/blog/deactivate/<?=$case->id;?>"><i class="fa fa-check-circle status-active"></i></a>' : '<a class="my-tooltip" data-toggle="tooltip" title="Activate article" href="<?=base_url();?>admin/blog/activate/<?=$case->id;?>"><i class="fa fa-times-circle status-inactive"></i></a>');?></th>
							<td class="list-case-view remove-left-padding"><a class="my-tooltip" data-toggle="tooltip" title="Edit article" href="<?=base_url();?>admin/blog/edit/<?=$case->id;?>"><i class="fa fa-edit"></i></a></th>
							<td class="list-case-del remove-left-padding"><i data-toggle="tooltip" title="Delete article"onclick="case_std_list.confirm_delete_blog(\'<?=$clean_title;?>\',<?=$case->id;?>)" class="fa fa-trash-o cursor my-tooltip"></i></th>
						</tr>';	
			}
			
			
			$arr[0] = '[ Total Records - <?=$total;?> | Showing <?=$data_per_page;?> Records Per Search ]';
			$arr[1] = $out;
			//$arr[1] = $sql;
		}
		return json_encode($arr);
?>