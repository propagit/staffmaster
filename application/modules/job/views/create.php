<h2>Create Job</h2>
<p><b>Step 1</b> - Create a job folder name to store jobs in and choose a job creation style.</p>

<a href="<?=base_url();?>job/search"><i class="fa fa-search"></i> Search Jobs</a>
<br /><br />
<div class="panel panel-default">
	<div class="panel-heading">Create New Job - <b>Step 1</b></div>
	<div class="panel-body">		
		<form class="form-horizontal" role="form" method="post" action="<?=base_url();?>job/create">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group<?=form_error('name')? ' has-error' : '';?>">
					<label for="name" class="col-lg-4 control-label">Job Group Name</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" name="name" id="name" value="<?=set_value('name');?>" />
					</div>
				</div>
				<div class="form-group<?=form_error('client_id')? ' has-error' : '';?>">
					<label for="client_id" class="col-lg-4 control-label">Client</label>
					<div class="col-lg-8">
						<?=modules::run('client/dropdown', 'client_id', set_value('client_id'));?>
					</div>
				</div>
			</div>
						
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<div class="col-lg-offset-4 col-lg-8">
						<button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Create Job</button>
					</div>
				</div>
			</div>
		</div>
		
		
		</form>
	</div>
</div>