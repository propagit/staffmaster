<table style="background:<?=(isset($color) && $color !='') ? '#'.$color : '#00bbf8' ?>; color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>; font-size:11px; font-family:Arial, Helvetica, sans-serif;padding:15px;" width="100%">
	<tr valign="bottom">
    	<td style="padding:15px;" width="35%">
        	<?=(isset($company['email_c_name'])&& $company['email_c_name']!='') ? '<span style="font-size:14px; font-weight:bold;">'.$company['email_c_name'].'</span><br /><br />' : '';?>
			<?=(isset($company['email_c_address']) && $company['email_c_address']!='') ? $company['email_c_address'].'<br />' : '';?>
            <?=(isset($company['email_c_state']) && $company['email_c_state']!='') ? $company['email_c_state'].'&nbsp;' : '';?> 
            <?=(isset($company['email_c_country']) && $company['email_c_country']!='') ? modules::run('common/get_country_name_from_country_code',$company['email_c_country']).'&nbsp;' : '';?> 
            <?=(isset($company['email_c_postcode']) && $company['email_c_postcode']!='') ? $company['email_c_postcode'] : '';?>
        </td>
        <td style="padding:15px;" width="65%" align="right">
        	<? if (isset($company['email_s_facebook']) && $company['email_s_facebook']!='') { ?>
        	<a href="<?=$company['email_s_facebook'];?>"><img src="<?=base_url();?>assets/img/email/facebook.png"></a>
        	<? } ?>
        	<? if (isset($company['email_s_twitter']) && $company['email_s_twitter']!='') { ?>
        	&nbsp;&nbsp;&nbsp;<a href="<?=$company['email_s_twitter'];?>"><img src="<?=base_url();?>assets/img/email/twitter.png"></a>
        	<? } ?>
			<? if (isset($company['email_s_linkedin']) && $company['email_s_linkedin']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="<?=$company['email_s_linkedin'];?>"><img src="<?=base_url();?>assets/img/email/linkedin.png"></a>
			<? } ?>
			<? if (isset($company['email_s_google']) && $company['email_s_google']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="<?=$company['email_s_google'];?>"><img src="<?=base_url();?>assets/img/email/google.png"></a>
			<? } ?>
			<? if (isset($company['email_s_youtube']) && $company['email_s_youtube']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="<?=$company['email_s_youtube'];?>"><img src="<?=base_url();?>assets/img/email/youtube.png"></a>
			<? } ?>
			<? if (isset($company['email_s_instagram']) && $company['email_s_instagram']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="<?=$company['email_s_instagram'];?>"><img src="<?=base_url();?>assets/img/email/instagram.png"></a>
			<? } ?>
        </td>
    </tr>
    <tr valign="bottom">
    	<td style="padding:15px;" width="35%">
        	<?=(isset($company['email_c_telephone']) && $company['email_c_telephone']!='') ? 'T:&nbsp;&nbsp;&nbsp;'.$company['email_c_telephone'].'<br />' : '';?>
			<?=(isset($company['email_c_fax']) && $company['email_c_fax']!='') ? 'F:&nbsp;&nbsp;&nbsp;'.$company['email_c_fax'].'<br />' : '';?>
            <?=(isset($company['email_c_email']) && $company['email_c_email']!='') ? 'E:&nbsp;&nbsp;&nbsp;<a href="#" style="color:#fff;text-decoration: none;">'.$company['email_c_email'].'</a><br />' : '';?>
            <?=(isset($company['email_c_website']) && $company['email_c_website']!='') ? 'W:&nbsp;&nbsp;&nbsp;<a href="#" style="color:#fff;text-decoration: none;">'.$company['email_c_website'].'</a>' : '';?> 
        </td>
        <td style="padding:15px;" width="65%"  align="right">
       		<?=(isset($company['email_common_text'])) ? $company['email_common_text'] : '';?>
        </td>
    </tr>
</table>
<?php 
//delete these codes once the system is ready for live mode
//kept for reference for the social icons as it is currently hard coded with static url
?>
<?php if(0) { ?>
<table id="template_email" width="100%" >
    <tr>
    	<td class="inside-template">
            <table  style="background:<?=(isset($color) && $color !='') ? '#'.$color : '#00bbf8' ?>; color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>;" width="100%">
            <tr>
            <td width="30%" class="inside-template" style="padding:15px; font-family:Arial" valign="bottom">        	
                        <?=(isset($company['email_c_name'])&& $company['email_c_name']!='') ? $company['email_c_name'].'<br />' : '';?>
                        <?=(isset($company['email_c_address']) && $company['email_c_address']!='') ? $company['email_c_address'].'<br />' : '';?>
                        <?=(isset($company['email_c_state']) && $company['email_c_state']!='') ? $company['email_c_state'].'&nbsp;' : '';?> 
                        <?=(isset($company['email_c_country']) && $company['email_c_country']!='') ? $company['email_c_country'].'&nbsp;' : '';?> 
                        <?=(isset($company['email_c_postcode']) && $company['email_c_postcode']!='') ? $company['email_c_postcode'].'<br />' : '';?>
                        <br /><br />
                        <table style="padding-bottom:10px;font-family:Arial; color:#fff;"><tr><td colspan="2"></td></tr>
                        <?=(isset($company['email_c_telephone']) && $company['email_c_telephone']!='') ? '<tr><td>T: </td><td>'.$company['email_c_telephone'].'</td></tr>' : '';?> 
                        <?=(isset($company['email_c_fax']) && $company['email_c_fax']!='') ? '<tr><td>F: </td><td>'.$company['email_c_fax'].'</td></tr>' : '';?> 
                        <?=(isset($company['email_c_email']) && $company['email_c_email']!='') ? '<tr><td>E: </td><td><a style="color:#fff!important; text-decoration:none!important;">'.$company['email_c_email'].'</a></td></tr>' : '';?> 
                        <?=(isset($company['email_c_website']) && $company['email_c_website']!='') ? '<tr><td>W: </td><td><a style="color:#fff!important; text-decoration:none!important;">'.$company['email_c_website'].'</a></td></tr>' : '';?> 
                        </table>
                
            </td>
            <td width="70%">
                <table width="100%">
                <tr><td class="inside-template" style="padding:15px;">
                    <?=(isset($company['email_company_login_button'])) ?  '<div id="login_button">Login To Your Account</div>' : ''; ?>
                </td></tr>
                <tr>
                    <td class="inside-template" style="padding:15px;">
                    <table align="right" width="35%" ><tr>
                    <? //=(isset($company['email_s_facebook']) && $company['email_s_facebook']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_facebook'].'"><img style="margin-right:3px;" src="'.base_url().'assets/img/facebook.png"></a></td>' : ''; ?> 
                    <? //=(isset($company['email_s_twitter']) && $company['email_s_twitter']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_twitter'].'"><img style="margin-right:3px;" src="'.base_url().'assets/img/twitter.png"></a></td>' : ''; ?> 
                    <? //=(isset($company['email_s_linkedin']) && $company['email_s_linkedin']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_linkedin'].'"><img style="margin-right:3px;" src="'.base_url().'assets/img/linkedin.png"></a></td>' : ''; ?> 
                    <? //=(isset($company['email_s_google']) && $company['email_s_google']!='') ?  '<td align="right" width="3%"><a href="'.$company['email_s_google'].'"><img style="margin-right:3px;" src="'.base_url().'assets/img/google.png"></a></td>' : ''; ?> 
                    <? //=(isset($company['email_s_youtube']) && $company['email_s_youtube']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_youtube'].'"><img style="margin-right:3px;" src="'.base_url().'assets/img/youtube.png"></a></td>' : ''; ?> 
                    <? //=(isset($company['email_s_instagram']) && $company['email_s_instagram']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_instagram'].'"><img style="margin-right:3px;" src="'.base_url().'assets/img/instagram.png"></a></td>' : ''; ?> 
                    
                    <?=(isset($company['email_s_facebook']) && $company['email_s_facebook']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_facebook'].'"><img style="margin-right:3px;" src="http://smcloud.co/demo/images/facebook.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_twitter']) && $company['email_s_twitter']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_twitter'].'"><img style="margin-right:3px;" src="http://smcloud.co/demo/images/twitter.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_linkedin']) && $company['email_s_linkedin']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_linkedin'].'"><img style="margin-right:3px;" src="http://smcloud.co/demo/images/linkedin.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_google']) && $company['email_s_google']!='') ?  '<td align="right" width="3%"><a href="'.$company['email_s_google'].'"><img style="margin-right:3px;" src="http://smcloud.co/demo/images/google.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_youtube']) && $company['email_s_youtube']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_youtube'].'"><img style="margin-right:3px;" src="http://smcloud.co/demo/images/youtube.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_instagram']) && $company['email_s_instagram']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_instagram'].'"><img style="margin-right:3px;" src="http://smcloud.co/demo/images/instagram.png"></a></td>' : ''; ?> 
                    </tr></table></td>
                </tr>
                <tr><td align="right" valign="bottom">
                <p style="font-size:10px; text-align:right; padding-right:15px; padding-bottom:15px; color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>;">
                    <?=(isset($company['email_common_text'])) ? $company['email_common_text'] : '';?>                                            
                </p>
                </td></tr>
                </table>
            </td>
            </tr>
            </table>
        </td>
    </tr>       
</table>
<?php } ?>