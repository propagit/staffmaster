<table style="background:<?=(isset($color) && $color !='') ? '#'.$color : '#00bbf8' ?>; color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>; font-size:11px; font-family:Arial, Helvetica, sans-serif;padding:15px;" width="100%">
	<tr valign="bottom">
    	<td style="padding:15px;" width="35%">
        	<?=(isset($company['email_c_name'])&& $company['email_c_name']!='') ? '<span style="font-size:14px; font-weight:bold;">'.$company['email_c_name'].'</span><br /><br />' : '';?>
			<?=(isset($company['email_c_address']) && $company['email_c_address']!='') ? $company['email_c_address'].'<br />' : '';?>
            <?=(isset($company['email_c_state']) && $company['email_c_state']!='') ? $company['email_c_state'].'&nbsp;' : '';?> 
            <?=$country_full_name;?> 
            <?=(isset($company['email_c_postcode']) && $company['email_c_postcode']!='') ? $company['email_c_postcode'] : '';?>
        </td>
        <td style="padding:15px;" width="65%" align="right">
        	<?=(isset($company['email_s_facebook']) && $company['email_s_facebook']!='') ? '<a href="'.$company['email_s_facebook'].'"><img src="http://smcloud.co/demo/images/facebook.png"></a>' : ''; ?> 
			<?=(isset($company['email_s_twitter']) && $company['email_s_twitter']!='') ? '&nbsp;&nbsp;&nbsp;<a href="'.$company['email_s_twitter'].'"><img src="http://smcloud.co/demo/images/twitter.png"></a>' : ''; ?> 
            <?=(isset($company['email_s_linkedin']) && $company['email_s_linkedin']!='') ? '&nbsp;&nbsp;&nbsp;<a href="'.$company['email_s_linkedin'].'"><img src="http://smcloud.co/demo/images/linkedin.png"></a>' : ''; ?> 
            <?=(isset($company['email_s_google']) && $company['email_s_google']!='') ?  '&nbsp;&nbsp;&nbsp;<a href="'.$company['email_s_google'].'"><img src="http://smcloud.co/demo/images/google.png"></a>' : ''; ?> 
            <?=(isset($company['email_s_youtube']) && $company['email_s_youtube']!='') ? '&nbsp;&nbsp;&nbsp;<a href="'.$company['email_s_youtube'].'"><img src="http://smcloud.co/demo/images/youtube.png"></a>' : ''; ?> 
            <?=(isset($company['email_s_instagram']) && $company['email_s_instagram']!='') ? '&nbsp;&nbsp;&nbsp;<a href="'.$company['email_s_instagram'].'"><img src="http://smcloud.co/demo/images/instagram.png"></a>' : ''; ?> 
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
