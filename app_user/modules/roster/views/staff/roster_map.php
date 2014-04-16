<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?=$venue['name'];?></h4>
			<b>Address:</b> <?=$venue['address'] . ', ' . $venue['suburb'];?>
		</div>
		<div class="modal-body">
			<iframe src="<?php echo base_url('roster/ajax/map/' . $venue['venue_id']);?>"></iframe>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
