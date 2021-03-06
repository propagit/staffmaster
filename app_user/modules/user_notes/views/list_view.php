<ul class="messages">
<?php 
	if($user_notes){
		foreach($user_notes as $notes){
			$admin_id = $notes['added_by'];
			$date = $notes['created_date'];
			# get_user_notes_by_admin_id($user_id,$admin_id)
			$grouped_notes = modules::run('user_notes/get_user_notes_by_admin_id_and_date',$notes['user_id'],$admin_id,$date);
			$creator = modules::run('user/get_user',$admin_id);
				
?>
				 <li class="by-user">
                 	 <a href="<?=base_url();?>staff/edit/<?=$admin_id;?>">
                     	 <?=modules::run('staff/profile_image',$admin_id);?>
					 </a>
        
            	 <div class="message-area">
                  <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
                  <div class="info-row">
                      <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                          <span class="wk_date display-inline"><?=date('d',strtotime($date));?></span>
                          <span class="wk_month display-inline"><?=date('M',strtotime($date));?></span>
                          <span class="wk_year display-inline">, <?=date('Y',strtotime($date));?></span>
                      </div>
                      <span class="title"><?=$creator['first_name'] . ' ' . $creator['last_name']?></span>
                  </div>     
<?php
				foreach($grouped_notes as $gn){
?>
					<div class="user-notes-row">
                       <span class="title"><strong><?=date('h:i:s a',strtotime($gn['created_on'])) . '</strong> - ';?></span>
                       <?=$gn['note'];?>
                    </div>   	
<?php
	
				} # foreach grouped notes as $gn
		
			echo '</li>';
		} # foreach user notes as notes
	}else{
		echo 'No notes found';	
	}
?>
</ul>