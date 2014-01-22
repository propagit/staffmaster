<link href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet" media="screen" type="text/css" />
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<style>
.label-rate
{
	float:left;
	width:80px;
}
.input-rate
{
	float:left;
	width:45px;
	padding-left:5px;
	border : 1px solid #dbdbdb;
}
.selectable .ui-selecting.input-rate.client { background: #FECA40; color: white; }
.selectable .ui-selecting.input-rate.staff { background: #FECA40; color: white; }
.selectable .ui-selected.input-rate.client { background: #F39814; color: white; }
.selectable .ui-selected.input-rate.staff { background: #F39814; color: white; }
</style>
 <script>
$(function() {
	$( ".selectable" ).selectable();
	
	$( ".selectable" )
	.mouseup(function() {
		//alert('up');
		var count = $('.ui-selecting.input-rate.staff').size() + $('.ui-selecting.input-rate.client').size();
		if(count > 0)
		{
			$("#setPayrate").modal('show');
		}
		// $(".ui-selectee").each(
			// function(index)
			// {
				// $(this).removeClass('ui-selecting');
				// $(this).removeClass('ui-selected');
			// }
		// )
	});
	
});

function set_payrate()
{
	var crate = $('#crate').val() * 1;
	var srate = $('#srate').val() * 1;
	var valid = 1;
	if(isNaN(crate))
	{
		alert('Please insert a valid client rate');
		valid = 0;
	}
	
	if(isNaN(srate))
	{
		alert('Please insert a valid staff rate');
		valid = 0;
	}
	
	if(valid == 1)
	{
		$('.ui-selected.input-rate.client').val(crate.toFixed(2));
		$('.ui-selected.input-rate.staff').val(srate.toFixed(2));
		
		$("#setPayrate").modal('hide');
		$(".ui-selectee").each(
			 function(index)
			 {
				 $(this).removeClass('ui-selected');
			 }
		);
	}
}

</script>
<h2>Pay Rates</h2>

<p>Manage your pay rates attribute.</p>

<a data-toggle="modal" href="#addPayrate" ><i class="icon-plus-sign"></i> Add Pay Rate</a>
<br /><br />


<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="left">Name123 <a href="<?=base_url();?>attribute/payrate/sort"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center">Staff Rate<!--  <a href="#"><i class="icon-sort-by-alphabet"></i></a> --></td>
		<td class="center">Client Rate<!--  <a href="#"><i class="icon-sort-by-alphabet"></i></a> --></td>
		<td class="center"><i class="icon-eye-open"></i> View</td>
		<td class="center"><i class="icon-trash"></i> Delete</td>
		<!-- <td class="center"><i class="icon-time"></i> Status</td> -->
		<!-- <td class="center"><i class="icon-check"></i> Check</td> -->
	</tr>
	</thead>
	<? foreach($payrates as $payrate) { ?>
	<tr>
		<td class="left"><?=$payrate['name'];?></td>
		<td class="center">$<?=$payrate['staff_rate'];?></td>
		<td class="center">$<?=$payrate['client_rate'];?></td>
		<td class="center"><a href="javascript:edit_payrate(<?=$payrate['payrate_id'];?>,'<?=$payrate['name'];?>',<?=$payrate['staff_rate'];?>,<?=$payrate['client_rate'];?>)"><i class="icon-eye-open icon-large"></i></a></td>
		<td class="center"><a href="javascript:delete_payrate(<?=$payrate['payrate_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
		<!-- <td class="center"><?=($payrate['status'] == 1) ? 'Active' : 'Inactive';?></td> -->
		<!-- <td class="center"><input type="checkbox" /></td> -->
	</tr>
	<? } ?>
</table>

<div class="table-responsive selectable"  id="wrapper-table">
	<table class="table">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
				<th>Saturday</th>
				<th>Sunday</th>
			</tr>
		</thead>
		<tbody >
			<?php
			$j = 0;
			for($i=0;$i<24;$i++)
			{
				$ttl = '';
				if($i == 0)
				{
					$ttl = 'Midnight';
				}
				else 
				{
					if($i<12)
					{
						$ttl = $i.':00 AM<br/>('.$i.':00)';
					}
					else 
					{
						if($i>12) {$j = $i-12;}
						$ttl = $j.':00 PM<br/>('.$i.':00)';
					}
				}
				
				?>
				<tr >
					<th><?=$ttl?></th>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="monday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="monday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="tuesday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="tuesday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="wednesday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="wednesday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="thursday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="thursday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="friday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="friday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="saturday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="saturday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
					<td >
						<div class="label-rate">Staff Rate</div>
						<input type="text" class="input-rate staff" id="sunday-<?=$i?>-staff" value="0.00">
						<div style="clear: both"></div>
						<div class="label-rate">Client Rate</div>
						<input type="text" class="input-rate client" id="sunday-<?=$i?>-client" value="0.00">
						<div style="clear: both"></div>
					</td>
				</tr>
				<?
			}
			?>
			
		</tbody>
	</table>
</div>

<!-- Add Payrate Modal -->
<div class="modal fade" id="addPayrate" tabindex="-1" role="dialog" aria-labelledby="addPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Pay rate</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/payrate/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter pay rate name">
				</div>
				<div class="form-group">
					<label for="staff_rate">Staff Rate</label>
					<input type="text" class="form-control" name="staff_rate" id="staff_rate" />
				</div>
				<div class="form-group">
					<label for="client_rate">Client Rate</label>
					<input type="text" class="form-control" name="client_rate" id="client_rate" />
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-info">Submit</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- set Payrate Modal -->
<div class="modal fade" id="setPayrate" tabindex="-1" role="dialog" aria-labelledby="addPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Set Pay rate</h4>
			</div>
			<form role="form" method="post" action="">
			<div class="modal-body">
				<p>Please enter a value for the selected time slots</p>
				<div class="form-group">
					<label for="name">Staff Rate</label>
					<div class="input-group">
					  <span class="input-group-addon">$</span>
					  <input type="text" class="form-control" id="srate" placeholder="staff rate">
					</div>
				</div>
				<div class="form-group">
					<label for="name">Client Rate</label>
					<div class="input-group">
					  <span class="input-group-addon">$</span>
					  <input type="text" class="form-control" id="crate" placeholder="client rate">
					</div>
				</div>
				<!-- <div class="form-group">
					<label for="staff_rate">Staff / Client</label>
					<select class="form-control" id="setratesfor">
						<option value="0">Both staff and client</option>
						<option value="1">Only staff</option>
						<option value="2">Only client</option>
					</select>
				</div> -->
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-info" onclick="set_payrate();">Set</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Payrate Modal -->
<div class="modal fade" id="editPayrate" tabindex="-1" role="dialog" aria-labelledby="editPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Pay rate</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/payrate/edit">
			<input type="hidden" name="payrate_id" id="payrate_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter pay rate name">
				</div>
				<div class="form-group">
					<label for="staff_rate_edit">Staff Rate</label>
					<input type="text" class="form-control" name="staff_rate" id="staff_rate_edit" />
				</div>
				<div class="form-group">
					<label for="client_rate_edit">Client Rate</label>
					<input type="text" class="form-control" name="client_rate" id="client_rate_edit" />
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-info">Submit</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
function delete_payrate(payrate_id)
{
	if(confirm('Are you sure you want to delete this pay rate?'))
	{
		window.location = '<?=base_url();?>attribute/payrate/delete/' + payrate_id;
	}
}
function edit_payrate(payrate_id, name, staff_rate, client_rate)
{
	$('#payrate_id').val(payrate_id);
	$('#name_edit').val(name);
	$('#staff_rate_edit').val(staff_rate);
	$('#client_rate_edit').val(client_rate);
	$('#editPayrate').modal('show');
}
</script>