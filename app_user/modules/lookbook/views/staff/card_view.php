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
        <h4><?=$staff['first_name'] . ' ' . $staff['last_name'];?></h4>
        <dl>
            <dt>State</dt>
            <dd><?=$staff['state'];?></dd>
            
            <dt>Age</dt>
            <dd><?=$staff['age_group'];?> Years</dd>
        </dl>
        <button class="btn btn-core btn-lookbook"><i class="fa fa-thumbs-o-up"></i> Like</button>
    </div>
    
</div>