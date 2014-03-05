<? if(isset($company['company_logo']) && $company['company_logo']!=''){?>
	<img src="<?=base_url()?>uploads/company/logo/<?=md5($company['id'])?>/thumbnail/<?=$company['company_logo']?>">
<? }else { ?>    
	<img src="<?=base_url();?>assets/img/core/staffmaster-logo.jpg" title="Staff Master Logo" alt="staffmaster-logo.jpg" />
<? } ?>
