<table id="template_email" width="100%" >
    <tr>
    	<td class="inside-template">
            <table  style="background:<?=(isset($color) && $color !='') ? '#'.$color : '#00bbf8' ?>; color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>;" width="100%">
            <tr>
            <td width="50%" class="inside-template" style="padding:15px;" valign="bottom">        	
                        <?=(isset($company['email_c_name'])&& $company['email_c_name']!='') ? $company['email_c_name'].'<br />' : '';?>
                        <?=(isset($company['email_c_address']) && $company['email_c_address']!='') ? $company['email_c_address'].'<br />' : '';?>
                        <?=(isset($company['email_c_state']) && $company['email_c_state']!='') ? $company['email_c_state'].'&nbsp;' : '';?> 
                        <?=(isset($company['email_c_country']) && $company['email_c_country']!='') ? $company['email_c_country'].'&nbsp;' : '';?> 
                        <?=(isset($company['email_c_postcode']) && $company['email_c_postcode']!='') ? $company['email_c_postcode'].'<br />' : '';?>
                        <br />
                        <?=(isset($company['email_c_telephone']) && $company['email_c_telephone']!='') ? 'T: '.$company['email_c_telephone'].'<br />' : '';?> 
                        <?=(isset($company['email_c_fax']) && $company['email_c_fax']!='') ? 'F: '.$company['email_c_fax'].'<br />' : '';?> 
                        <?=(isset($company['email_c_email']) && $company['email_c_email']!='') ? 'E: <span style="color:#fff;">'.$company['email_c_email'].'</span><br />' : '';?> 
                        <?=(isset($company['email_c_website']) && $company['email_c_website']!='') ? 'W: '.$company['email_c_website'].'<br />' : '';?> 
                
            </td>
            <td width="50%">
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
                <tr><td align="right">
                <p style="font-size:10px; text-align:right; padding-right:15px;color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>;">
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