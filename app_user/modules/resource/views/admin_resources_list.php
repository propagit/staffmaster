<div class="btn-breadcrumb pull-right">
	<a href="<?=base_url();?>admin/resource/create" class="btn"><i class="icon-plus"></i> Create new resource</a>
</div>

<ul class="breadcrumb">
	<li class="active">Resources Management</li>
</ul>

<form method="post" action="<?=base_url();?>admin/resource">
<div class="box-search">
    <div class="input-append">
    <input class="span2" type="text" name="keywords" placeholder="keywords..." value="<?=$this->session->userdata('keywords_resource');?>" />
    <button class="btn" type="submit">Search <i class="icon-search"></i></button>
    </div>
</div>
</form>

<!--
<div class="pagination">
	<ul>
		<li class="disabled"><a href="#">Prev</a></li>
		<li class="active"><a href="#">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">Next</a></li>
	</ul>
</div>
-->

<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<td width="20">ID</td>
		<td>Resource Title</td>
		<td>Created on</td>
		<td>Status</td>
		<td class="center" width="40">Edit</td>
		<td class="center" width="40">Delete</td>
	</tr>
	</thead>
	<? foreach($resources as $resource) { ?>
	<tr>
		<td><?=$resource['resource_id'];?></td>
		<td><?=$resource['resource_title'];?></td>
		<td><?=time_since($resource['createdon']);?></td>
		<td>
			<? if ($resource['active']) { ?>
			<span class="label label-success">Active</span> &nbsp; <a href="<?=base_url();?>admin/resource/activate/<?=$resource['resource_id'];?>">De-activate</a>
			<? } else { ?>
			<span class="label">In-active</span> &nbsp; <a href="<?=base_url();?>admin/resource/activate/<?=$resource['resource_id'];?>">Activate</a>
			<? } ?>
		</td>
		<td class="center">
			<a href="<?=base_url();?>admin/resource/edit/<?=$resource['resource_id'];?>" class="btn btn-mini btn-info" ><i class="icon-pencil icon-white"></i></a>
		</td>
		<td class="center">
			<a onclick="delete_resource(<?=$resource['resource_id'];?>)" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> </a>
		</td>
	</tr>
	<? } ?>
</table>



<script>
function delete_resource(resource_id)
{
	if(confirm('Are you sure you want to delete this resource?'))
	{
		window.location = '<?=base_url();?>admin/resource/delete/' + resource_id;
	}
}
</script>