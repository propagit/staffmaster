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
                    <h1>Services Rended</h1>
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
            	<td align="right">
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