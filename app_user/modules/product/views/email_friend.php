<? 
	$user = $this->session->userdata('user_data'); 
	$trade_price = $product['price'];
	if ($user['discount'] > 0)
	{
		$trade_price = (100 - $user['discount']) * $trade_price / 100;
	}
	$retail_price = $trade_price;
	if ($user['margin'] > 0)
	{
		$retail_price = (100 + $user['margin']) * $retail_price / 100;
	}
?>

<html>
<body style="margin: 0 auto; text-align:center;">
<table width="100%" height="100%" align="center">
<tr>
<td align="center" width="100%">
	<table width="500" cellpadding="5" cellspacing="5" border="0">
	<tr>
		<td colspan="4"> &nbsp; &nbsp; &nbsp; </td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2">
			<table width="100%" cellpadding="7" cellspacing="7" border="0">
			<tr>
				<td>
					<h3>Your friend has sent you this product because they thought it may be of interest to you</h3>
					<p><b><?=$product['title'];?></b></p>
					<p><b>Part No:</b> <?=$product['part_no'];?></p>
					<p><b>Description</b><br /><?=$product['description'];?></p>
					<p><b>Price: <span class="price">$<?=money_format('%i', $retail_price);?></span></b></p>
					<p>To enquire about this product  please contact <?=$user['company_name'];?> at <?=$user['company_email'];?></p>
					<br />
					<p><?=modules::run('product/photo', $product['pic_url']);?></p>
				</td>
			</tr>
			</table>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4"> &nbsp; &nbsp; &nbsp; </td>
	</tr>
	</table>
</td>
</tr>
</table>

</body>
</html>