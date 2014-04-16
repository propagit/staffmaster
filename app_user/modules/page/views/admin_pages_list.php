<ul class="breadcrumb">
	<li class="active">Contents Management</li>
</ul>

<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<td>Page Title</td>
		<td>Last updated</td>
		<td class="center" width="40">Edit</td>
	</tr>
	</thead>
	<? foreach($pages as $page) { ?>
	<tr>
		<td><?=$page['title'];?></td>
		<td><?=time_since($page['lastupdatedon']);?></td>
		<td class="center">
			<a href="<?=base_url();?>admin/page/edit/<?=$page['page_id'];?>" class="btn btn-mini btn-info" ><i class="icon-pencil icon-white"></i></a>
		</td>
	</tr>
	<? } ?>
</table>

