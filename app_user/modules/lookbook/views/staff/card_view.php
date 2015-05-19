<?php
	$personal_fields = json_decode($config_personal);
	$custom_fields = json_decode($config_custom);
	#print_r($personal_fields);
?>
<div class="lb-box">
    <div class="avatar">
    	<?php 
			if(count($photo) > 0){ 
			$thumb_src = base_url().UPLOADS_URL.'/staff/'.$staff['user_id'].'/thumb/'.$photo['name'];
		?>
        	<img src="<?=$thumb_src;?>" title="<?=$staff['first_name'] . ' ' . $staff['last_name'];?>" alt="<?=$photo['name']?>" />
        <?php } else { # no photo found show default avatar ?>
        	<div class="default-avatar-photo"><i class="fa fa-user"></i></div>
        <?php } ?>
    </div>
    <div class="info">
    	<?php if(in_array('first_name',$personal_fields) || in_array('last_name',$personal_fields)){ ?>
        	<h4><?=in_array('first_name',$personal_fields) ? $staff['first_name'] . ' ' : '';?><?=in_array('last_name',$personal_fields) ? $staff['last_name'] : '';?></h4>
        <?php } ?>
        <?php 
			$details = '';
			#print_r($staff);
			foreach($personal_fields as $field){ 
				switch($field){
					case 'dob':
						$details .=  '<dt>Age</dt>
							  			<dd>' . $staff['age_group'] . ' Years</dd>';
					break;
					
					case 'title':
					case 'first_name':
					case 'last_name':
				
					break;	
					
					default:
						$details .= '<dt>&nbsp;</dt>
							  			<dd>' . $staff[$field] ? trim($staff[$field]) : '&nbsp;' . '</dd>';
					break;
					
				}
			}
		?>  
        <dl>
        	<?php echo $details; ?>
        </dl>
        <button class="btn btn-core btn-lookbook"><i class="fa fa-thumbs-o-up"></i> Like</button>
    </div>
    
</div>