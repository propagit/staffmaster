<?php
	$company = $this->setting_model->get_profile();	
?>
<div class="col-sm-12">
    <div class="lookbook-nav">
        <ul>
            <li><?=$company['address'] . ' ' . $company['suburb'] . ' ' . $company['state'] . ' ' . $company['postcode'];?></li>
            <li>|</li>
            <li><i class="fa fa-phone"></i> <?=$company['telephone'];?></li>
            <li>|</li>
            <li><i class="fa fa-envelope"></i> <a href="mailto:<?=$company['email'];?>"><?=$company['email'];?></a></li>
        </ul>
    </div>
</div>