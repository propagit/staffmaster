<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$form['name'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	
	<script src="<?=base_url();?>assets/js/hogan.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.json-2.4.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
	<!-- select2 -->
	<link href="<?=base_url();?>assets/css/select2/select2.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/select2.min.js"></script>
    
	<script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/core.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=base_url();?>custom_styles" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/css/core.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/css/public/form.css" rel="stylesheet" media="screen">
</head>
<body>


<br />
<!-- Begin page content -->
<div class="container-fluid">
    <div class="row">
    	<span class="text-red">**</span> Required Field
    	<h2>Personal Details</h2>
    	<p class="text-muted">Please fill in your personal details</p>
    	<form class="form-horizontal" role="form" method="post">
    	<? foreach($personal_fields as $name => $field) { if(isset($field['active'])) { ?>
			<div class="form-group">
				<label for="<?=$name;?>" class="col-sm-2 control-label">
					<?=$field['label'];?>
					<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
				</label>
				<div class="col-sm-10">
					<? if($name == 'title') { ?>
					<?=modules::run('common/field_select_title', $name);?>
					<? } else if ($name == 'gender') { ?>
					<?=modules::run('common/field_select_genders', $name);?>
					<? } else if ($name == 'dob') { ?>
					<?=modules::run('common/dropdown_dob');?>
					<? } else if ($name == 'state') { ?>
					<?=modules::run('common/field_select_states', $name);?>
					<? } else if ($name == 'country') { ?>
					<?=modules::run('common/field_select_countries', $name);?>
					<? } else { ?>
					<input type="text" class="form-control" id="<?=$name;?>" name="<?=$name;?>" />
					<? } ?>
				</div>
			</div>
    	<? } } ?>
    	
    	<? foreach($extra_fields as $name => $field) { if (isset($field['active'])) { ?>
    	<hr />
	    <h2><?=$field['label'];?></h2>
	    	<? if($name == 'role' && count($roles) > 0) { ?>
    			<p class="text-muted">Please let us know what roles you could perform for us</p>
    			<? foreach($roles as $role) { ?>
    			<div class="checkbox">
					<label>
						<input type="checkbox"> <?=$role['name'];?>
					</label>
				</div>
    			<? }
    		} else if ($name == 'availability') { ?>
    			<p class="text-muted">Let us know what days you can work on</p>
    			<? $days = modules::run('common/array_day'); 
    				foreach($days as $day_no => $day_label) { ?>
    			<div class="checkbox checkbox_day">
					<label>
						<input type="checkbox"> <?=$day_label;?>
					</label>
				</div>	
    			<? }
    		} else if ($name == 'location') { ?>
    			<p class="text-muted">Let us know where you can work</p>
    			<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
    			<div class="clear"></div>
    		<? } else if ($name == 'group' && count($groups) > 0) { ?>
    			<p class="text-muted">Please let us know what group you want to join</p>
    			<? foreach($groups as $group) { ?>
    			<div class="checkbox">
					<label>
						<input type="checkbox"> <?=$group['name'];?>
					</label>
				</div>
    			<? }
    		} else if ($name == 'picture') { ?>
    		<p class="text-muted">Upload photos of yourself so we have a visual refferance of you</p>
    		<? } ?>
    	<? } } ?>    		
    	<hr />
    	<h2>Additional Information</h2>
    	<p class="text-muted">Please provide us with the below information</p>
    	<? foreach($custom_fields as $field) { ?>
    		<div class="form-group">
				<label for="<?=$name;?>" class="col-sm-2 control-label">
					<?=$field['label'];?>
					<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
				</label>
				<div class="col-sm-10">
					<? if($name == 'title') { ?>
					<?=modules::run('common/field_select_title', $name);?>
					<? } else if ($name == 'gender') { ?>
					<?=modules::run('common/field_select_genders', $name);?>
					<? } else if ($name == 'dob') { ?>
					<?=modules::run('common/dropdown_dob');?>
					<? } else if ($name == 'state') { ?>
					<?=modules::run('common/field_select_states', $name);?>
					<? } else if ($name == 'country') { ?>
					<?=modules::run('common/field_select_countries', $name);?>
					<? } else { ?>
					<input type="text" class="form-control" id="<?=$name;?>" name="<?=$name;?>" />
					<? } ?>
				</div>
    		</div>
    	<? } ?>
    		<div class="form-group">
    			<label class="col-sm-2 control-label">&nbsp;</label>
    			<div class="col-sm-10"><button type="submit" class="btn btn-core">Apply Now</button></div>
    		</div>
    	</form>
    </div>
</div>
<script>
$(function(){
	init_select();
})
</script>
</body>
</html>