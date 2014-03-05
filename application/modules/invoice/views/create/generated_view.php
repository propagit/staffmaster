<!--begin top box--->
<div class="col-md-12">
	<div class="wp-page-invoice">
        <table width="100%" cellpadding="10" cellspacing="0">
        	<tr>
        		<td colspan="3"><img src="<?=base_url()?>assets/img/core/staffmaster-logo.jpg"><br /><br /></td>
        	</tr>
            <tr valign="top">
            	<td width="50%">            		
            		<table>
                       <tr>
                        <td class="padding-top-15">
                            <?=($invoice['profile_company_name'] != '') ? $invoice['profile_company_name'] : $company_profile['company_name'];?><br>
                            ABN: <?=($invoice['profile_abn'] != '') ? $invoice['profile_abn'] : $company_profile['abn_acn'];?><br>
                            <br>
                            
                            <b>
                            <?=($invoice['client_company_name'] != '') ? $invoice['client_company_name'] : $client['company_name'];?><br>
                            <?=($invoice['client_address'] != '') ? $invoice['client_address'] : $client['address'];?><br>
                            <?=($invoice['client_suburb'] != '') ? $invoice['client_suburb'] : $client['suburb'];?> <?=($invoice['client_state'] != '') ? $invoice['client_state'] : $client['state'];?> <?=($invoice['client_postcode'] != '') ? $invoice['client_postcode'] : $client['postcode'];?>
                            </b>
                            <br>
                            <br>
                    	</td>
                       </tr>
                     </table> 
                     
            	</td>
                <td width="5%"></td>
                <td width="45%">
                	<b>Bill Enquiries</b><br />
                	<?=($invoice['client_company_name'] != '') ? $invoice['client_company_name'] : $client['company_name'];?><br />
                	<table>
                        <tr>
                            <td>Tel:</td><td width="20"></td> <td> <?=($invoice['client_phone'] != '') ? $invoice['client_phone'] : $client['phone'];?></td>
                        </tr>
                        <tr>
                            <td>Email:</td><td width="20"></td> <td><?=($invoice['client_email_address'] != '') ? $invoice['client_email_address'] : $client['email_address'];?></td>
                        </tr>
                        <tr>
                            <td>Invoice Number:</td><td width="20"></td> <td><?=($invoice['invoice_number'] != '') ? $invoice['invoice_number'] : $invoice['invoice_id'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            
            
            <tr>
            	<td valign="middle">
                	<h2>Tax Invoice</h2>                    
                    Issue Date: <?=date('dS M Y', strtotime($invoice['issued_date']));?><br>
                    <h1><?=$invoice['title'];?></h1>
                    <? if ($invoice['status'] == INVOICE_PAID) { ?>
                    <div id="badge-paid">
                    	<img src="<?=base_url();?>assets/img/paid.png" />
	                    <span><?=date('dS M Y', strtotime($invoice['paid_on']));?></span>
                    </div>
                    <? } ?>
                </td>
                <td></td>
                <td width="50%" align="right">
                	<table cellpadding="10" cellspacing="0" width="100%">
                        <tr class="charge-box-header">
                            <td><span style="color:#ffffff;">Charge Details</span></td>
                        </tr>
                        <tr class="charge-box-body">
                            <td>
                            	<div id="charge-details">
                            		<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td><h3>Total Due</h3></td>	
											<td align="right"><h3>$<?=money_format('%i', $invoice['total_amount']);?></h3></td>
										</tr>
										<tr>
											<td><h4>Due Date</h4></td>	
											<td align="right"><h4><?=date('dS M Y', strtotime($invoice['due_date']));?></h4></td>
										</tr>
										<tr>
											<td class="padding-gst">GST</td>			
											<td align="right" class="padding-gst">$<?=money_format('%i', $invoice['gst']);?></td>
										</tr> 
									</table>
                            	</div>
                            </td>
                        </tr>                    
                    </table>
                </td>
            </tr>
        </table>
        <br />
        <hr />        
        <div id="list-items">
        	<table width="100%" cellpadding="10">
				<tr>
				    <td colspan="3"><h3>Expense Break Down</h3></td>
				</tr>
				
				<tr>
				    <td width="50%">Description</td>
				    <td align="right" width="15%">GST</td>
				    <td align="right">Sub Total</td>
				    <td align="right">Total</td>
				</tr>
				<? foreach($items as $item) { if($item['job_id']) { ?>
				<tr>
					<td>
						<? if ($item['include_timesheets']) { ?>
						<b><?=$item['title'];?> - Staff Services</b>
						<? } else { ?>
						<span class="indent"> <?=$item['title'];?></span>
						<? } ?>
					</td>
					<td align="right">
						<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
						$<?=money_format('%i', $item['amount']/11);?>
						<? } ?>
					</td>
					<td align="right">
						<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
						$<?=money_format('%i', $item['amount']/11*10);?>
						<? } ?>
					</td>
					<td align="right">$<?=money_format('%i', $item['amount']);?></td>
				</tr>            
				<? } } ?>
				
				<? foreach($items as $item) { if(!$item['job_id']) { ?>
				<tr>
					<td>
						<?=$item['title'];?>
					</td>
					<td align="right">
						<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
						$<?=money_format('%i', $item['amount']/11);?>
						<? } ?>
					</td>
					<td align="right">
						<? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
						$<?=money_format('%i', $item['amount']/11*10);?>
						<? } ?>
					</td>
					<td align="right">
						<? if($item['amount'] != 0) { ?>
						$<?=money_format('%i', $item['amount']);?>
						<? } ?>
					</td>
				</tr> 
				<? } } ?>
			</table>
        </div>
        
        
        <br><br><br><br><br><br><br><br><br><br><br><br>
    	
        
        <b>Terms & Conditions of Payment</b><br />
        <?=(isset($company_profile['term_and_conditions'])) ? $company_profile['term_and_conditions'] : '' ?>
        
        <br>
        <hr />
        <table>
            <tr>
                <td colspan="3"><h2>How to Pay</h2></td>
            </tr>
            <tr>
                <td width="50%"><b>Direct Deposit</b></td>
                <td width="10%"></td>
                <td><b><?=(isset($company_profile['company_name'])) ? $company_profile['company_name'] : '' ?></b></td>
            </tr>
            <b>
            <tr valign="top">
                <td>
                    <table>
                        <tr valign="top">
                            <td>Account Name:</td><td width="20"></td> <td> <?=(isset($company_profile['bank_account_name'])) ? $company_profile['bank_account_name'] : '' ?></td>
                        </tr>
                        <tr>
                            <td>BSB:</td><td width="20"></td> <td> <?=(isset($company_profile['bank_bsb'])) ? $company_profile['bank_bsb'] : '' ?></td>
                        </tr>
                        <tr>
                            <td>Account:</td><td width="20"></td> <td><?=(isset($company_profile['bank_account_no'])) ? $company_profile['bank_account_no'] : '' ?></td>
                        </tr>
                    </table>
                </td>
                <td></td>
                <td>
                	<table>
                        <tr valign="top">
                            <td>
                            	Head Office:<br />
	                            <?=(isset($company_profile['address'])) ? $company_profile['address'] : '' ?><br />
	                            <?=(isset($company_profile['suburb'])) ? $company_profile['suburb'] : '' ?><?=(isset($company_profile['state'])) ? $company_profile['state'] : '' ?><br />
	                            <?=(isset($company_profile['country'])) ? $company_profile['country'] : '' ?> <?=(isset($company_profile['postcode'])) ? $company_profile['postcode'] : '' ?>
                            </td> 
                            <td width="20"></td> 
                            <td> 
                            	Telephone: <?=(isset($company_profile['telephone'])) ? $company_profile['telephone'] : '' ?><br />
	                            Email: <?=(isset($company_profile['email'])) ? $company_profile['email'] : '' ?><br />
	                            Website: <?=(isset($company_profile['website_account'])) ? $company_profile['website_account'] : '' ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td colspan="3">
            	    <b>Credit Card</b>
                    <br />      
                    <table width="100%">
                        <tr>
                            <td valign="top"><img src="<?=base_url();?>assets/img/cc.png"></td>
                            <td>Call <?=(isset($company_profile['telephone'])) ? $company_profile['telephone'] : '' ?> to pay by Credit Card. An Additional (1.5%) charge will be applied</td>
                        </tr>
                    </table>
            	</td>
            </tr>
        </table>
    </div>
</div>
<!--end top box-->
<? if ($invoice['breakdown']) { ?>
<div id="wp-breakdown">
<div class="col-md-12">
	<div class="wp-page-invoice">
		<table width="100%">
			<? foreach($items as $item) { 
			if ($item['include_timesheets']) {
			$job = modules::run('job/get_job', $item['job_id']);
			$timesheets = modules::run('invoice/get_job_timesheets', $item['job_id'], INVOICE_GENERATED);
			 ?>
			<tr>
				<td colspan="8"><h2><?=$job['name'];?></h2></td>
			</tr>
			<tr>
				<td>Job Date</td>
				<td>Venue</td>
				<td>Start Time - Finish Time</td>
				<td>Break</td>
				<td>Hours</td>
				<td>Pay Rate</td>
				<td>Total</td>
			</tr>
			<? foreach($timesheets as $timesheet) { 
				$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
			?>
			<tr>
                <td width="10%"><?=date('d-m-Y', $timesheet['start_time']);?></td>
                <td width="30%"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></td>
                <!-- <td width="15%"><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td> -->
                <td width="20%"><?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?> <?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-danger">*</span>': '';?></td>
                <td width="10%"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
                <td width="10%"><?=$timesheet['total_minutes']/60;?></td>
                <td width="10%"><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
                <td width="10%">$<?=$timesheet['total_amount_client'];?></td>
            </tr>
			<? } ?>
			<? } } ?>                       
        </table>
	</div>
</div>
	
</div>
<? } ?>
<br /><br /><br />
<script>
$(function(){
	$('#btn-generate-invoice').remove();
	$('#btn-reset-invoice').html('<i class="fa fa-times"></i> Close');
	$('#btn-reset-invoice').click(function(){
		window.close();
	});
	$('#btn-download-invoice').click(function(){
		$(this).prop('target', '_blank');
		window.open('<?=base_url();?>invoice/download/<?=$invoice['invoice_id'];?>');
	})
})
</script>