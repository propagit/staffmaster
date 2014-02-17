<div class="row">
    <div class="col-md-2 picture-box">
        <i class="fa fa-heart"></i> Profile Image <br /><br />
        <div class="profile_border">
        <? 
		
		if(isset($hero_photo) && $hero_photo != NULL){?> <img src="<?=base_url()?>uploads/staff/profile/<?=md5($user_id)?>/thumbnail/<?=$hero_photo['name']?>"><? }else{?>
                <div class="no_photo">
                    No Photo
                </div>
        <? } ?>
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
                            <a href="#" onclick="set_hero(<?=$photo['id']?>)"><div class="action_icon"><i class="fa fa-heart" <? if($photo['hero']==1){echo "style='color:#f00;'";}?> ></i></div></a>
                            <a href="#" onclick="delete_photo(<?=$photo['id']?>)"><div class="action_icon"><i class="fa fa-times"></i></div> </a>
                        </div>
                    </li>
                <?
                }?>
             
            <!-- items mirrored twice, total of 12 -->
          </ul>
        </div>
        <? }?>
        <div style="clear:both;"></div>
    </div>
    
</div>

<!-- Add Image Modal -->
<div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="editVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Image</h4>
			</div>
			
			<div class="modal-body">				
                <?=modules::run('common/upload_picture', 'user_id',$user_id);?>				
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->