<div class="btn-breadcrumb pull-right">
	<a href="<?=base_url();?>admin/user/create" class="btn"><i class="icon-plus"></i> Create new user</a>
</div>

<ul class="breadcrumb">
	<li class="active">Users Management</li>
</ul>

<div class="box-search">
    <div class="input-append">
    <input class="span2" type="text" placeholder="username..." />
    <button class="btn" type="button">Search <i class="icon-search"></i></button>
    </div>
</div>

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
		<td>Distributor Name</td>
		<td>Email</td>
		<td>Last signed on</td>
		<td class="center" width="40">Edit</td>
		<td class="center" width="40">Delete</td>
	</tr>
	</thead>
	<? foreach($users as $user) { ?>
	<tr>
		<td><?=$user['company_name'];?></td>
		<td><?=$user['company_email'];?></td>
		<td><?=time_since($user['lastsignedinon']);?></td>
		<td class="center">
			<a href="<?=base_url();?>admin/user/edit/<?=$user['user_id'];?>"class="btn btn-mini btn-info" ><i class="icon-pencil icon-white"></i></a>
		</td>
		<td class="center">
			<button  onclick="delete_user(<?=$user['user_id'];?>)" class="btn btn-mini btn-danger" type="button"><i class="icon-trash icon-white"></i> </button>
		</td>
	</tr>
	<? } ?>
</table>
<script>
function delete_user(user_id)
{
	if(confirm('Are you sure you want to delete this distributor account?'))
	{
		window.location = '<?=base_url();?>admin/user/delete/' + user_id;
	}
}
</script>