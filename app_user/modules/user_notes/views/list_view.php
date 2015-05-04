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

<?php if(0){ ?>
<div class="staff-profile-detail-box">
	<h2>Quick Notes</h2>
</div>
<ul class="messages">
	  <li class="by-user">
			<a href="http://kaushtuv.sm.com/staff/edit/2">
                <div class="profile_photo">
                    <div class="default-avatar-photo">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </a>			 
          
          <div class="message-area">
              <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
              <div class="info-row">
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date display-inline">05</span>
                      <span class="wk_month display-inline">May</span>
                      <span class="wk_year display-inline">,2015</span>
                  </div>
              </div>
              <div>
                  <span class="title">2:55 PM</span>
                  Called in again and said was fit to come to work 
              </div>                          
              <div>
                  <span class="title">2:34 PM</span>
                  Called and said was feeling a bit sick  
              </div>
          </div>
      </li>
      <li class="divider"><span>...</span></li>
      <li class="by-user">
			<a href="http://kaushtuv.sm.com/staff/edit/2">
                <div class="profile_photo">
                    <div class="default-avatar-photo">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </a>			 
          
          <div class="message-area">
              <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
              <div class="info-row">
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date display-inline">04</span>
                      <span class="wk_month display-inline">May</span>
                      <span class="wk_year display-inline">,2015</span>
                  </div>
              </div>
              <div>
                  <span class="title">2:55 PM</span>
                  Called in again and said was fit to come to work 
              </div>                          
              <div>
                  <span class="title">2:34 PM</span>
                  Called and said was feeling a bit sick  
              </div>
          </div>
      </li>
</ul>
<?php } ?>