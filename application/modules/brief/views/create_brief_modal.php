<!-- Add Brief Modal -->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h4 class="modal-title">Add Brief</h4>
        </div>
        <div class="col-md-12">
            <form id="add-new-brief-form" action="<?=base_url();?>brief/create_brief" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="brief_name" id="brief_name" placeholder="Enter brief name" data="required">
                    </div>
                </div>
                <div class="form-group">
                         <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <button id="add-new-brief-btn" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add New Brief</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<script>
$(function(){
	$('#add-new-brief-btn').on('click',function(){
		if(help.validate_form('add-new-brief-form')){
			$('#add-new-brief-form').submit();	
		}
	});
});

</script>