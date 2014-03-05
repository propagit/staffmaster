<table id="template_email" width="100%" >
    <tr>
    	<td class="inside-template">
            <table  style="background:<?=(isset($color) && $color !='') ? '#'.$color : '#00bbf8' ?>; color:<?=(isset($font_color) && $font_color !='') ? '#'.$font_color : '#fff' ?>;" width="100%">
            <tr>
            <td width="50%" class="inside-template" style="padding:15px;">        	
                        <?=(isset($company['email_c_name'])&& $company['email_c_name']!='') ? $company['email_c_name'] : 'Company Name';?><br />
                        <?=(isset($company['email_c_address']) && $company['email_c_address']!='') ? $company['email_c_address'] : 'Address';?><br />
                        <?=(isset($company['email_c_state']) && $company['email_c_state']!='') ? $company['email_c_state'] : 'State';?>&nbsp; 
                        <?=(isset($company['email_c_country']) && $company['email_c_country']!='') ? $company['email_c_country'] : 'Country';?> &nbsp;
                        <?=(isset($company['email_c_postcode']) && $company['email_c_postcode']!='') ? $company['email_c_postcode'] : 'Postcode';?><br />
                        <br />
                        T: <?=(isset($company['email_c_telephone']) && $company['email_c_telephone']!='') ? $company['email_c_telephone'] : 'Phone';?> <br />
                        F: <?=(isset($company['email_c_fax']) && $company['email_c_fax']!='') ? $company['email_c_fax'] : 'Fax';?> <br />
                        E: <?=(isset($company['email_c_email']) && $company['email_c_email']!='') ? $company['email_c_email'] : 'Email';?> <br />
                        W: <?=(isset($company['email_c_website']) && $company['email_c_website']!='') ? $company['email_c_website'] : 'Website';?> <br />
                
            </td>
            <td width="50%">
                <table width="100%">
                <tr><td class="inside-template" style="padding:15px;">
                    <?=(isset($company['email_company_login_button'])) ?  '<div id="login_button">Login To Your Account</div>' : ''; ?>
                </td></tr>
                <tr>
                    <td class="inside-template" style="padding:15px;">
                    <table align="right" width="35%" ><tr>
                    <?=(isset($company['email_s_facebook']) && $company['email_s_facebook']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_facebook'].'"><img style="border:1px solid#fff;" src="'.base_url().'assets/img/facebook.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_twitter']) && $company['email_s_twitter']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_twitter'].'"><img style="border:1px solid#fff;" src="'.base_url().'assets/img/twitter.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_linkedin']) && $company['email_s_linkedin']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_linkedin'].'"><img style="border:1px solid#fff;" src="'.base_url().'assets/img/linkedin.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_googleplus']) && $company['email_s_googleplus']!='') ?  '<td align="right" width="3%"><a href="'.$company['email_s_googleplus'].'"><img style="border:1px solid#fff;" src="'.base_url().'assets/img/google.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_youtube']) && $company['email_s_youtube']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_youtube'].'"><img style="border:1px solid#fff;" src="'.base_url().'assets/img/youtube.png"></a></td>' : ''; ?> 
                    <?=(isset($company['email_s_instagram']) && $company['email_s_instagram']!='') ? '<td align="right" width="3%"><a href="'.$company['email_s_instagram'].'"><img style="border:1px solid#fff;" src="'.base_url().'assets/img/instagram.png"></a></td>' : ''; ?> 
                    </tr></table></td>
                </tr>
                <tr><td align="right">
                <p style="font-size:10px; text-align:right; padding-right:15px;">
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