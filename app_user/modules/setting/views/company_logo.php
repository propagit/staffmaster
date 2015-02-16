<a href="<?=base_url();?>"><? if(isset($company['company_logo']) && $company['company_logo']!=''){?>
	<img src="<?=base_url().UPLOADS_URL;?>/company/logo/<?=md5($company['id'])?><?=$full_image ? '/' : '/thumbnail/'?><?=$company['company_logo']?>">
<? }else { ?>    
	<img src="<?=base_url();?>assets/img/core/staffbooks-logo.png" title="StaffBooks" alt="StaffBooks" />
<? } ?>
</a>
