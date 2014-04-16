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
		<h4 class="c4">Your Search results<br />Results found: <?=count($results);?></h4>
		<? if (count($results) > 0) { ?>
		<div id="list_resources">
		<table class="table">
		<thead>
			<tr>
				<th>Resource Title</th>
			</tr>
		</thead>
		<? foreach($results as $result) { 
			$files = $this->resource_model->search_resource_files($result['resource_id'],$this->session->userdata('search_resources'));
		?>
		<tr>
			<td>
				<a href="<?=base_url();?>resource/r-<?=$result['resource_id'];?>"><h4 class="c6"><?=$result['resource_title'];?></h4></a>
				<? if (count($files) > 0) { ?>
				<ul>
					<? foreach($files as $file) { ?>
					<li><a href="<?=base_url().UPLOADS_URL;?>/resources/<?=$file['file_name'];?>" target="_blank"><?=$file['orig_name'];?></a></li>
					<? } ?>
				</ul>
				<? } ?>
			</td>
		</tr>
		<? } ?>
		</table>
		</div>
		<? } ?>
	</div>
</div>