<? if ($user['parent_id'] != 0) { ?>
Sorry your user access level excludes you from this section
<? } else { ?>

<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url();?>assets/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url();?>assets/colorpicker/css/layout.css" />
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/colorpicker.js"></script>


<h4 class="c6">Upload Your Own Logo</h4>
<p>Change the branding on your Module Repair Centre portal to display your own company logo at the top left of the site<br />
Recommended dimensions: 250px width x 130px height<br />
Allowed file types: JPG, GIF, PNG</p>
    
<form method="post" enctype="multipart/form-data" action="<?=base_url();?>config">
<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="logo-preview">
		<h4 class="c6">Preview Logo</h4>
		<div class="fileupload-preview thumbnail" style="width: 250px; height: 130px;">
			
		</div>
	</div>
	<div>
		<span class="btn btn-file">
			<span class="fileupload-new">Select image</span>
			<span class="fileupload-exists">Change</span>
			<input type="file" name="logo" />
		</span>
		<input type="submit" name="upload_logo" class="btn btn-primary fileupload-exists" value="Upload Logo" />
	</div>
</div>
<? if(isset($result)) { ?>
<div class="alert alert-<?=($result['status']) ? 'success' : 'error';?> pull-left alert-upload">
	<?=$result['message'];?>
</div>
<? } ?>
</form>
<div class="clear"></div>
<div class="shadow"></div>
<br />
<h2 class="c6">Change the Theme & Set your own colours</h2>
<p>Change the colours of your Module Repair Centre so that your own company colours are displayed


<h4 class="c4">Set Primary Colours</h4>
<div class="row">
	<div class="span4">
		<div class="media">
			<a class="pull-left">
				<div class="colorSelector" id="primary_colour">
					<div style="background-color: <?=($user['colour_primary']) ? $user['colour_primary'] : COLOR_PRIM;?>"></div>
				</div>
			</a>
			<div class="media-body">
				<h4 class="media-heading">Select Primary Colour</h4>
				<p>Choose your primary corporate colour<br />
				(Button colours and header strip)</p>
			</div>
		</div>
	</div>
	<div class="span8">
		<div class="media">
			<a class="pull-left">
				<div class="colorSelector" id="secondary_colour">
					<div style="background-color: <?=($user['colour_secondary']) ? $user['colour_secondary'] : COLOR_SECO;?>"></div>
				</div>
			</a>
			<div class="media-body">
				<h4 class="media-heading">Select Secondary Colour</h4>
				<p>Choose a darker version of your corporate colour<br />
				(Button colours)</p>				
			</div>
		</div>
	</div>
</div>


<h4 class="c4">Set Tone Colours</h4>
<div class="row">
	<div class="span4">
		<div class="media">
			<a class="pull-left">
				<div class="colorSelector" id="highlight_colour">
					<div style="background-color: <?=($user['colour_highlight']) ? $user['colour_highlight'] : COLOR_HILI;?>"></div>
				</div>
			</a>
			<div class="media-body">
				<h4 class="media-heading">Highlight Colour</h4>
				<p>Choose a bright-light colour<br />
				(All white text will appear as this colour)</p>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="media">
			<a class="pull-left">
				<div class="colorSelector" id="midtone_colour">
					<div style="background-color: <?=($user['colour_midtone']) ? $user['colour_midtone'] : COLOR_MIDT;?>"></div>
				</div>
			</a>
			<div class="media-body">
				<h4 class="media-heading">Mid tone Colour</h4>
				<p>Choose a middle gray colour<br />
				(All gray text will appear as this colour)</p>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="media">
			<a class="pull-left">
				<div class="colorSelector" id="dark_colour">
					<div style="background-color: <?=($user['colour_dark']) ? $user['colour_dark'] : COLOR_DARK;?>"></div>
				</div>
			</a>
			<div class="media-body">
				<h4 class="media-heading">Dark Colour</h4>
				<p>Choose a dark colour<br />
				(All black text will appear as this colour)</p>
			</div>
		</div>
	</div>
</div>

<? if(isset($colours)) { ?>
<div class="alert alert-success">
	<?=$colours['message'];?>
</div>
<? } ?>
<form method="post" action="<?=base_url();?>config" id="coloursForm">
<input type="hidden" id="colour_primary" name="colour_primary" value="<?=$user['colour_primary'];?>" />
<input type="hidden" id="colour_secondary" name="colour_secondary" value="<?=$user['colour_secondary'];?>" />
<input type="hidden" id="colour_highlight" name="colour_highlight" value="<?=$user['colour_highlight'];?>" />
<input type="hidden" id="colour_midtone" name="colour_midtone" value="<?=$user['colour_midtone'];?>" />
<input type="hidden" id="colour_dark" name="colour_dark" value="<?=$user['colour_dark'];?>" />
<input type="submit" class="btn btn-primary" value="Update Colours" /> &nbsp; 
<button type="button" id="resetColours"class="btn">Reset to Default</button>
</form>
<script>
$(function(){
	$('#resetColours').click(function(){
		$('#colour_primary').val('<?=COLOR_PRIM;?>');
		$('#colour_secondary').val('<?=COLOR_SECO;?>');
		$('#colour_highlight').val('<?=COLOR_HILI;?>');
		$('#colour_midtone').val('<?=COLOR_MIDT;?>');
		$('#colour_dark').val('<?=COLOR_DARK;?>');
		$('#coloursForm').submit();
	})
})

$('#primary_colour').ColorPicker({
	color: '#1868b1',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#primary_colour div').css('backgroundColor', '#' + hex);
		$('#colour_primary').val('#' + hex);
	}
});
$('#secondary_colour').ColorPicker({
	color: '#024c93',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#secondary_colour div').css('backgroundColor', '#' + hex);
		$('#colour_secondary').val('#' + hex);
	}
});

$('#highlight_colour').ColorPicker({
	color: '#ffffff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#highlight_colour div').css('backgroundColor', '#' + hex);
		$('#colour_highlight').val('#' + hex);
	}
});
$('#midtone_colour').ColorPicker({
	color: '#8799a3',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#midtone_colour div').css('backgroundColor', '#' + hex);
		$('#colour_midtone').val('#' + hex);
	}
});
$('#dark_colour').ColorPicker({
	color: '#000000',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#dark_colour div').css('backgroundColor', '#' + hex);
		$('#colour_dark').val('#' + hex);
	}
});
</script>
<? } ?>