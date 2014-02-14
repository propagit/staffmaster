<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Edit Staff</h2>
		 <p>Edit staff using below form.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Edit Staff</h2>
			<p>Edit staff using below form.</p>
            
            <ul class="nav nav-tabs tab-respond" id="navStaff">

                <li class="active"><a href="#personal" data-toggle="tab">Personal Details</a></li>
                <li><a href="#financial" data-toggle="tab">Financial Details</a></li>
                <li><a href="#super" data-toggle="tab">Super Details</a></li>
                <li><a href="#availability" data-toggle="tab">Availability</a></li>
                <li><a href="#roles" data-toggle="tab">Roles</a></li>
                <li><a href="#payrate" data-toggle="tab">Pay Rate</a></li>
                <li><a href="#option" data-toggle="tab">Options</a></li>
                <li><a href="#location" data-toggle="tab">Location</a></li>
                <li><a href="#setting" data-toggle="tab">Settings</a></li>
                <li><a href="#document" data-toggle="tab">Documents</a></li>
                <li><a href="#picture" data-toggle="tab">Pictures</a></li>
			</ul>
           
           	<div class="tab-content">
				<div class="tab-pane active" id="personal"></div>
				<div class="tab-pane" id="financial"></div>
				<div class="tab-pane" id="super"></div>
				
				<div class="tab-pane" id="availability">
					<br />
                    <div class="row">
						<div class="col-md-12">
							<h2> Your Availability </h2>
                            <p> Please let us know the times that you are available for work</p>
                            
                           <? //echo '<pre>'.print_r($staff_availability,true).'</pre>';?>
                            
                            <?=modules::run('common/set_availability','availability',$staff_availability);?>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="roles">
					
				</div>
				<div class="tab-pane" id="payrate">
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">Pay rate</label>
								<div class="col-lg-10">
									<? 
									$staff_payrates = array();
									if ($staff['payrates'])
									{
										$staff_payrates = json_decode($staff['payrates']);
									}
									$payrates = modules::run('attribute/payrate/get_payrates');
									foreach($payrates as $payrate) { ?>
									<div class="row">
										<div class="col-md-1"><input type="checkbox" name="payrates[]" value="<?=$payrate['payrate_id'];?>"<?=(in_array($payrate['payrate_id'], $staff_payrates)) ? ' checked' : '';?> /> </div>
										<div class="col-md-11 label_checkbox"><?=$payrate['name'];?></div>
										
										
									</div>
									<? } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="option">
					<br />
                    Options
				</div>
				<div class="tab-pane" id="location">
					<br />
                    <div class="row">
						<div class="col-md-12">
                        	To add locations that this staff can work in select from the drop down list
                            <br /><br />
							<div class="form-group">
								
                                <!--<label for="title" class="col-lg-2 control-label">Select Locations</label>-->
                                
								<!--<div class="col-lg-10">-->

                                    
									
									<?=modules::run('common/dropdown_location', 's_loc', $staff['locations']);?>
									<? 									
									$staff_locations = array();
									if ($staff['locations'])
									{
										$staff_locations = json_decode($staff['locations']);
										/*
										$locations = modules::run('attribute/location/get_locations');
										for ($i=0; $i<count($locations);$i = $i+2) { ?>
										<div class="row">
											<div class="col-md-1"><input type="checkbox" name="locations[]" value="<?=$locations[$i]['location_id'];?>"<?=(in_array($locations[$i]['location_id'], $staff_locations)) ? ' checked' : '';?> /> </div>
											<div class="col-md-4 label_checkbox"><?=$locations[$i]['state'] . ' - ' . $locations[$i]['name'];?></div>
											<? if (isset($roles[$i+1])) { ?>
											<div class="col-md-1"><input type="checkbox" name="locations[]" value="<?=$locations[$i+1]['location_id'];?>"<?=(in_array($locations[$i+1]['location_id'], $staff_locations)) ? ' checked' : '';?> /> </div>
											<div class="col-md-4 label_checkbox"><?=$locations[$i]['state'] . ' - ' . $locations[$i+1]['name'];?></div>
											<? } ?>
										</div>
										<? } */ ?>
                                    <? } ?>
								<!--</div>-->
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="setting">
					
				</div>
				<div class="tab-pane" id="document">
					
					
				</div>
                <div class="tab-pane" id="picture">
					<div class="row">
						<div class="col-md-12">
                        	<h2> Your Images </h2>
                            <p> Upload photos of yourself so we have a visual refferance of you. 
                            	<br />Set your <b>primary profile image</b> by rolling over the images in your gallery and clicking the <i class="fa fa-heart"></i>
								<br />To <b>delete images</b>  roll over one of the images in your gallery and click the <i class="fa fa-times"></i>                        	
							</p>

                            <button type="button" class="btn btn-info" onclick="add_image(<?=$staff['staff_id']?>)"><i class="fa fa-upload"></i> Upload Image</button>
                            <br />
                            <br />
                            <div class="row">
                            	<div class="col-md-2" style="padding-left:0px;">
                                	<i class="fa fa-heart"></i> Profile Image <br /><br />
                                    <div class="profile_border">
                                    <? if($hero_photo){?> <img src="<?=base_url()?>uploads/staff/profile/<?=md5($staff['staff_id'])?>/thumbnail/<?=$hero_photo['name']?>"><? }else{?>
                                            <div class="no_photo">
                                                No Photo
                                            </div>
                                    <? } ?>
                                    </div>
                                    
                                </div>
                                <div class="col-md-10">
                                	<i class="fa fa-picture-o"></i> Your Gallery <br /><br />
                                     <? if($photos){?>
                                    <div id="carousel" class="flexslider gallery_staff">
                                      <ul class="slides popup-gallery">
                                       <?
                                            foreach($photos as $photo){
                                                $photo_src_full = base_url().'uploads/staff/profile/'.md5($staff['staff_id']).'/'.$photo['name'];                                    
                                                $thumb_src = base_url().'uploads/staff/profile/'.md5($staff['staff_id']).'/thumbnail/'.$photo['name'];
                                            ?>
                                                <li >
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
                            
						</div>
					</div>
					
				</div>
				
			</div>
			
                    <!-- Submit button -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-8">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update Staff</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                </form>
        </div>
    </div>
</div>
<!--end bottom box -->



<script>
$(function(){		
	
	//respond nav tabs		
	help.respond_nav_tab('.tab-respond li',992);
	
	$('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 230,
		itemMargin: 5,
		asNavFor: '#slider'
    });
	
	$('#navStaff a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	// $('#navStaff a[href="#super"]').tab('show');
	
	
	
	
	
	
	
	//$( "#s_fund_name" ).autocomplete({
		//source: availableTags
	//});
	//var availableTags = [
	//<? //=modules::run('common/list_supers');?>
	//];
});

$(window).resize(function(){
	help.respond_nav_tab('.tab-respond li',992);	
});//resize



function set_hero(id)
{
	$.ajax({
		url: '<?=base_url()?>common/setherophoto/',
		type: 'POST',
		data: ({staff_id:<?=$staff['staff_id']?>,photo_id:id}),
		dataType: "html",
		success: function(html) {			
			location.reload();
		}
	})		
}

function delete_photo(id)
{

	$.ajax({
		url: '<?=base_url()?>common/deletephoto/',
		type: 'POST',
		data: ({staff_id:<?=$staff['staff_id']?>,photo_id:id}),
		dataType: "html",
		success: function(html) {			
			location.reload();
		}
	})		
}
function add_image()
{
	$('#addImage').modal('show');
}
</script>

<link rel="stylesheet" href="<?=base_url()?>assets/js/flexjs/flexslider.css" type="text/css" media="screen" />
<script src="<?=base_url()?>assets/js/flexjs/modernizr.js"></script>
<script defer src="<?=base_url()?>assets/js/flexjs/jquery.flexslider.js"></script>             
<!-- Syntax Highlighter -->
<script type="text/javascript" src="<?=base_url()?>assets/js/flexjs/shCore.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/flexjs/shBrushXml.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/flexjs/shBrushJScript.js"></script>

<!-- Optional FlexSlider Additions -->
<script src="<?=base_url()?>assets/js/flexjs/jquery.easing.js"></script>
<script src="<?=base_url()?>assets/js/flexjs/jquery.mousewheel.js"></script>
<!--<script defer src="<?=base_url()?>assets/js/flexjs/demo.js"></script>   -->
