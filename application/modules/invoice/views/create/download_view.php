<html>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
            	<td width="65%"><img src="<?=base_url()?>assets/img/core/staffmaster-logo.jpg"></td>
                <td width="5%">&nbsp;</td>
                <td valign="bottom" class="padding-left-15">Bill Enquiries</td>
            </tr>
            <tr>
                <td valign="top">                    
                    <table>
                       <tr>
                        <td class="padding-top-25">
                            <?=($invoice['profile_company_name'] != '') ? $invoice['profile_company_name'] : $company_profile['company_name'];?><br>
                            ABN: <?=($invoice['profile_abn'] != '') ? $invoice['profile_abn'] : $company_profile['abn_acn'];?><br>
                            <br><b><?=($invoice['client_company_name'] != '') ? $invoice['client_company_name'] : $client['company_name'];?><br>
                            <?=($invoice['client_address'] != '') ? $invoice['client_address'] : $client['address'];?><br>
                            <?=($invoice['client_suburb'] != '') ? $invoice['client_suburb'] : $client['suburb'];?> <?=($invoice['client_state'] != '') ? $invoice['client_state'] : $client['state'];?> <?=($invoice['client_postcode'] != '') ? $invoice['client_postcode'] : $client['postcode'];?><br>
                            </b>
                            <br>
                    	</td>
                       </tr>
                     </table>                    
                </td>
                <td>&nbsp;</td>
                <td class="padding-left-15" valign="top">           
                    <table>
                        <tr>
                            <td class="padding-top-25" style="width:100px;"><?=($invoice['client_company_name'] != '') ? $invoice['client_company_name'] : $client['company_name'];?></td> 
                        </tr>
                        <tr>
                            <td>Tel:</td> <td> <?=($invoice['client_phone'] != '') ? $invoice['client_phone'] : $client['phone'];?></td>
                        </tr>
                        <tr>
                            <td>Email:</td> <td><?=($invoice['client_email_address'] != '') ? $invoice['client_email_address'] : $client['email_address'];?></td>
                        </tr>
                        <tr>
                            <td>Invoice Number:</td> <td><?=($invoice['invoice_number'] != '') ? $invoice['invoice_number'] : $invoice['invoice_id'];?></td>
                        </tr>
                    </table>
                    
                </td>
            </tr>
            <tr >
            	<td valign="top" style="padding-top:50px;">
                	<h2 class="bottom-10 expense-break tax-title">Tax Invoice</h2>
                    
                    Issue Date: <?=date('dS M Y', strtotime($invoice['issued_date']));?><br><br>
                    <h1 class="top-20 invoice-title"> <?=$invoice['title'];?></h1>
                    <? if ($invoice['status'] == INVOICE_PAID) { ?>
                    <div id="badge-paid">
                    	<img src="<?=base_url();?>assets/img/paid.png" />
	                    <span><?=date('dS M Y', strtotime($invoice['paid_on']));?></span>
                    </div>
                    <? } ?>
                </td>
                <td>&nbsp;</td>
                <td>
                	<table cellpadding="0" cellspacing="0" class="bordernone">
                        <tr class="charge-box-header">
                            <td class="charge-box-header-td"><div >Charge Details</div></td>
                        </tr>
                        <tr class="charge-box-detail">
                            <td class="charge-box-detail-td">                                
                                <table cellpadding="0" cellspacing="0">
                                	<tr><td class="break-15" colspan="2">&nbsp;</td></tr>
                                    <tr>
                                    	<td class="charge-box-line charge-first-width"><h1 class="invoice-title">Total Due</h1></td>	
                                    	<td class="charge-box-line" align="right"><h1 class="invoice-title">$<?=money_format('%i', $invoice['total_amount']);?></h1></td>
                                    </tr>
                                    <tr><td class="padding-top-15"><h2 class="due-date">Due Date</h2></td>	<td class="padding-top-15" align="right"><h2 class="due-date"><?=date('dS M Y', strtotime($invoice['due_date']));?></h2></td></tr>
                                    <tr><td class="padding-gst">GST</td><td align="right" class="padding-gst">$<?=money_format('%i', $invoice['gst']);?></td></tr>
                                </table>
                            </td>
                        </tr>                    
                    </table>
                </td>
            </tr>
        </table>
        <br><br><br>
        <div class="line"></div>
        <table width="100%">
            <tr>
                <td colspan="3"><h2 class="expense-break">Expense Break Down</h2></td>
            </tr>
            
            <tr>
                <td width="51%" class="padding-top-10 padding-bottom-15">Description</td>
                <td width="15%" align="left">GST</td>
                <td align="left">Cost</td>
                <td align="left">Total</td>
            </tr>
		<?  $item_line=0;			
			foreach($items as $item) { if($item['job_id']) { ?>
            <tr>
                <td>
                    <? if ($item['include_timesheets']) { ?>
                    <?=$item['title'];?> - Staff Services
                    <? } else { ?>
                    <span class="indent"> <?=$item['title'];?></span>
                    <? } ?>
                </td>
                <td align="left">
                    <? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
                    $<?=money_format('%i', $item['amount']/11);?>
                    <? } ?>
                </td>
                <td align="left">
                    <? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
                    $<?=money_format('%i', $item['amount']/11*10);?>
                    <? } ?>
                </td>
                <td align="left">$<?=money_format('%i', $item['amount']);?></td>
            </tr>            
            <? 
				$item_line++;
			} } ?>
            
            
            
            <? foreach($items as $item) { if(!$item['job_id']) { ?>
            <tr>
                <td>
                    <?=$item['title'];?>
                </td>
                <td align="left">
                    <? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
                    $<?=money_format('%i', $item['amount']/11);?>
                    <? } ?>
                </td>
                <td align="left">
                    <? if($item['tax'] == GST_YES || $item['tax'] == GST_ADD) { ?>
                    $<?=money_format('%i', $item['amount']/11*10);?>
                    <? } ?>
                </td>
                <td align="left">
                    <? if($item['amount'] != 0) { ?>
                    $<?=money_format('%i', $item['amount']);?>
                    <? } ?>
                </td>
            </tr> 
            <? 
				$item_line++;
			} } ?>
            
        </table>
        <? $height = 170 - ($item_line*30); if($height<0){$height=0;}?>
        <table >
        	<tr>
            	<td style="height:<?=$height?>px;">&nbsp;</td>
            </tr>
        </table>
        
        <table>        	
            <tr>
            	<td class="padding-top-20"><b>Terms & Conditions of Payment</b><br></td>
            </tr>
            <tr>
            	<td><?=(isset($company_profile['term_and_conditions'])) ? $company_profile['term_and_conditions'] : '' ?></td>
            </tr>
        </table>
        <br>
        <div class="line"></div>
        <table>
            <tr>
                <td colspan="3"><h2 class="expense-break">How to Pay</h2></td>
            </tr>
            <tr>
                <td width="48%" style="padding-top:10px;"><b>Direct Deposit</b></td>
                <td width="5%"></td>
                <td width="47%" style="padding-top:10px;"><b><?=(isset($company_profile['company_name'])) ? $company_profile['company_name'] : '' ?></b></td>
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
            	<td colspan="3" style="padding-top:10px;">
            	    <b>Credit Card</b>
                    <br />      
                    <table width="100%">
                        <tr>
                            <td valign="top" class="padding-top-5 ccard"><img src="<?=base_url();?>assets/img/cc.png"></td>
                            <td class="padding-top-5">Call <?=(isset($company_profile['telephone'])) ? $company_profile['telephone'] : '' ?> to pay by Credit Card. <br>An Additional (1.5%) charge will be applied</td>
                        </tr>
                    </table>
            	</td>
            </tr>
        </table>
        
        
        <? if ($invoice['breakdown']) { ?>
        <pagebreak />
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
				<td colspan="8"><h2 class="expense-break"><?=$job['name'];?></h2></td>
			</tr>
			<tr>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Job Date</b></td>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Venue</b></td>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Start - Finish </b></td>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Break</b></td>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Hours</b></td>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Pay Rate</b></td>
				<td style="padding-top:8px;padding-bottom:5px;"><b>Total</b></td>
			</tr>
			<? foreach($timesheets as $timesheet) { 
				$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
			?>
			<tr>
                <td width="12%"><?=date('d-m-Y', $timesheet['start_time']);?></td>
                <td width="35%"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></td>
                <!-- <td width="15%"><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td> -->
                <td width="20%"><?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?> <?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-danger">*</span>': '';?></td>
                <td width="9%"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
                <td width="9%"><?=$timesheet['total_minutes']/60;?></td>
                <td width="9%"><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
                <td width="9%">$<?=$timesheet['total_amount_client'];?></td>
            </tr>
			<? } ?>
			<? } } ?>                       
        </table>
	</div>
</div>
	
</div>
<? } ?>
<br /><br /><br />
	</body>
</html>        