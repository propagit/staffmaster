<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
body {
	background-color: #00aeec;
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<p><!-- Save for Web Slices (email-NewAccountAcctivated.psd) -->
</p>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="<?=base_url();?>assets/email_templates/images/emailHeader.jpg" width="750" height="92"></td>
  </tr>
</table>
<table width="750" height="58" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
	<tr>
		<td>
			<img src="<?=base_url();?>assets/email_templates/images/email-menu_01.jpg" width="206" height="58" alt=""></td>
		<td>
			<img src="<?=base_url();?>assets/email_templates/images/email-menu_02.jpg" width="71" height="58" alt=""></td>
		<td>
			<img src="<?=base_url();?>assets/email_templates/images/email-menu_03.jpg" width="98" height="58" alt=""></td>
		<td>
			<img src="<?=base_url();?>assets/email_templates/images/email-menu_04.jpg" width="115" height="58" alt=""></td>
		<td>
			<img src="<?=base_url();?>assets/email_templates/images/email-menu_05.jpg" width="259" height="58" alt=""></td>
		<td>
			<img src="<?=base_url();?>assets/email_templates/images/email-menu_06.jpg" width="1" height="58" alt=""></td>
	</tr>
</table>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="0" bgcolor="#FFFFFF">
    
   <span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">
    
      <br>
      <br>
      Hello <?=$firstname;?>,
      <br>
      Below is a Tax Receipt for the purchase of Staff Master credits.
      <br><br>
      <hr>
      <h1 style="font-family:Tahoma, Geneva, sans-serif; font-size:30px; line-height:20px; color:#3d3d3d">Tax Invoice</h1>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
      	<td width="50%" align="left"><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">Date of Purchase</span></td>
      	<td width="50%" align="left"><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d"><?=date('jS M Y');?></span></td>
      </tr>
      <tr>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">Purchase ID</span></td>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d"><?=$purchase_id;?></span></td></td>
      </tr>
      <tr>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">Credits purchased</span></td>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d"><?=$credits;?></span></td>
      </tr>
      <tr>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">Sub Total</span></td>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">$<?=money_format('%i', ($total_amount/100)*10/11);?></span></td>
      </tr>
      <tr>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">GST</span></td>
      	<td><span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#3d3d3d">$<?=money_format('%i', ($total_amount/100)/11);?></span></td>
      </tr>
      </table>
      <br>
      <br>
      <hr />
      <br />
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
      	<td width="50%" align="left"><h2 style="font-family:Tahoma, Geneva, sans-serif; font-size:24px; line-height:20px; color:#3d3d3d">Total</h2></td>
      	<td width="50%" align="left"><h2 style="font-family:Tahoma, Geneva, sans-serif; font-size:24px; line-height:20px; color:#3d3d3d">$<?=money_format('%i', $total_amount/100);?></h2></td>
      </tr>
      </table>
      <hr />
      <br>
      Invoice Paid <?=date('jS M Y');?>
      <br />
      <b>Thank you for using Staff Master</b>
  <br>
      <br>
    </p>
    </span></td>
    <td width="25" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100" align="center" valign="middle">
    <span style="font-family:Tahoma, Geneva, sans-serif; font-size:16px; line-height:20px; color:#FFF">
    &copy; StaffMaster | <a href="http://www.staffmaster.com.au"><span style="color:#FFF;">www.staffmaster.com.au</span></a></span></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- End Save for Web Slices -->
</body>
</html>