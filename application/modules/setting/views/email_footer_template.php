<table id="template_email" style="border:1px solid #dfdfdf;background:#fbfbfb; border-radius:3px; padding:15px;" width="100%">
    <tr>
    	<td>
        <table style="background:#00bbf8; padding:15px;color:#fff;">
        <tr>
        <td width="50%">        	
                    <?=(isset($company['email_c_name'])) ? $company['email_c_name'] : 'Company Name';?><br />
					<?=(isset($company['email_c_address'])) ? $company['email_c_address'] : 'Address';?><br />
                    <?=(isset($company['email_c_state'])) ? $company['email_c_state'] : 'State';?>&nbsp; 
                    <?=(isset($company['email_c_country'])) ? $company['email_c_country'] : 'Country';?> &nbsp;
                    <?=(isset($company['email_c_postcode'])) ? $company['email_c_postcode'] : 'Postcode';?><br />
                    <br />
                    T: <?=(isset($company['email_c_phone'])) ? $company['email_c_phone'] : 'Phone';?> <br />
                    F: <?=(isset($company['email_c_fax'])) ? $company['email_c_fax'] : 'Fax';?> <br />
                    E: <?=(isset($company['email_c_email'])) ? $company['email_c_email'] : 'Email';?> <br />
                    W: <?=(isset($company['email_c_website'])) ? $company['email_c_website'] : 'Website';?> <br />
            
        </td>
        <td width="50%">
        	<table width="100%">
            <tr><td>
            	<?=(isset($company['email_company_login_button'])) ?  '<div id="login_button">Login To Your Account</div>' : ''; ?>
            </td></tr>
            <tr>
                <td><table align="right"><tr>
                <?=(isset($company['email_s_facebook'])) ? '<td>FB</td>' : ''; ?> 
                <?=(isset($company['email_s_twitter'])) ? '<td>TW</td>' : ''; ?> 
                <?=(isset($company['email_s_linkedin'])) ? '<td>LI</td>' : ''; ?> 
                <?=(isset($company['email_s_googleplus'])) ?  '<td>Google</td>' : ''; ?> 
                <?=(isset($company['email_s_youtube'])) ? '<td>Yb</td>' : ''; ?> 
                </tr></table></td>
            </tr>
            <tr><td>
            <p style="font-size:10px;">
                <?=(isset($company['email_company_text'])) ? $company['email_company_text'] : '';?>                                            
            </p>
            </td></tr>
            </table>
        </td>
        </tr>
        </table>
        </td>
    
    </tr>
       
</table>