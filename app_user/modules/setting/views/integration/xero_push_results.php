<h2>Push Results</h2>
<br />
<div id="platform-data" class="table-responsive">
	<table class="table table-bordered table-hover table-middle" width="100%">
	<thead>
		<tr>
			<th class="center">Pushed</th>
			<th class="center">Errors</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td><span class="badge success"><?=$pushed_counter;?></span></td>
		<td><span class="badge danger" id="error-staffbooks"><?=$error_counter;?></span></td>
	</tr>
	</tbody>
</table>
<?php if($pushed_counter > 0){ ?>
	<p class="text-success"><strong>Push Successfull</strong></p>
<?php } ?>
<?php if(count($errors) > 0){?>
	
	<p class="bg-danger text-danger">
    	<strong>Some data could not be sent to Xero</strong><br><br>
    	<?php echo implode('<br>',$errors);?>
    </p>
<?php
}
?>
</div>

<p><a class="btn btn-danger" onclick="location.reload()"><i class="fa fa-times"></i> Close</a></p>
