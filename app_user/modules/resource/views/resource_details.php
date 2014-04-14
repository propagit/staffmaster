<div class="row-fluid">
	<div class="span3">
		<form method="post" action="<?=base_url();?>resource/search">
		<div class="input-append">
			<input type="text" style="width:142px;" name="search_resources" placeholder="keywords..." value="<?=$this->session->userdata('search_resources');?>" />
			<button class="btn" type="submit">Search</button>
		</div>
		</form>
		
    
		<ul class="nav nav-tabs nav-stacked">
			<? foreach($resources as $menu) { ?>
			<li><a href="<?=base_url();?>resource/r-<?=$menu['resource_id'];?>"><?=$menu['resource_title'];?></a></li>
			<? } ?>
		</ul>
	</div>
	<div class="span9">
		<h4 class="c6"><?=$resource['resource_title'];?></h4>
		<p><?=$resource['resource_description'];?></p>
		
		<? if ($resource['survey_link']) { ?>
		<h4 class="c6">Survey</h4>
		<a href="<?=$resource['survey_link'];?>" target="_blank"><?=$resource['survey_link'];?></a>
		<? } ?>
		
		<? if ($resource['youtube_link']) { 
			$url = str_replace('/watch?v=', '/v/', $resource['youtube_link']);
			$url = str_replace('youtu.be/', 'www.youtube.com/v/', $url);			
		?>
		<h4 class="c6">Video</h4>
		<object width="560" height="315"><param name="movie" value="<?=$url;?>?hl=en_US&amp;version=3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="<?=$url;?>?hl=en_US&amp;version=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>
		<? } ?>
		
		<? if (count($files) > 0) { ?>
		<h4 class="c6">Documents</h4>
		<ul>
			<? foreach($files as $file) { ?>
			<li><a href="<?=base_url().UPLOADS_URL;?>/resources/<?=$file['file_name'];?>" target="_blank"><?=$file['orig_name'];?></a></li>
			<? } ?>
		</ul>
		<? } ?>
	</div>
</div>