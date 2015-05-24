<?php
	$personal_fields = json_decode($config_personal);
	$custom_fields = json_decode($config_custom);
	$personal_details = '';
	$custom_attrs = '';
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
    	<?php if($personal_fields){ ?>
    	<?php if(in_array('first_name',$personal_fields) || in_array('last_name',$personal_fields)){ ?>
        	<h4><?=in_array('first_name',$personal_fields) ? $staff['first_name'] . ' ' : '';?><?=in_array('last_name',$personal_fields) ? $staff['last_name'] : '';?></h4>
        <?php } ?>
        <?php 
			/* 
				staff personal details
			*/
			
			foreach($personal_fields as $field){ 
				switch($field){
					case 'dob':
						$personal_details .=  '<tr>
												<td>Age</td>
												<td>' . $staff['age_group'] . ' Years</td>
											  </tr>';
					break;
					
					case 'gender':
						$gender = '';
						if($staff[$field]){
							$gender = $staff[$field] == 'm' ? 'Male' : 'Female';
						}
						$personal_details .=  '<tr>
												<td>' . ucwords($field) . '</td>
												<td>' . $gender . '</td>
											  </tr>';
					break;
					
					case 'title':
					case 'first_name':
					case 'last_name':
						$personal_details = $personal_details;
					break;	
					
					default:
						$personal_details .=  '<tr>
												<td>' . ucwords($field) . '</td>
												<td>' . ($staff[$field] != '' ? $staff[$field] : 'NA') . '</td>
											  </tr>';
					break;
					
				} # end -switch
			} # end - personal fields
		?>  
        <?php } # end - if personal field ?>
		<?php 
			/* 
				staff custom attributes
			*/
			#echo '<pre>'.print_r($staff_custom,true).'</pre>';
			if($custom_fields){
				foreach($custom_fields as $field){ 
					$key = array_search($field, array_column($staff_custom, 'field_id'));
					if($key){
						switch($staff_custom[$key]['type']){
							case 'checkbox':
								$temp_arr = json_decode($staff_custom[$key]['staff_value']);
								$custom_attrs .= '<tr>
													<td> ' .  $staff_custom[$key]['label']  . '</td>
													<td> ' . implode(',',$temp_arr). '</td>
												  <tr>';
							break;
							
							case 'file':
								$file_list = '';
								$files = json_decode($staff_custom[$key]['staff_value']);
								if(count($files)>0){
									foreach($files as $file){
										$file_list .= modules::run('common/mime_to_icon', UPLOADS_PATH . '/staff/ ' . $staff['user_id'] . '/' . $file) . ' ' . '<a target="_blank" href="' . base_url().UPLOADS_URL . '/staff/' . $staff['user_id'] . '/' . $file . '">Download</a><br>';	
									}
								}
								$custom_attrs .= '<tr>
													<td> ' .  $staff_custom[$key]['label']  . '</td>
													<td> ' . $file_list. '</td>
												  <tr>';
							break;
							
							default:
								$custom_attrs .= '<tr>
													<td> ' .  $staff_custom[$key]['label']  . '</td>
													<td> ' . $staff_custom[$key]['staff_value'] . '</td>
												  <tr>';
							break;	
						} # end switch
						
					} # end - if key
              	} # end - foreach custom fields
			} # end - if custom fields
          ?>  
        
        <table class="lb-table">
        	<?php echo $personal_details; ?>
            <?php echo $custom_attrs; ?>
        </table>
        <?php 
			$liked_class = '';
			if(isset($client_user_id) && $client_user_id){ 
				$is_liked = modules::run('lookbook/is_liked_by_client',$client_user_id,$staff['user_id']); 
				$liked_class = $is_liked ? 'btn-core' : '';
		?>
		<button class="btn btn-lookbook like-this-staff <?=$liked_class;?>" id="btn-like-<?=$staff['user_id'];?>" data-staff-user-id=<?=$staff['user_id'];?> data-client-user-id=<?=$client_user_id;?>><i class="fa fa-thumbs-o-<?=$is_liked ? 'down' : 'up';?>"></i> <?=$is_liked ? 'Un-' : ''?>Like This Staff</button>	
		<?php }else{ ?>
        <button class="btn btn-lookbook"><i class="fa fa-thumbs-o-up"></i> Like This Staff</button>
        <?php } ?>
    </div>
    
</div>