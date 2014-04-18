<div class="staff-profile-detail-box">
	<h2> Settings </h2>
	<p> Staff can choose the "setting" </p>
</div>
<form class="form-horizontal" role="form">
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Level Access</label>
		<div class="col-md-4">
			<?
				$array = array(
					array('value' => 'Staff', 'label' => 'Staff'),
					array('value' => 'Admin', 'label' => 'Admin')
				);
				echo modules::run('common/field_select', $array, 'level_access');
			?>
		</div>
	</div>
	<? /*
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Conversations</label>
		<div class="col-md-4">
			<?
				$array = array(
					array('value' => 'Invited Conversations Only', 'label' => 'Invited Conversations Only')
				);
				echo modules::run('common/field_select', $array, 'conversation');
			?>
		</div>
	</div>
	
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Induction Status</label>
		<div class="col-md-10">
			<div class="alert alert-success media">
				<div class="pull-left">
					<i class="fa fa-check"></i>
				</div>
				<div class="pull-right">
					<?
						$array = array(
							array('value' => 'Induction Completed', 'label' => 'Induction Completed')
						);
						echo modules::run('common/field_select', $array, 'induction');
					?>
				</div>
				<div class="media-body">
					<h4>Induction Completed</h4>
					<h6>Induction completed on 24/03/2013</h6>
				</div>
			</div>
		</div>
	</div>
	*/ ?>
</div>