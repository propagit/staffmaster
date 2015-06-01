<hr />
<h2>Search Results</h2>
<ul class="pagination custom-pagination pull">
<?=modules::run('common/create_pagination',count($total_invoices),INVOICE_PER_PAGE,$current_page)?>
</ul>
<p>Your search returned <b><?=count($total_invoices);?></b> results</p>

<? if (count($invoices) > 0) { ?>
	<? if (!$is_client) { ?>
	<div id="nav_invoices" class="action-nav-with-pagination">
	<?
		# Action menu
		$data = array(
			array('value' => 'export', 'label' => 'Export Selected'),
			array('value' => 'mark_unpaid', 'label' => 'Mark Selected as Unpaid'),
			array('value' => 'mark_paid', 'label' => 'Mark Selected as Paid'),
			#array('value' => 'email', 'label' => 'Email Invoice to Client')
			#array('value' => 'mark_deleted', 'label' => 'Mark Selected as Deleted')
		);
		echo modules::run('common/menu_dropdown', $data, 'invoice-action', 'Actions');
	?>
	</div>
	<? } else { echo '<br />'; } ?>
<div class="table-responsive">
<form>
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<? if (!$is_client) { ?>
		<th class="center" width="20"><input type="checkbox" id="selected_all_invoices" /></th>
			<? if ($accounting_platform = $this->config_model->get('accounting_platform')) { ?>
			<th class="center">External ID</th>
			<? } ?>
		<? } ?>
		<th class="center" width="80">Issued <i class="fa fa-sort sort-result" sort-by="issued_date"></i></th>
		<th class="center" width="80">Due <i class="fa fa-sort sort-result" sort-by="due_date"></i></th>
		<th class="center">Inv # <i class="fa fa-sort sort-result" sort-by="invoice_number"></i></th>
		<th class="center">PO # <i class="fa fa-sort sort-result" sort-by="po_number"></i></th>
		<? if (!$is_client) { ?>
		<th>Client Name </th>
		<? } ?>
		<th>Invoice Title <i class="fa fa-sort sort-result" sort-by="title"></i></th>
		<th class="center">Amount <i class="fa fa-sort sort-result" sort-by="total_amount"></i></th>
		<th>Issued By</th>
		<th class="center" width="120">Status <i class="fa fa-sort sort-result" sort-by="status"></i></th>
		<th class="center" width="40">View</th>
		<? if (!$is_client) { ?>
		<th class="center" width="40">Email</th>
		<? } ?>
	</tr>
</thead>
<tbody>
<? foreach($invoices as $invoice) { 
	$client = modules::run('client/get_client', $invoice['client_id']);
	$user = modules::run('user/get_user', $invoice['issued_by']);
?>
	<tr>
		<? if (!$is_client) { ?>
		<td><input type="checkbox" class="selected_invoice" value="<?=$invoice['invoice_id'];?>" data-id="<?=$invoice['invoice_id'];?>" /></td>
			<? if ($accounting_platform == 'shoebooks') { ?>
			<td class="center">
				<? if ($invoice['external_id']) { echo $invoice['external_id']; }
				else { ?>
				<button type="button" class="btn btn-primary btn-block btn-push-shoebooks" data-id="<?=$invoice['invoice_id'];?>" data-loading-text="Pushing...">Push</button>
				<? } ?>
			</td>
			<? } else if ($accounting_platform == 'myob') { ?>
			<td class="center">
				<? if ($invoice['external_id']) { echo $invoice['external_id']; }
				else { ?>
				<button type="button" class="btn btn-myob btn-block btn-push-myob" data-id="<?=$invoice['invoice_id'];?>" data-loading="Pushing...">Push</button>
				<? } ?>
			</td>
			<? } ?>
		<? } ?>
		<td class="wp-date center" width="80">
			<span class="wk_day"><?=date('D', strtotime($invoice['issued_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($invoice['issued_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($invoice['issued_date']));?></span>
		</td>
		<td class="wp-date center" width="80">
			<span class="wk_day"><?=date('D', strtotime($invoice['due_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($invoice['due_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($invoice['due_date']));?></span>
		</td>
		<td class="center"><?=($invoice['invoice_number'] != '') ? $invoice['invoice_number'] : $invoice['invoice_id'];?></td>
		<td class="center"><?=($invoice['po_number'] != '') ? $invoice['po_number'] : 'Unspecified';?></td>
		<? if (!$is_client) { ?>
		<td><?=$client['company_name'];?></td>
		<? } ?>
		<td><?=$invoice['title'];?></td>
		<td class="center">$<?=money_format('%i', $invoice['total_amount']);?></td>
		<td><?=$user['first_name'] . ' ' . $user['last_name'];?></td>
		<td class="center" id="invoice-status-<?=$invoice['invoice_id'];?>">
			<?=modules::run('invoice/menu_dropdown_status', $invoice['invoice_id']);?>
		</td>
		<td class="center"><a href="<?=base_url();?>invoice/view/<?=$invoice['invoice_id'];?>" target="_blank"><i class="fa fa-eye"></i></a></td>
		<? if (!$is_client) { ?>
		<td class="center"><a><i class="fa fa-envelope-o email-invoice" data-invoice-id="<?=$invoice['invoice_id'];?>" data-user-id="<?=$invoice['client_id']?>"></i></a></td>
		<? } ?>
	</tr>
<? } ?>
</tbody>
</table>
</form>
<? } ?>
<div id="ajax-email-invoice-modal"></div>
<form id="single-invoice-email-form">
<input type="hidden" id="selected-user-id" name="user_staff_selected_user_id[]" value="" />
<input type="hidden" name="email_modal_header" value="Invoice Client" />
<input type="hidden" name="email_template_id" value="<?=CLIENT_INVOICE_EMAIL_TEMPLATE_ID;?>" />
<input type="hidden" id="selected-invoice-id" name="selected_module_ids[]" value="" />
<?php $allowed_email_templates = array(CLIENT_INVOICE_EMAIL_TEMPLATE_ID);?>
<input type="hidden" name="allowed_template_ids" value="<?=json_encode($allowed_email_templates);?>" />
</form>
<script>
$(function(){
	var selected_invoices = new Array();
	$('#selected_all_invoices').click(function(){
		$('input.selected_invoice').prop('checked', this.checked);	
		$('input.selected_users').prop('checked', this.checked);	
	});
	
	$('#menu-invoice-action ul li a[data-value="export"]').click(function(){
		selected_invoices.length = 0;
		$('.selected_invoice:checked').each(function(){
			selected_invoices.push($(this).val());
		});
		var ids = selected_invoices.join(',');
		if (ids != '') {
			$('.bs-modal-lg').modal({
				remote: '<?=base_url();?>invoice/ajax/load_export_modal/' + encodeURIComponent(ids),
				show: true
			});
		}		
	});
	$('#menu-invoice-action ul li a[data-value="mark_unpaid"]').click(function(){
		$('.selected_invoice:checked').each(function(){
			mark_as_unpaid($(this).val());
		});	
	});
	$('#menu-invoice-action ul li a[data-value="mark_paid"]').click(function(){
		$('.selected_invoice:checked').each(function(){
			mark_as_paid($(this).val());
		});	
	});
	$('#menu-invoice-action ul li a[data-value="mark_deleted"]').confirmModal({
		confirmTitle: 'Delete selected invoices',
		confirmMessage: 'Are you sure you want to delete selected invoices?',
		confirmCallback: function(e) {
			selected_invoices.length = 0;
			$('.selected_invoice:checked').each(function(){
				selected_invoices.push($(this).val());
			});
			$.ajax({
				type: "POST",
				url: base_url + 'invoice/ajax/delete_invoices',
				data: {invoices: selected_invoices},
				success: function(data) {
					reset_current_page();
					search_invoices();
				}
			})
		}
	});
	
	//get email modal
	$('.email-invoice').on('click',function(){
		$('#selected-user-id').val($(this).attr('data-user-id'));
		$('#selected-invoice-id').val($(this).attr('data-invoice-id'));
		get_email_model('#single-invoice-email-form');

	});
	$('.btn-push-shoebooks').click(function(){
		var btn = $(this);
		btn.button('loading');
		var invoice_id = $(this).attr('data-id');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>invoice/ajax/push_shoebooks",
			data: {invoice_id: invoice_id},
			success: function(html) {
				btn.button('reset');
				btn.parent().html(html);
			}
		})
	});
	$('.btn-push-myob').click(function(){
		var btn = $(this);
		btn.button('loading');
		var invoice_id = $(this).attr('data-id');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>invoice/ajax/push_myob",
			data: {invoice_id: invoice_id},
			success: function(data) {
				btn.button('reset');
				data = $.parseJSON(data);
				if (data.ok)
				{					
					btn.parent().html(data.msg);
				}
				else
				{
					
					$('#order-message').html('<h2>Push Results</h2><div class="alert alert-danger">' + data.msg + '</div>');
					$('#waitingModal').modal('show');
				}				
			}
		})
	});
});//ready
function mark_as_paid(invoice_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/mark_as_paid",
		data: {invoice_id: invoice_id},
		success: function(html) {
			$('#invoice-status-' + invoice_id).html(html);
		}
	})
}
function mark_as_unpaid(invoice_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/mark_as_unpaid",
		data: {invoice_id: invoice_id},
		success: function(html) {
			$('#invoice-status-' + invoice_id).html(html);
		}
	})
}


function get_email_model(form_id){
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/get_send_email_modal",
		  data: $(form_id).serialize(),
		  success: function(html) {
			  $('#ajax-email-invoice-modal').html(html);
			  $('#email-modal').modal('show');	
		  }
	  });
		
}
//this function is called from invoice/views/search_form
//this is because if included in this page an event listner will be added for each time a search request is made and multiple email request will be triggered
function email_invoice(){
	//update_ckeditor() function in send_email_modal view file
	preloading($('#send-email-modal-window'));
	update_ckeditor();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/email_invoice",
		data: $('#send-email-modal-form').serialize(),
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);
			setTimeout(function(){
				$('#email-modal').modal('hide');
			}, 4000);
		}
	}); 
}

function email_sample_invoice(){
	//update_ckeditor() function in send_email_modal view file
	preloading($('#send-email-modal-window'));
	update_ckeditor();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/email_sample_invoice",
		data: $('#send-email-modal-form').serialize(),
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);
		}
	}); 	
}

$(function(){
	$('.sort-result').on('click',function(){
		var sort_order = $('#sort-order').val();
		$('#sort-order').val(sort_order == 'asc' ? 'desc' : 'asc');
		$('#sort-by').val($(this).attr('sort-by'));
		reset_current_page();
		search_invoices();
	});	
	
	//go to page
	$('.pagination li').on('click',function(e){
		e.preventDefault();
		var clicked_page = $(this).attr('data-page-no');
		$('#current_page').val(clicked_page);
		search_invoices();
	}); 
});//ready


</script>