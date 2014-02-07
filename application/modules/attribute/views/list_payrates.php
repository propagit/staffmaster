<link href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet" media="screen" type="text/css" />
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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
var choosen = 0;
function set_payrate()
{
	var crate = $('#crate').val() * 1;
	var srate = $('#srate').val() * 1;
	var setfor = $('#setratesfor').val();
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
		if(setfor == 0)
		{
			$('.ui-selected.input-rate.client').val(crate.toFixed(2));
			$('.ui-selected.input-rate.staff').val(srate.toFixed(2));
		}
		if(setfor == 1)
		{
			$('.ui-selected.input-rate.staff').val(srate.toFixed(2));
		}
		if(setfor == 2)
		{
			$('.ui-selected.input-rate.client').val(crate.toFixed(2));
		}
		$("#setPayrate").modal('hide');
		$(".ui-selectee").each(
			 function(index)
			 {
				 $(this).removeClass('ui-selected');
			 }
		);
	}
	
	$('#form-payrate-'+choosen).submit();
}

</script>
<script>

function build_payrate(id)
{
	//alert(id);
	choosen = id;
	jQuery.ajax({

	url: '<?=base_url() ?>attribute/payrate/build_payrate',

	type: 'POST',

	data: ({id:id}),

	dataType: "html",

	success: function(html) {
		//alert(html);
		$('#payrate-'+id).html(html);
	}

	})
}
</script>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Pay Rates</h2>
		 <p>Manage your pay rates attribute.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Pay Rates</h2>
            <p>Manage your pay rates attribute.</p>
            <button class="btn btn-info" type="button" onclick="add_payrate();">Add Pay Rate</button>
            <br /><br />

            <ul class="nav nav-tabs" id="myTab">
              <!-- <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
              <li><a href="#profile" data-toggle="tab">Profile</a></li>
              <li><a href="#messages" data-toggle="tab">Messages</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
              <?
              $i = 0; 
              foreach($payrates as $payrate) 
              {
                if($this->session->flashdata('payrate_just_updated')) 
                {
                $j = $this->session->flashdata('payrate_just_updated');
                ?>
                <li onclick="build_payrate(<?=$payrate['payrate_id'];?>);" <?php if($j==$payrate['payrate_id']){ echo 'class="active"';}?>><a href="#payrate-<?=$payrate['payrate_id'];?>" data-toggle="tab"><?=$payrate['name'];?></a></li>
                <?	
                }
                else
                {
                ?>
                <li onclick="build_payrate(<?=$payrate['payrate_id'];?>);" <?php if($i==0){ echo 'class="active"';}?>><a href="#payrate-<?=$payrate['payrate_id'];?>" data-toggle="tab"><?=$payrate['name'];?></a></li>
                <?
                }
                
                $i++;
              }
              ?>
             
            </ul>
            
            <div class="tab-content">
              <? 
              $i = 0;
              $cur = 0; 
              foreach($payrates as $payrate) {
                if($i == 0){$cur = $payrate['payrate_id'];}
                $def_staff = number_format($payrate['staff_rate'],2,'.',',');
                $def_client = number_format($payrate['client_rate'],2,'.',',');
                $hour_payrate = $payrate['hour_payrate'];
                $hp = json_decode($hour_payrate,TRUE);
                
                if($this->session->flashdata('payrate_just_updated')) 
                {
                $j = $this->session->flashdata('payrate_just_updated');
                ?>
                <div class="tab-pane <?php if($j==$payrate['payrate_id']){ echo 'active';}?>" id="payrate-<?=$payrate['payrate_id'];?>">
                <?
                }
                else
                {
                ?>
                <div class="tab-pane <?php if($i==0){ echo 'active';}?>" id="payrate-<?=$payrate['payrate_id'];?>">
                <?
                }
                ?>
                    
                </div>
              <? $i++; }?>
              
              <?php 
              if($this->session->flashdata('payrate_just_updated'))
              {
              ?>
              <script>
              choosen = <?=$j?>;
              build_payrate(<?=$j?>);
              </script>
              <?
              }
              else 
              {
              ?>
              <script>
              choosen = <?=$cur?>;
              build_payrate(<?=$cur?>);
              </script>
              <?    
              }
              ?>
              
            </div>
            
        </div>
    </div>
</div>
<!--end bottom box -->






<style>
.label-rate
{
	float:left;
	width:79px;
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
					  <span class="input-group-addon">$ (Per Hour)</span>
					  <input type="text" class="form-control" id="srate" placeholder="staff rate">
					</div>
				</div>
				<div class="form-group">
					<label for="name">Client Rate</label>
					<div class="input-group">
					  <span class="input-group-addon">$ (Per Hour)</span>
					  <input type="text" class="form-control" id="crate" placeholder="client rate">
					</div>
				</div>
				<div class="form-group">
					<label for="staff_rate">Staff / Client</label>
					<select class="form-control" id="setratesfor">
						<option value="0">Both staff and client</option>
						<option value="1">Only staff</option>
						<option value="2">Only client</option>
					</select>
				</div>
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
function add_payrate()
{
	$('#addPayrate').modal('show');
}
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