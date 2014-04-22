<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<div class="pull-right">
        	<?=modules::run('account/box_credits');?>
        </div>
		<h2>Buy Credits</h2>
        <p>The Staff Master system uses a credit based system where by you only pay for what you use.<br />You can top up your balance any time. The price matrix provides a discount based on bulk purchases.</p>
	</div>
</div>
<!--end top box-->


<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
    		<h2>Pricing & Charges</h2>
    		<p>1 system credit allows you to create 1 shift for 1 staff</p>
    		<div class="row">
    		<? foreach($prices as $price) { ?>
				<div class="box_credits col-md-2">
	    			<div class="title_bc">Buy <?=$price['min'];?>-<?=$price['max'];?> Credits</div>
	    			<div class="content_bc">
	    				<h2>$<?=money_format('%i', $price['unit_price']);?></h2>
	    				per credit
	    			</div>
	    		</div>
    		<? } ?>
    			<div class="box_credits col-md-2">
	    			<div class="title_bc">Buy 25,000+ Credits</div>
	    			<div class="content_bc">
	    				<h2>Call Us</h2>&nbsp; 
	    			</div>
	    		</div>
    		</div>
    		<br /><br />
    		<form class="form-horizontal" id="form_buy_credits" role="form">
    		<div class="row">
    			<div class="col-md-6 remove-left-padding">
					<h2>Buy Credits</h2>
					<p>Enter the number of credits you would like to purchase</p>
					<br />
		    		<div class="row">
						<div class="form-group" id="f_credits">
							<label for="credits" class="col-md-4 control-label">Purchase Credits:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="credits" name="credits" tabindex="2" />
							</div>
							<div class="col-md-3 remove-left-padding">
								<span class="btn btn-core" id="btn-add-credits"><i class="fa fa-plus"></i> Add</span>
							</div>
						</div>
					</div>
					<div id="purchase-summary">
						
					</div>
    			</div>
    			<div class="col-md-6 hide" id="pay-now">
    				<h2>Billing Details</h2>
    				<p>Enter your billing address information</p>
    				<br />
    				<div class="row">
						<div class="form-group">
							<div id="f_firstname">
								<label for="firstname" class="col-md-2 control-label">First Name</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="firstname" name="firstname" />
								</div>
							</div>
							<div id="f_lastname">
								<label for="lastname" class="col-md-2 control-label">Last Name</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="lastname" name="lastname" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group" id="f_address">
							<label for="address" class="col-md-2 control-label">Address</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="address" name="address" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div id="f_city">
								<label for="city" class="col-md-2 control-label">City</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="city" name="city" />
								</div>
							</div>
							<div id="f_postcode">
								<label for="postcode" class="col-md-2 control-label">Postcode</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="postcode" name="postcode" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div id="f_state">
								<label for="card_name" class="col-md-2 control-label">State</label>
								<div class="col-md-4">
									<?=modules::run('common/field_select_states', 'state');?>
								</div>
							</div>
							<div id="f_country">
								<label for="card_name" class="col-md-2 control-label">Country</label>
								<div class="col-md-4">
									<?=modules::run('common/field_select_countries', 'country');?>
								</div>
							</div>
						</div>
					</div>
    				<br />
    				<div class="pull-right">
<!-- Begin eWAY Linking Code -->
<div id="eWAYBlock">
    <div style="text-align:center;">
        <a href="http://www.eway.com.au/secure-site-seal?i=10&s=3&pid=e83ce480-5cfc-4461-80c1-a02cb5205d58" title="eWAY Payment Gateway" target="_blank" rel="nofollow">
            <img alt="eWAY Payment Gateway" src="https://www.eway.com.au/developer/payment-code/verified-seal.ashx?img=10&size=3&pid=e83ce480-5cfc-4461-80c1-a02cb5205d58" width="120" />
        </a>
    </div>
</div>
<!-- End eWAY Linking Code -->
    				</div>
    				<h2>Payment</h2>
    				<p>Enter your credit card details to make a secure online payment</p>
    				<br />
    				<div class="row">
						<div class="form-group" id="f_ccname">
							<label for="ccname" class="col-md-4 control-label">Name On Card:</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="ccname" name="ccname" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group" id="f_ccnumber">
							<label for="ccnumber" class="col-md-4 control-label">Card Number:</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="ccnumber" name="ccnumber" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label for="card_number" class="col-md-4 control-label">Expiry Date (MM/YYYY)</label>
							<div class="col-md-2">
								<?=modules::run('common/field_select_month','expmonth');?>
							</div>
							<div class="col-md-3">
								<?=modules::run('common/field_select_year','expyear');?>
							</div>
							<div id="f_ccv">
								<label for="ccv" class="col-md-1 control-label">Secure </label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="ccv" id="ccv" placeholder="CCV" />
								</div>
							</div>
						</div>
					</div>
					<div class="pull-right">
						<button type="button" class="btn btn-core" id="btn-buy-credits">Pay Now</button>
					</div>
    			</div>
    		</div>
    		</form>
    	</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			<p>Please wait a moment while we are processing your payment details ...</p>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="credit-alert">
			<div class="modal-body">
				<h2 class="text-danger">System Alert!</h2>
				<p>Your credit balance is currently <b class="text-danger"><?=$credits;?></b>. To top up your credit balance and continue using the system please update your credit balance.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-core" data-dismiss="modal">Buy Credits</button>
			</div>
		</div>		
	</div>
</div>

<script>
$(function(){
	<? if ($credits < 0) { ?>
	$('#alertModal').modal({
		show: true
	})
	<? } ?>
	$('#btn-add-credits').click(function(){
		calculate_amount();
	});
	$('#btn-buy-credits').click(function(){
		$('#waitingModal').modal('show');
		setTimeout(function() {
			buy_credits();
		}, 2000);
	});
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
});
function validate_form() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax/validate_form",
		data: $('#form_buy_credits').serialize(),
		success: function(html) {
			var data = $.parseJSON(html);
			if (!data.ok) {
				$('#f_' + data.error_id).addClass('has-error');
				$('#' + data.error_id).focus();
			} else {
				$('#waitingModal').modal('show');
				setTimeout(function() {
					buy_credits();
				}, 2000);
			}
		}
	})
}
function buy_credits() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax/buy_credits",
		data: $('#form_buy_credits').serialize(),
		success: function(html) {
			if (html == 'true') {
				$('#order-message').html('<i class="fa fa-done fa-check-circle fa-3x text-success"></i><h2 class="text-success">Payment Successful!</h2><p>Credit Card Transaction Sucsessfull, your credit ballance has been updated</p>');
				setTimeout(function() {
					location.reload();
				}, 2000);
			} else {
				$('#order-message').html('<i class="fa fa-done fa-times fa-3x text-danger"></i><h2 class="text-danger">Payment Failed!</h2><p>Credit Card Transaction Failed. Error: Invalid credit card number</p>');
				setTimeout(function() {
					$('#waitingModal').modal('hide');
				}, 2000);
			}
		}
	})
}
function calculate_amount() {
	preloading($('#purchase-summary'));
	var credits = $('#credits').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax/calculate_amount",
		data: {credits: credits},
		success: function(html) {
			if (!html) {
				$('#f_credits').addClass('has-error');
				loaded($('#purchase-summary'),'');
			} else {
				$('#f_credits').removeClass('has-error');
				loaded($('#purchase-summary'), html);
				$('#pay-now').removeClass('hide');
			}			
		}
	})
}
</script>