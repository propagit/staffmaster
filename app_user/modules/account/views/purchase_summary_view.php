<hr />
<p>Purchase Summary</p>
<div class="row">
	<div class="col-md-4 remove-left-padding">Cost Per Credit</div>
	<div class="col-md-6"><b>$<?=money_format('%i', $price['unit_price']);?> (ex. GST)</b></div>
</div>
<hr />
<div class="row">
	<div class="col-md-4 remove-left-padding">Sub total</div>
	<div class="col-md-6"><b>$<?=money_format('%i', $price['unit_price'] * $credits);?></b></div>
</div>
<hr />
<div class="row">
	<div class="col-md-4 remove-left-padding">GST</div>
	<div class="col-md-6"><b>$<?=money_format('%i', $price['unit_price'] * $credits / 10);?></b></div>
</div>
<hr />
<div class="row">
	<div class="col-md-4 remove-left-padding">Total</div>
	<div class="col-md-6"><h2>$<?=money_format('%i', $price['unit_price'] * $credits * 1.1);?></h2></div>
</div>
<?
$user_data = $this->session->userdata('user_data');
?>
<p>A tax receipt of purchase will be sent to <?=$user_data['email_address'];?>