<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
   	 	<td height="150" align="center" valign="middle"><?=modules::run('setting/company_logo');?></td>
    </tr>
    <tr>
        <td height="250" align="center" valign="middle" bgcolor="<?=$styles['primary_colour'];?>">
        	<img src="<?=base_url();?>assets/img/email/lookbook/SBTransLogo.png" width="213" height="140" />   
   		</td>
    </tr>
    
    <tr>
        <td height="100" align="center" valign="middle" bgcolor="<?=$styles['primary_colour'];?>">
            <span style="font-family:Helvetica, Arial, sans-serif; color:#FFF; font-size:20px; font-weight:bold">
            We have prepared a StaffBook for you</span><br /><br />
        
        
            <span style="font-family:Arial, Helvetica, sans-serif; color:#FFF; font-size:14px;">
            <?=$email_body;?></span>       
        </td>
    </tr> 
	<tr style="border-bottom:0.5px solid #fff;">
        <td height="220" bgcolor="<?=$styles['primary_colour'];?>">    
        	<a href="<?=$url;?>" style="height:50px; width:215px; line-height:55px; border-style: solid; border-color:#FFF; border-width:1px; solid; display:block;text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:18px; letter-spacing:1.5px; color:#fff; text-decoration:none; margin:auto">View Staff</a>
        </td>
    
    </tr>
</table>