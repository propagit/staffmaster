<table style="background:<?=(isset($color) && $color !='') ? '#'.$color : '#00bbf8' ?>; color:<?='#'.$font_color;?>; font-size:11px; font-family:Arial, Helvetica, sans-serif;padding:15px;" width="100%">
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
        	<a href="http://<?=$company['email_s_facebook'];?>"><img src="<?=base_url();?>assets/img/email/facebook.png"></a>
        	<? } ?>
        	<? if (isset($company['email_s_twitter']) && $company['email_s_twitter']!='') { ?>
        	&nbsp;&nbsp;&nbsp;<a href="http://<?=$company['email_s_twitter'];?>"><img src="<?=base_url();?>assets/img/email/twitter.png"></a>
        	<? } ?>
			<? if (isset($company['email_s_linkedin']) && $company['email_s_linkedin']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="http://<?=$company['email_s_linkedin'];?>"><img src="<?=base_url();?>assets/img/email/linkedin.png"></a>
			<? } ?>
			<? if (isset($company['email_s_google']) && $company['email_s_google']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="http://<?=$company['email_s_google'];?>"><img src="<?=base_url();?>assets/img/email/google.png"></a>
			<? } ?>
			<? if (isset($company['email_s_youtube']) && $company['email_s_youtube']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="http://<?=$company['email_s_youtube'];?>"><img src="<?=base_url();?>assets/img/email/youtube.png"></a>
			<? } ?>
			<? if (isset($company['email_s_instagram']) && $company['email_s_instagram']!='') { ?>
			&nbsp;&nbsp;&nbsp;<a href="http://<?=$company['email_s_instagram'];?>"><img src="<?=base_url();?>assets/img/email/instagram.png"></a>
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
