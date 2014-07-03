<!--begin top box--->
<div class="col-md-12">
	<div class="wp-page-invoice">
        <table width="100%" cellpadding="10" cellspacing="0">
        	<tr>
        		<td colspan="3"><?=modules::run('setting/company_logo');?><br /><br /></td>
        	</tr>
            <tr valign="top">
            	<td width="50%">            		
            		<table>
                       <tr>
                        <td class="padding-top-15">
                            <a href="#" class="inv_company_name prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Company Name">
                            	<?=($invoice['profile_company_name'] != '') ? $invoice['profile_company_name'] : $company_profile['company_name'];?>
                            </a><br>
                            ABN: <a href="#" class="inv_company_abn prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="ABN">								
                                <?=($invoice['profile_abn'] != '') ? $invoice['profile_abn'] : $company_profile['abn_acn'];?>
                            </a><br>
                            <br>
                            
                            <b>
                            <a href="#" class="inv_client_company_name prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Company Name">
								<?=($invoice['client_company_name'] != '') ? $invoice['client_company_name'] : $client['company_name'];?>
                            </a><br>
                            
                            <a href="#" class="inv_client_address prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Address">
								<?=($invoice['client_address'] != '') ? $invoice['client_address'] : $client['address'];?>
                            </a><br>
                            
                            <a href="#" class="inv_client_suburb prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Suburb"><?=($invoice['client_suburb'] != '') ? $invoice['client_suburb'] : $client['suburb'];?></a> 
                            <a href="#" class="inv_client_state prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client State"><?=($invoice['client_state'] != '') ? $invoice['client_state'] : $client['state'];?></a> 
                            <a href="#" class="inv_client_postcode prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Postcode"><?=($invoice['client_postcode'] != '') ? $invoice['client_postcode'] : $client['postcode'];?></a>
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
                	<a href="#" class="inv_company_name prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Company Name">
						<?=($invoice['profile_company_name'] != '') ? $invoice['profile_company_name'] : $company_profile['company_name'];?>
                    </a>
					<br />
                	<table>
                        <tr>
                            <td>Tel:</td><td width="20"></td> <td> 
                            	<a href="#" class="inv_profile_phone prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Phone"><?=($invoice['profile_company_phone'] != '') ? $invoice['profile_company_phone'] : $company_profile['telephone'];?></a> 							
							</td>
                        </tr>
                        <tr>
                            <td>Email:</td><td width="20"></td> <td>
								<a href="#" class="inv_profile_email prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Client Email Address">
								<?=($invoice['profile_company_email'] != '') ? $invoice['profile_company_email'] : $company_profile['email'];?></a> 															
                            </td>
                        </tr>
                        <tr>
                            <td>Invoice Number:</td><td width="20"></td> 
                            <td><a href="#" class="inv_number prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Invoice Number"><?=($invoice['invoice_number'] != '') ? $invoice['invoice_number'] : $invoice['invoice_id'];?></a></td>
                        </tr>
                        <tr>
                            <td>PO Number:</td><td width="20"></td> 
                            <td><a href="#" class="po_number invoice-grey prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="PO Number"><?=($invoice['po_number'] != '') ? $invoice['po_number'] : 'Unspecified';?></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td valign="middle">
                	<h2>Tax Invoice</h2>                    
                    Issue Date: <a href="#" class="inv_company_issue_date prim-color-to-txt-color" data-type="date"  data-pk="<?=$invoice['invoice_id']?>" data-title="Issue Date"><?=date('jS M Y', strtotime($invoice['issued_date']));?></a><br>
                    <h1><a href="#" class="inv_title prim-color-to-txt-color" data-type="text"  data-pk="<?=$invoice['invoice_id']?>" data-title="Invoice Title"><?=$invoice['title']?></a></h1>
                </td>
                <td></td>
                <td>
                	<table cellpadding="10" cellspacing="0" width="100%">
                        <tr class="charge-box-header">
                            <td>Charge Details</td>
                        </tr>
                        <tr class="charge-box-body">
                            <td>
                            	<div id="charge-details">
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
        
        </div>
        
        <form id="addItemForm">
        <input type="hidden" name="invoice_id" value="<?=$invoice['invoice_id'];?>" />
        <table width="100%" cellpadding="10" class="charge-box-body">
        	<tr>
        		<td>Description</td>
        		<td width="200">GST</td>
        		<td align="right" width="200">Amount</td>
        		<td>Campaign</td>
        		<td width="20"></td>
        	</tr>
            <tr>
            	<td>
            		<input type="text" class="form-control" name="title" placeholder="Enter item title" />
            	</td>
            	<td>
	            	<?=modules::run('common/field_select_gst', 'tax');?>
            	</td>
            	<td>
            		<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" name="amount">
					</div>
            	</td>
            	<td>
            		<?=modules::run('common/field_select', unserialize($invoice['jobs']), 'job_id');?>
            	</td>
            	<td align="right">
            		<a id="btn-add-item" class="btn btn-core"><i class="fa fa-plus"></i></a>
            	</td>
            </tr>
        </table>
        </form>
        <br><br><br><br><br><br><br><br><br><br><br><br>
    	<div class="checkbox">
    		<input type="checkbox" id="full_breakdown" <?=($invoice['breakdown']) ? 'checked' : '';?> /> 
    		For a full itemised breakdown of this invoice please refer to page 2
    	</div>
        
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
	                            <?=(isset($company_profile['suburb'])) ? $company_profile['suburb'] : '' ?><?=(isset($company_profile['state'])) ? $company_profile['state'] : '' ?> <br />
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

<div id="wp-breakdown"></div>
<br /><br /><br />
<script>
$(function(){
	list_items();
	load_breakdown();
	$('#btn-add-item').click(function(){
		add_item();
	});
	$('#btn-reset-invoice').click(function(){
		reset_invoice();
	});
	$('#btn-generate-invoice').click(function(){
		generate_invoice();
	});
	$('#full_breakdown').click(function(){
		load_breakdown();
	});
	
	$('#btn-download-invoice').parent().addClass('disabled');
	$('#btn-email-invoice').parent().addClass('disabled');
	
	
	$('.inv_profile_phone').editable({
		url: '<?=base_url();?>invoice/ajax/edit_invoice_profile_phone',		
	});
	
	$('.inv_profile_email').editable({
		url: '<?=base_url();?>invoice/ajax/edit_invoice_profile_email',		
	});
	
	$('.inv_company_name').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_company_name',		
	});
	
	$('.inv_client_company_name').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_company_name',		
	});
	
	$('.inv_company_abn').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_company_abn',		
	});
	
	$('.inv_title').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_title',		
	});
	
	$('.inv_company_issue_date').editable({
		  format: 'yyyy-mm-dd hh:ii',
		  viewformat: 'dd M yyyy',
		  datepicker: {
		     weekStart: 1
		  }	,	
		  url: '<?=base_url();?>invoice/ajax/edit_client_invoice_issued_date',
		  
	});
	
	$('.inv_number').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_number',		
	});
	
	$('.po_number').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_po_number',	
	});
	
	$('.inv_client_address').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_address',		
	});
	
	$('.inv_client_suburb').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_suburb',		
	});
	
	$('.inv_client_state').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_state',		
	});
	
	$('.inv_client_postcode').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_postcode',		
	});
	
	$('.inv_client_phone').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_phone',		
	});
	
	$('.inv_client_email_address').editable({
		url: '<?=base_url();?>invoice/ajax/edit_client_invoice_client_email_address',		
	});
})
function generate_invoice() {
	window.location = '<?=base_url();?>invoice/generate/<?=$invoice['invoice_id'];?>';
}
function add_item() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/add_item",
		data: $('#addItemForm').serialize(),
		success: function(html) {
			list_items();
			$('#addItemForm')[0].reset();
		}
	})
}
function reset_invoice() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/delete_invoice",
		data: {invoice_id: <?=$invoice['invoice_id'];?>},
		success: function(html) {
			window.location = '<?=base_url();?>invoice/create/<?=$invoice['client_id'];?>';
		}
	})
}
function load_breakdown() {
	var show = $('#full_breakdown').is(':checked');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/show_breakdown",
		data: {invoice_id: <?=$invoice['invoice_id'];?>, show: show},
		success: function(html) {
			$('#wp-breakdown').html(html);
		}
	})
}
function check_breakdown() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/check_breakdown",
		data: {invoice_id: <?=$invoice['invoice_id'];?>},
		success: function(html) {
			if (html == "false") {
				$('#full_breakdown').attr('checked', false);
				$('#full_breakdown').attr('disabled', true);
			} else {
				$('#full_breakdown').attr('disabled', false);
			}
		}
	})
}
function list_items() {
	preloading($('#list-items'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/list_items",
		data: {invoice_id: <?=$invoice['invoice_id'];?>},
		success: function(html) {
			loaded($('#list-items'), html);
			get_total();
			check_breakdown();
		}
	})
}
function delete_item(item_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/delete_item",
		data: {item_id: item_id},
		success: function(html) {
			list_items();
		}
	})
}
function get_total() {
	preloading($('#charge-details'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/get_total",
		data: {invoice_id: <?=$invoice['invoice_id'];?>},
		success: function(html) {
			loaded($('#charge-details'), html);
		}
	})
}
</script>