<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Sync Staff</h2>
   		 
    </div>
</div>
<!--end top box-->

<? if($this->config_model->get('accounting_platform') != '') { ?>
<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="col-md-6 white-box">
            <div class="inner-box">
		   		 <h2>StaffBooks data</h2>
            </div>
        </div>   
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
            	<h2>Shoebooks data</h2>
            	<span class="badge"><?=count(modules::run('api/shoebooks/search_customer'));?></span>
            </div>
        </div>   
    </div>
</div>
<? } ?>