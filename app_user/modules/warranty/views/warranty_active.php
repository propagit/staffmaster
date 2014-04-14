<h2 class="c6">Activate Warranty</h2>
<p>To activate a warranty, enter the registration code found in the packaging of the exchanged item</p>
<form method="post" action="<?=base_url();?>warranty">
<div class="input-append">
	<input class="input-xlarge pull-left" type="text" placeholder="Enter a product registration code" name="req_no" />
	<button class="btn btn-success" type="submit" >Activate Warranty</button>
</div>
<? if (isset($req_no_not_found)) { ?>
<div class="alert alert-error">
	You have entered an invalid registration code. Please try again!
</div>
<? } ?>
</form>

<? if (isset($warranty)) { ?>
	<? if (isset($warranty_activated)) { ?>
	<div class="alert alert-warning">
		This product warranty has already been activated on <?=date('d/m/Y', $warranty['warranty_start_date']);?>
	</div>
	<? } else { ?>
	<div class="alert alert-success">
		This product warranty has been activated successfully!
	</div>
	<? } ?>
<div class="box">
	<div class="photo"><?=modules::run('product/photo', $warranty['pic_url']);?></div>
	<div class="info">
		<h3 class="c2"><?=$warranty['product_name'];?></h3>
		<div class="row-fluid">
			<div class="span4 c4">Part No: <?=$warranty['product_part_no'];?></div>
			<div class="span8 c4">Registration Code: <?=$warranty['req_no'];?></div>
		</div>
		<div class="row-fluid">
			<div class="span3 c4">
				Customer:<br />
				Order Date:				
			</div>
			<div class="span3 c4">
				<?=$warranty['customer_name'];?><br />
				<?=date('d/m/Y', $warranty['sale_date']);?>
			</div>
			<div class="span4 c4">
				Warranty Start Date:<br />
				Warranty Finish Date:
			</div>
			<div class="span2 c4">
				<?=date('d/m/Y', $warranty['warranty_start_date']);?><br />
				<?=date('d/m/Y', $warranty['warranty_finish_date']);?>
			</div>
		</div>
	</div>
</div>
<? } ?>

<? /*
<div class="clearfix"></div>
<div class="shadow"></div>
<br />

<h2 class="c6">Search your warranties</h2>
<div class="pull-right span6">
	<button class="btn btn-large btn-success pull-right span1">&nbsp;</button>
	<div class="pull-right span4">
		<div class="c4" align="right">ACTIVATED WARRANTY</div>
		<p align="right">You have already activated this warranty and it will be active for 1 year from the date of activation</p>
	</div>
	<button class="btn btn-large btn-warning pull-right span1">&nbsp;</button>
	<div class="pull-right span4">
		<div class="c4" align="right">NOT YET ACTIVATED WARRANTY</div>
		<p align="right">You need to activate this warranty to ensure your exchanged part has been registered</p>
	</div>
	<button class="btn btn-large btn-danger pull-right span1">&nbsp;</button>
	<div class="pull-right span4">
		<div class="c4" align="right">EXPIRED WARRANTY</div>
		<p align="right">This warranty was activated more than 1 year ago and is no longer valid</p>
	</div>
</div>

<div class="pull-left">
	<form class="form-horizontal" method="post" action="<?=base_url();?>warranty/search">
		<div class="control-group">
			<label class="control-label c4" for="inputEmail">By Keyword</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="inputEmail" name="keywords" value="<?=$this->session->userdata('warranty_keywords');?>" placeholder="Enter a product or personal name">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="inputPassword">Status</label>
			<input type="hidden" name="status" id="warranty_status" />
			<div class="controls">
				<div class="btn-group">
					<button class="btn" id="selected_warranty_status"><?=($this->session->userdata('warranty_status')) ? $this->session->userdata('warranty_status') : 'Any Status';?></button>
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a onclick="select_warranty_status('Any Status')">Any Status</a></li>
						<li><a onclick="select_warranty_status('Activated Warranty')">Activated Warranty</a></li>
						<li><a onclick="select_warranty_status('Not Yet Activated Warranty')">Not Yet Activated Warranty</a></li>
						<li><a onclick="select_warranty_status('Expired Warranty')">Expired Warranty</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="inputPassword">Date Range</label>
			<div class="controls">
				<div class="input-append">
					<input class="span2" id="date_from" name="date_from" value="<?=$this->session->userdata('warranty_date_from');?>" type="text" placeholder="Date From">
					<button class="btn" type="button" id="icon_date_from"><i class="icon-calendar"></i></button>
				</div>
				&nbsp;
				<div class="input-append">
					<input class="span2" id="date_to" name="date_to" value="<?=$this->session->userdata('warranty_date_to');?>" type="text" placeholder="Date To">
					<button class="btn" type="button" id="icon_date_to"><i class="icon-calendar"></i></button>
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Search</button>
				&nbsp;
				<a type="button" class="btn">Reset</a>
			</div>
		</div>
	</form>
</div>
<? if ($this->session->userdata('warranty_searched')) { ?>
<div class="clear"></div>
<div class="shadow"></div>
<br />
<h2 class="c6">Search Results</h2>
<p>You can register and activate your product warranty from this screen. Every order placed will create a unique registration code than can be activated.<br />If you would like to find out more about the warranty process <a href="#">click here</a></p>
<table class="table table-bordered table-striped">
	<tr class="heading">
		<td class="center">Product Name</td>
		<td class="center">Exchanged Order By</td>
		<td class="center">Issue Date</td>
		<td class="center">Activation Date</td>
		<td class="center">Warranty Status</td>
	</tr>
	<? foreach($warranties as $warranty) { ?>
	<tr>
		<td><span class="c4"><?=$warranty['product_name'];?></span></td>
		<td><?=$warranty['customer_name'];?></td>
		<td><?=date('d-m-Y', $warranty['sale_date']);?></td>
		<td><?=($warranty['warranty_start_date']) ? date('d-m-Y', $warranty['warranty_start_date']) : '';?></td>
		<td>
			<? if ($warranty['warranty_start_date']) { ?>
			<a class="btn btn-block btn-success" data-toggle="modal">Activated Warranty</a>
			<? } else if ($warranty['warranty_finish_date'] > 0 && $warranty['warranty_finish_date'] < now()) { ?>
			<a class="btn btn-block btn-danger" data-toggle="modal">Expired Warranty</a>
			<? } else { ?>
			<a class="btn btn-block btn-warning" data-toggle="modal">Not Yet Activated Warranty</a>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	<!--
<tr>
		<td><span class="c4">Miele G295 Dishwasher</span></td>
		<td>Joeseph Blogs</td>
		<td>18-02-2013</td>
		<td>Not Activated</td>
		<td><a href="#myModal" role="button" class="btn btn-block btn-warning" data-toggle="modal">Activate Warranty</a></td>
	</tr>
	<tr>
		<td><span class="c4">Miele G295 Dishwasher</span></td>
		<td>Joeseph Blogs</td>
		<td>09-02-2013</td>
		<td>Not Activated</td>
		<td><button class="btn btn-block btn-warning" type="button">Activate Warranty</button></td> 
	</tr>
	<tr>
		<td><span class="c4">Miele G295 Dishwasher</span></td>
		<td>Joeseph Blogs</td>
		<td>09-02-2013</td>
		<td>15-02-2013</td>
		<td><button class="btn btn-block btn-success" type="button">Active Warranty</button></td> 
	</tr>
	<tr>
		<td><span class="c4">Miele G295 Dishwasher</span></td>
		<td>Stephernardo Conci</td>
		<td>14-01-2013</td>
		<td>22-01-2013</td>
		<td><button class="btn btn-block btn-success" type="button">Active Warranty</button></td> 
	</tr>
	<tr>
		<td><span class="c4">Miele G295 Dishwasher</span></td>
		<td>Joeseph Blogs</td>
		<td>14-01-2013</td>
		<td>22-01-2013</td>
		<td><button class="btn btn-block btn-danger" type="button">Expired Warranty</button></td> 
	</tr>
-->
</table>
<? } ?>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="c6">Activate Warranty</h4>
	</div>
	<div class="modal-body">
		<div class="box">
			<div class="photo"><img src="<?=base_url();?>uploads/products/4.jpg" /></div>
			<div class="info">
				<h3 class="c2">MIELE G7762 DISHWASHER</h3>
				<div class="row-fluid">
					<div class="span4 c4">Part No: 3860121</div>
					<div class="span8 c4">Registration Code: ABC12345</div>
				</div>
				<div class="row-fluid">
					<div class="span3 c4">
						Customer:<br />
						Order Date:				
					</div>
					<div class="span3 c4">
						Paul Trimboli<br />
						20/02/2013
					</div>
					<div class="span4 c4">
						Warranty Start Date:<br />
						Warranty Finish Date:
					</div>
					<div class="span2 c4">
						24/02/2013<br />
						24/02/2014
					</div>
				</div>
			</div>
		</div>
		<hr /><br />
		<h4 class="c6">Enter Registration Code</h4>
		<p>To activate a warranty enter the registration code found in the packaging of the exchanged item</p>
		<input class="input-xlarge pull-left" type="text" placeholder="Enter a product registration code">

	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-success">Active Warranty</a>
	</div>
</div>


<script>
$(function(){	
	$( "#date_from" ).datepicker({
		dateFormat : "dd-mm-yy",
		onClose: function( selectedDate ) {
			$( "#date_to" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#date_to" ).datepicker({
		dateFormat : "dd-mm-yy",
		onClose: function( selectedDate ) {
			$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});	
	$('#icon_date_from').click(function(){
		$( "#date_from" ).datepicker("show");
	});	
	$('#icon_date_to').click(function(){
		$( "#date_to" ).datepicker("show");
	});
});

function select_warranty_status(status)
{
	$('#warranty_status').val(status);
	$('#selected_warranty_status').html(status);
}

</script>
*/ ?>