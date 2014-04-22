<table width="100%" cellpadding="10" cellspacing="0">
      <tr>
          <td colspan="3"><?=modules::run('setting/company_logo');?><br /><br /></td>
      </tr>
      <tr valign="top">
          <td width="50%" class="v-align-bottom info-sheet-text"> 
          		<?php if($user_data) { ?>         		
				<?=$user_data['first_name'].' '.$user_data['last_name'];?> <br />
                <?php } else{
					echo 'Not Assigned';	
				}?>
                <h2 class="info-sheet-h2">Information Sheet</h2>
          </td>
          <td width="50%">
          	  <table width="100%">
              		<tr  class="info-sheet-bolder-txt">
                    	<td colspan="2"><?=$company_info['company_name'];?></td>
                    </tr>
                    <tr  class="info-sheet-bolder-txt">
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr  class="info-sheet-bold-txt">
                    	<td width="40%">
                        	Head Office<br />
                            <?=$company_info['address'];?><br />
                            <?=$company_info['suburb'].' '.$company_info['state'].' '.$company_info['postcode'];?>
                        </td>
                        <td>
                        	Telephone: <?=$company_info['telephone'];?><br />
                            Email: <?=$company_info['email'];?><br />
                            Website: <?=$company_info['website_account'];?>
                        </td>
                    </tr>
              </table>
          </td>
</table>
<hr class="info-sheet-hr" />  
<table width="100%" class="info-sheet-details-table info-sheet-text">
	<?php if(modules::run('setting/get_information_sheet_config_status',1)){ ?>
	<tr>
    	<td class="info-sheet-label">Campaign Name:</td>
        <td class="info-sheet-bolder-txt"><?=$shift_info->campaign_name;?></td>
    </tr>
    <?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',2)){ ?>
    <tr>
    	<td class="info-sheet-label">Client Name:</td>
        <td class="info-sheet-bolder-txt"><?=$client['company_name'];?></td>
    </tr>
    <?php } ?>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <?php if(modules::run('setting/get_information_sheet_config_status',7)){ ?>
    <tr valign="top">
    	<td class="info-sheet-label">Venue:</td>
        <td class="info-sheet-bolder-txt">
        	<?php
				$venue_not_empty = $shift_info->venue_name.$shift_info->venue_address.$shift_info->venue_suburb.$shift_info->venue_postcode;
				$venue = $shift_info->venue_name.'<br />'.
						 $shift_info->venue_address.'<br />'.
						 $shift_info->venue_suburb.' '.$shift_info->venue_postcode;
				echo ($venue_not_empty ? $venue : 'Not Assigned');
			?>
        </td>
    </tr>
    <?php } ?>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <?php if(modules::run('setting/get_information_sheet_config_status',3)){ ?>
    <tr>
    	<td class="info-sheet-label">Shift Date:</td>
        <td class="info-sheet-bolder-txt"><?=date('l dS F Y',strtotime($shift_info->job_date));?></td>
    </tr>
    <?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',4)){ ?>
    <tr>
    	<td class="info-sheet-label">Shift Time:</td>
        <td class="info-sheet-bolder-txt"><?=date('H:i',$shift_info->start_time).' - '.date('H:i',$shift_info->finish_time);?></td>
    </tr>
    <?php } ?>
    <?php if( (modules::run('setting/get_information_sheet_config_status',5)) || (modules::run('setting/get_information_sheet_config_status',6)) ){ ?>
    <?php 
	if($breaks){ 
		foreach($breaks as $key=>$val){
	?>
    <?php if(modules::run('setting/get_information_sheet_config_status',5)){ ?>
    <tr>
    	<td class="info-sheet-label">Break:</td>
        <td class="info-sheet-bolder-txt"><?=$breaks[$key]->length/60;?> Mins</td>
    </tr>
   	<?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',6)){ ?>
    <tr>
    	<td class="info-sheet-label">Break Start:</td>
        <td class="info-sheet-bolder-txt"><?=date('H:i',$breaks[$key]->start_at);?></td>
    </tr>
    <?php } ?>
    <?		
		}
	}else{
	?>
    <tr>
    	<td class="info-sheet-label">Break:</td>
        <td class="info-sheet-bolder-txt">None</td>
    </tr>
	<?php		
	}
	?>
    <?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',8)){ ?>
    <tr>
    	<td class="info-sheet-label">Role:</td>
        <td class="info-sheet-bolder-txt"><?=$shift_info->role_name ? $shift_info->role_name : 'Not Assigned';?></td>
    </tr>
    <?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',9)){ ?>
    <tr>
    	<td class="info-sheet-label">Pay Rate:</td>
        <td class="info-sheet-bolder-txt">
        <?php if($payrate){?>
		<?=$payrate['name'] . ' ($' .modules::run('attribute/payrate/get_minimum_payrate',$shift_info->payrate_id).') penalty rates may apply';?>
        <?php }else{
			echo 'Not Assigned';	
		}?>
        </td>
    </tr>
    <?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',11)){ ?>
    <tr>
    	<td class="info-sheet-label">Uniform:</td>
        <td class="info-sheet-bolder-txt"><?=$shift_info->uniform_name ? $shift_info->uniform_name : 'Not Assigned';?></td>
    </tr>
    <?php } ?>
    <?php if(modules::run('setting/get_information_sheet_config_status',13)){ ?>
    <tr>
    	<td class="info-sheet-label">Expenses:</td>
        <td class="info-sheet-bolder-txt"><?=($shift_info->expenses ? $shift->expenses : 'None');?></td>
    </tr>
    <?php } ?>
</table>

<?php if(modules::run('setting/get_information_sheet_config_status',12) && count($shift_notes)){ ?>
<h2 class="info-sheet-h2">Notes:</h2>
	<ul class="shift-info-notes-ul">
	<?php foreach($shift_notes as $note){ ?>
		<li><?=nl2br($note->note);?></li>
	<?php } ?>
	</ul>
<?php } ?>
    
<?php if(modules::run('setting/get_information_sheet_config_status',10)){ ?>
	<?php if($supervisor){ ?>
        <table width="100%" class="info-sheet-details-table info-sheet-text">
            <tr>
                <td class="info-sheet-label">Time Sheet Supervisor:</td>
                <td class="info-sheet-bolder-txt">
                	<?php 
						$supervisor = $supervisor['first_name'].' '.$supervisor['last_name'];
					?>
					<?=trim($supervisor) ? $supervisor : 'Not Assigned';?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } ?>

<?php if(modules::run('setting/get_information_sheet_config_status',14)){ ?>
	<?php if($other_working_staffs){ ?>
    <hr class="info-sheet-hr" />
    <h2 class="info-sheet-h2">Other Staff Working</h2>
    <?php 
		foreach($other_working_staffs as $staff){ 
	?>
        <div class="avatar push">
            <?=modules::run('staff/profile_image',$staff->staff_id);?>
        </div>
    <?php 
		}
	}
	?>
<?php } ?>
<br /><br />
