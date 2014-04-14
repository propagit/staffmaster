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
            
            <button id="open-add-venue-modal" class="btn btn-info btn-rt-margin"><i class="fa fa-plus"></i> Add New Venue</button>
			<a class="btn btn-info" href="<?=base_url();?>attribute/venue/import"><i class="fa fa-upload"></i> Import Venues</a>
            
            <div id="load-venues" class="attr-list-wrap">
               
            </div>
        </div>
    </div>
</div>

<!-- Add Venue Modal -->
<div class="modal fade" id="addVenue" tabindex="-1" role="dialog" aria-labelledby="addVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add Venue</h4>
			</div>
			<form id="add-new-venue-form">
            <div class="col-md-12">
                <div class="modal-body">
                	<h4 class="modal-body-title">Enter Venue Name</h4>
                    <p>
                    Venues are the location your jobs are held at. When creating jobs you will need to add a venue the job is taking place in.
                    </p>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter venue name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter venue address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="suburb" class="col-sm-2 control-label">Suburb</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="suburb" id="suburb" placeholder="Enter venue suburb">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="postcode" class="col-sm-2 control-label">Postcode</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control auto-width" name="postcode" id="postcode" placeholder="Enter venue postcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-sm-2 control-label">Location</label>
                        <div id="load-current-location-add" class="col-sm-10 select-btm-margin">
                            <? //modules::run('attribute/location/field_select','parent_location_id');?>
                        </div>
                    </div>
                     <div class="form-group">
                               <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                          <div class="col-sm-10">
                              <button id="add-venue" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Venue</button>
                          </div>
                      </div>
                </div>
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Edit Venue</h4>
			</div>
			<form id="edit-new-venue-form">
            <div class="col-md-12">
                <input type="hidden" name="venue_id" id="venue_id" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_edit" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter venue name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address_edit" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="address" id="address_edit" placeholder="Enter venue address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="suburb_edit" class="col-sm-2 control-label">Suburb</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="suburb" id="suburb_edit" placeholder="Enter venue suburb">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="postcode_edit" class="col-sm-2 control-label">Postcode</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control auto-width" name="postcode" id="postcode_edit" placeholder="Enter venue postcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-sm-2 control-label">Location</label>
                        <div id="load-current-location-edit" class="col-sm-10 select-btm-margin">
                            
                        </div>
                    </div>
                    <div class="form-group">
                           <label for="edit-button" class="col-sm-2 control-label">&nbsp;</label>
                          <div class="col-sm-10">
                              <button  id="edit-venue" type="button" class="btn btn-info">Edit Venue</button>
                          </div>
                    </div>
                </div>
            </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>

var sort_data = {
	'sort_by':'name',
	'sort_order':'asc',
	'current_page':1
};

var params = {
	'url': '<?=base_url();?>attribute/ajax/get_venues',
	'output_container':'#load-venues',
	'type':'POST',
	'data':JSON.stringify(sort_data)
};


var location_parent_complete = false;

$(function(){
	help.load_content(params);
	
	//open add venue modal
	$('#open-add-venue-modal').on('click',function(){
		//remove location from edit modal as this will create conflict
		$('#load-current-location-edit').html('');
		$('#addVenue').modal('show');
		$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/load_current_locations',
		data:'',
		success: function(html){
			$('#load-current-location-add').html(html);
			load_areas();
			}
		});	
	});
	
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
	//remove location from add modal as this will create conflict
	$('#load-current-location-add').html('');
	
	
	//update location
	//run this on a delay to make sure this block of code runs
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/load_current_locations',
		data:{location_id:location_id, location_parent_id:location_parent_id},
		success: function(html){
			$('#load-current-location-edit').html(html);
			load_areas();
		}
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
