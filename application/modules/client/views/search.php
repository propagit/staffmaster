<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Search Clients</h2>
    	 <p>Search and manage your client list.</p>
         
         <div class="pull-right">
            <button type="button" class="btn btn-info"><i class="icon-archive"></i> Activity Log</button>
        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Search Client</h2>
            <p>Search and manage your client list.</p>
            <form class="form-horizontal" role="form" method="post" action="<?=base_url();?>client/search">
			<div class="form-group">
				<label for="keyword" class="col-lg-2 control-label">Company name</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" id="keyword" name="keyword" placeholder="company name" />
				</div>
				<div class="pull=right">
					<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Search</button>
				</div>
			</div>
		
		</form>
            <? if (isset($clients)) { ?>

            <table class="table table-hover">
                <thead>
                <tr class="heading">
                    <td class="left">Company Name <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
                    <td class="center" width="18%"><i class="icon-map-marker"></i> Jobs <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
                    <td class="center" width="18%"><i class="icon-location-arrow"></i> Jobs This Year <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
                    <td class="center" width="12%"><i class="icon-eye-open"></i> View</td>
                    <td class="center" width="12%"><i class="icon-trash"></i> Delete</td>
                    <td class="center" width="12%"><i class="icon-time"></i> Status</td>
                    <td class="center" width="12%"><i class="icon-check"></i> Check</td>
                </tr>
                </thead>
                <? foreach($clients as $client) { ?>
                <tr>
                    <td class="left"><?=$client['company_name'];?></td>
                    <td class="center">99 950</td>
                    <td class="center">999 090</td>
                    <td class="center"><a href="<?=base_url();?>client/edit/<?=$client['user_id'];?>"><i class="icon-eye-open icon-large"></i></a></td>
                    <td class="center"><a href="javascript:delete_client(<?=$client['user_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
                    <td class="center"><?=($client['status'] == 1) ? 'Active' : 'Inactive';?></td>
                    <td class="center"><input type="checkbox" /></td>
                </tr>
                <? } ?>
            </table>
            
            <? } ?>
        </div>
    </div>
</div>    

<script>
function delete_client(user_id)
{
	if(confirm('Are you sure you want to delete this client?'))
	{
		window.location = '<?=base_url();?>client/delete/' + user_id;
	}
}
</script>