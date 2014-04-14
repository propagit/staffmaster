<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url();?>assets/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url();?>assets/colorpicker/css/layout.css" />
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/colorpicker.js"></script>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>System Styles</h2>
		 <p>
         	Change the colours of the system look and feel to suite your companies branding.<br />
            The primary colour can be changed and the text colour used throughout the system
         </p>
    </div>
</div>
<!--end top box-->


<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box push full-width">
           <h2>Primary Colour</h2>
		   <p>The primary colour is used on all buttons and on the menu bar.</p>
           
           <div class="row">
               <div class="col-md-2 remove-gutters system-styles-label">Current Primary Colour</div>
               <div class="colorSelector col-md-6" id="primary_colour">
                  <div style="background-color:<?=$styles['primary_colour'];?>"></div>
               </div>
           </div>
                
           <h2>Secondary Colour</h2>
		   <p>The primary colour is used on all buttons text and on the menu bar text.</p>
           <div class="row">
               <div class="col-md-2 remove-gutters system-styles-label">Current Primary Colour</div>
               <div class="colorSelector col-md-6" id="secondary_colour">
                  <div style="background-color:<?=$styles['secondary_colour'];?>"></div>
               </div>
           </div>
           
           <h2>Rollover Colour</h2>
		   <p>The rollover colour will appear when a mouse is hovered on a link</p>
           <div class="row">
               <div class="col-md-2 remove-gutters system-styles-label">Current Rollover Colour</div>
               <div class="colorSelector col-md-6" id="rollover_colour">
                  <div style="background-color:<?=$styles['rollover_colour'];?>"></div>
               </div>
           </div>
           
           <h2>Text Colour</h2>
		   <p>Update the txt colour used throughout the system</p>
           <div class="row">
               <div class="col-md-2 remove-gutters system-styles-label">Current Primary Colour</div>
               <div class="colorSelector col-md-6" id="text_colour">
                  <div style="background-color:<?=$styles['text_colour'];?>"></div>
               </div>
           </div>

           <div class="row">
                <form method="post" action="<?=base_url();?>setting/update_system_styles" id="styles_form">
                    <input type="hidden" id="primary_colour_input" name="primary_colour" value="<?=$styles['primary_colour'];?>" /> 
                    <input type="hidden" id="secondary_colour_input" name="secondary_colour" value="<?=$styles['secondary_colour'];?>" />
                    <input type="hidden" id="rollover_colour_input" name="rollover_colour" value="<?=$styles['rollover_colour'];?>" />
                    <input type="hidden" id="text_colour_input" name="text_colour" value="<?=$styles['text_colour'];?>" />
                    <button type="submit" class="btn btn-core">Update Styles</button>
                    <button type="button" id="reset_colours"class="btn btn-core">Reset to Default</button>
                </form>
           </div>
        </div>
    </div>
</div>

<script>
$(function(){
	init_colour_picker('#primary_colour','<?=$styles['primary_colour'];?>');
	init_colour_picker('#rollover_colour','<?=$styles['rollover_colour'];?>');
	init_colour_picker('#secondary_colour','<?=$styles['secondary_colour'];?>');
	init_colour_picker('#text_colour','<?=$styles['text_colour'];?>');
	
	$('#reset_colours').on('click',function(){
		reset_to_default_styles();
	});
});



function init_colour_picker(colour_id,current_colour)
{
	$(colour_id).ColorPicker({
		color: current_colour,
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$(colour_id+' div').css('backgroundColor', '#' + hex);
			$(colour_id+'_input').val('#' + hex);
		}
	});	
}

function reset_to_default_styles()
{
	$('#primary_colour_input').val('<?=COLOUR_PRIM;?>');
	$('#rollover_colour_input').val('<?=COLOUR_ROLL;?>');
	$('#secondary_colour_input').val('<?=COLOUR_SECO;?>');
	$('#text_colour_input').val('<?=TEXT_COLOUR;?>');
	$('#styles_form').submit();
}
</script>