<html>
<body>

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
                            Company Name<br>
                            ABN: 123 456 789<br>
                            <br>
                            
                            <b>
                            <?=$client['company_name'];?><br>
                            <?=$client['address'];?><br>
                            <?=$client['suburb'];?> <?=$client['state'];?> <?=$client['postcode'];?>
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
                	<?=$client['company_name'];?><br />
                	<table>
                        <tr>
                            <td>Tel:</td><td width="20"></td> <td> <?=$client['phone'];?></td>
                        </tr>
                        <tr>
                            <td>Email:</td><td width="20"></td> <td><?=$client['email_address'];?></td>
                        </tr>
                        <tr>
                            <td>Invoice Number:</td><td width="20"></td> <td>smFRE-001</td>
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
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eu tincidunt dui. Maecenas gravida euismod hendrerit. Nullam porta odio in neque suscipit, at fermentum lorem interdum. Mauris nec odio tempus, molestie mauris a, posuere urna. Donec augue nisi, tincidunt quis justo non, ultricies malesuada risus. Vivamus imperdiet purus eros, ut blandit felis ultricies eu. Nullam nec nulla erat. Sed vulputate quis quam eu bibendum. Sed sed ultricies ante. Integer id faucibus mauris.
        
        <br>
        <hr />
        <table>
            <tr>
                <td colspan="3"><h2>How to Pay</h2></td>
            </tr>
            <tr>
                <td width="50%"><b>Direct Deposit</b></td>
                <td width="10%"></td>
                <td><b>Fresh Events + People Pty Ltd</b></td>
            </tr>
            <b>
            <tr valign="top">
                <td>
                    <table>
                        <tr valign="top">
                            <td>Account Name:</td><td width="20"></td> <td> Fresh Events</td>
                        </tr>
                        <tr>
                            <td>BSB:</td><td width="20"></td> <td> 034722</td>
                        </tr>
                        <tr>
                            <td>Account:</td><td width="20"></td> <td>209321</td>
                        </tr>
                    </table>
                </td>
                <td></td>
                <td>
                	<table>
                        <tr valign="top">
                            <td>
                            	Head Office:<br />
	                            31 Jeays Street<br />
	                            Bowen Hills QLD<br />
	                            Australia 4006
                            </td> 
                            <td width="20"></td> 
                            <td> 
                            	Telephone: (07) 3852 2211<br />
	                            Email: admin@freshevents.net.au<br />
	                            Website: wwww.freshevents.net.au
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
                            <td>Call (07) 3852 2211 to pay by Credit Card. An Additional (1.5%) charge will be applied</td>
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

</body>
</html>