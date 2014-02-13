<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Venues</h2>
		 <p>Venues are the location in which jobs take place. You can add a venue via the form below or add multiple venues at once by importing a venue list as a .CSV file (<a href="#">Download Sample File</a>). Enter your venue address accurately to ensure your map data gets plotted correctly. Staff select locations they can work in their profile information which relates to the locations of venues.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Add - Edit Venues</h2>
			<p>Add new venues by clicking the "Add New Venue" button or manage your existing venues via the below table.</p>
            
            <button class="btn btn-info btn-rt-margin" data-toggle="modal" href="#addVenue" ><i class="fa fa-plus"></i> Add New Venue</button>
			<button class="btn btn-info"><i class="fa fa-upload"></i> Import Venues</button>
            
            <div class="attr-list-wrap">
                <table class="table table-bordered table-hover table-middle table-expanded">
                    <thead>
                    <tr class="heading">
                        <th class="left col-md-2">Venue Name <i class="fa fa-sort sort-table" sort-by="attribute_venues.name" sort-order="desc"></i></th>
                        <th class="left col-md-3">Address</th>
                        <th class="left col-md-1">Suburb <i class="fa fa-sort sort-table" sort-by="attribute_venues.suburb" sort-order="desc"></i></th>
                        <th class="center col-md-1">Post Code <i class="fa fa-sort sort-table" sort-by="attribute_venues.postcode" sort-order="desc"></i></th>
                        <th class="left col-md-2">Location <i class="fa fa-sort sort-table" sort-by="attribute_locations.name" sort-order="desc"></i></th>
                        <th class="center col-md-1">View Map</th>
                        <th class="center col-md-1">Edit Venue</th>
                        <th class="center col-md-1">Delete Venue</th>
                    </tr>
                    </thead>
                    <tbody id="load-venues">
                   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--end bottom box -->







<!-- Add Venue Modal -->
<div class="modal fade" id="addVenue" tabindex="-1" role="dialog" aria-labelledby="addVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Venue</h4>
			</div>
			<form id="add-new-venue-form">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter venue name">
				</div>
                
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" class="form-control" name="address" id="address" placeholder="Enter venue address">
				</div>
				<div class="form-group">
					<label for="suburb">Suburb</label>
					<input type="text" class="form-control" name="suburb" id="suburb" placeholder="Enter venue suburb">
				</div>
				<div class="form-group">
					<label for="postcode">Postcode</label>
					<input type="text" class="form-control auto-width" name="postcode" id="postcode" placeholder="Enter venue postcode">
				</div>
				<div class="form-group">
					<label>Location</label>
                    <?=modules::run('common/dropdown_location_form', 'location_id');?>
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button id="add-venue" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Venue</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Venue Modal -->
<div class="modal fade" id="editVenue" tabindex="-1" role="dialog" aria-labelledby="editVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Venue</h4>
			</div>
			<form id="edit-new-venue-form">
			<input type="hidden" name="venue_id" id="venue_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter venue name" />
				</div>
				<div class="form-group">
					<label for="address_edit">Address</label>
					<input type="text" class="form-control" name="address" id="address_edit" placeholder="Enter venue address">
				</div>
				<div class="form-group">
					<label for="suburb_edit">Suburb</label>
					<input type="text" class="form-control" name="suburb" id="suburb_edit" placeholder="Enter venue suburb">
				</div>
				<div class="form-group">
					<label for="postcode_edit">Postcode</label>
					<input type="text" class="form-control auto-width" name="postcode" id="postcode_edit" placeholder="Enter venue postcode">
				</div>
                <div class="form-group">
					<label>Location</label>					
                    <?=modules::run('common/dropdown_location_form', 'location_id_edit','');?>
                    
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button  id="edit-venue" type="button" class="btn btn-info">Edit Venue</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
var sort_data = {
	'sort_by':'name',
	'sort_order':'asc'
};

var params = {
	'url': '<?=base_url();?>attribute/ajax/get_venues',
	'output_container':'#load-venues',
	'type':'POST',
	'data':JSON.stringify({"sort_by":"name","sort_order":"asc"})
};


var location_parent_complete = false;

$(function(){
	help.load_content(params);
	
	help.sort_list('.sort-table',params);
	
	$('#add-venue').on('click',function(){
		add_venue();
	});
	
	$('#edit-venue').on('click',function(){
		edit_venue();
	});
});

function add_venue(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/add_venue',
		data:$('#add-new-venue-form').serialize(),
		success: function(html) {
			help.load_content(params);
			$('#addVenue').modal('hide');
		}
	});	 
}

function delete_venue(venue_id){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/delete_venue',
		data:{venue_id:venue_id},
		success: function(html) {
			help.load_content(params);
			$('#confirm_delete_modal').modal('hide');
		}
	});	 
}

function open_edit_modal(venue_id,location_id,location_parent_id, name, address, suburb, postcode){
	$('#venue_id').val(venue_id);
	$('#name_edit').val(name);
	$('#address_edit').val(address);
	$('#suburb_edit').val(suburb);
	$('#postcode_edit').val(postcode);
	$('#editVenue').modal('show');
	
	//update location
	//run this on a delay to make sure this block of code runs
	setTimeout(function(){
		$('#location_id_edit').val(location_parent_id).trigger('change');
	},200,function(){
		//$('#area_location_state').val(location_id).trigger('change');
	});
}

function edit_venue(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/edit_venue',
		data:$('#edit-new-venue-form').serialize(),
		success: function(html) {
			help.load_content(params);
			$('#editVenue').modal('hide');
		}
	});	 
}

</script>
