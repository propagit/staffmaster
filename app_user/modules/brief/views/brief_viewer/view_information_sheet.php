<table width="100%" cellpadding="10" cellspacing="0">
      <tr>
          <td colspan="3"><?=modules::run('setting/company_logo');?><br /><br /></td>
      </tr>
      <tr valign="top">
          <td width="50%" class="v-align-bottom">            		
				Staff Name<br />
                Information Sheet
          </td>
          <td width="50%">
          	  <table width="100%">
              		<tr>
                    	<td colspan="2"><?=$company_info['company_name'];?></td>
                    </tr>
                    <tr>
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

<?php
	//echo '<pre>'.print_r($shift_info,true).'</pre>';
	//echo '<pre>'.print_r($breaks,true).'</pre>';
?>
<table width="100%">
	<tr>
    	<td class="info-sheet-label">Campaign Name:</td>
        <td><?=$shift_info->campaign_name;?></td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Client Name:</td>
        <td><?=$shift_info->campaign_name;?></td>
    </tr>
    <tr valign="top">
    	<td width="info-sheet-label">Venue:</td>
        <td>
			<?=$shift_info->venue_name;?><br />
        	<?=$shift_info->venue_address;?><br />
        	<?=$shift_info->venue_suburb.' '.$shift_info->venue_postcode;?>
        </td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Shift Date:</td>
        <td><?=date('l dS F Y',strtotime($shift_info->job_date));?></td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Shift Time:</td>
        <td><?=date('H:i',$shift_info->start_time).' - '.date('H:i',$shift_info->finish_time);?></td>
    </tr>
    <?php 
	if($breaks){ 
		foreach($breaks as $key=>$val){
	?>
    <tr>
    	<td width="info-sheet-label">Break:</td>
        <td><?=$breaks[$key]->length/60;?> Mins</td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Break Start:</td>
        <td><?=date('H:i',$breaks[$key]->start_at);?></td>
    </tr>
    <?		
		}
	}
	?>
    
    <tr>
    	<td width="info-sheet-label">Role:</td>
        <td><?=$shift_info->role_name;?></td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Pay Rate:</td>
        <td><?=$payrate['name'] . ' ($' .modules::run('attribute/payrate/get_minimum_payrate',$shift_info->payrate_id).') penalty rates may apply';?></td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Uniform:</td>
        <td><?=$shift_info->uniform_name;?></td>
    </tr>
    <tr>
    	<td width="info-sheet-label">Expenses:</td>
        <td><?=($shift_info->expenses ? $shift->expenses : 'None');?></td>
    </tr>
</table>