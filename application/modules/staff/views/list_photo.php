<div class="row">
    <div class="col-md-2 remove-left-gutter">
        <i class="fa fa-heart"></i> Profile Image <br /><br />
        <div class="picture-box">
            <div class="profile-picture">
            <? 
            if(isset($hero_photo) && $hero_photo != NULL){?> <img src="<?=base_url()?>uploads/staff/profile/<?=md5($user_id)?>/thumbnail/<?=$hero_photo['name']?>"><? }else{?>
                    <i class="fa <?=(modules::run('staff/get_staff_gender',$user_id) == 'm' ? 'fa-male': 'fa-female');?> default-profile-photo"></i>
            <? } ?>
            </div>
        </div>
        
    </div>
    <div class="col-md-10">
        <i class="fa fa-picture-o"></i> Your Gallery <br /><br />
         <?  if(isset($photos) && $photos != NULL){?>
        <div id="carousel" class="flexslider gallery_staff">
          <ul class="slides popup-gallery staff-photos">
           <?
                foreach($photos as $photo){
                    $photo_src_full = base_url().'uploads/staff/profile/'.md5($user_id).'/'.$photo['name'];                                    
                    $thumb_src = base_url().'uploads/staff/profile/'.md5($user_id).'/thumbnail/'.$photo['name'];
                ?>
                    <li>
                        <a title="<?=$photo['name'];?>" href="<?=$photo_src_full?>"><img style="width:auto!important;" src="<?=$thumb_src;?>" /></a>
                        <div align="center" class="action_image" > 
                           <div class="action_icon"><i onclick="set_hero(<?=$photo['id'];?>)" class="fa fa-heart" <? if($photo['hero']==1){echo "style='color:#f00;'";}?> ></i></div>
                            <a onclick="delete_photo(<?=$photo['id']?>)"><div class="action_icon"><i class="fa fa-times"></i></div> </a>
                        </div>
                    </li>
                <?
                }
				?>
                
             
            <!-- items mirrored twice, total of 12 -->
          </ul>
        </div>
        <? }?>
        <div style="clear:both;"></div>
    </div>
</div>

