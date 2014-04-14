<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/resource">Resources Management</a> <span class="divider">/</span></li>
	<li class="active">Create New Resource</li>
</ul>

<div class="box">
<form method="post" action="<?=base_url();?>admin/resource/create">
	<div class="form-horizontal">
		<div class="control-group<?=form_error('resource_title') ? ' error' : '';?>">
			<label class="control-label" for="resource_title">Resource Title</label>
			<div class="controls">
				<input type="text" id="resource_title" name="resource_title" value="<?=set_value('resource_title');?>" />
				<span class="help-inline"><?=form_error('resource_title');?></span>
			</div>
		</div>
		<div class="control-group textarea">
			<label class="control-label" for="resource_description">Resource Description</label>
			<div class="controls">
				<textarea rows="10" id="resource_description" name="resource_description"><?=set_value('resource_description');?></textarea>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="survey_link">Survey Link</label>
			<div class="controls">
				<input type="text" class="input-xxlarge" id="survey_link" name="survey_link" placeholder="http://" value="<?=set_value('survey_link');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="youtube_link">Embed Video</label>
			<div class="controls">
				<input type="text" class="input-xxlarge" id="youtube_link" name="youtube_link" placeholder="http://" value="<?=set_value('youtube_link');?>" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Create Resource</button>
			</div>
		</div>
	</div>
</form>
</div>