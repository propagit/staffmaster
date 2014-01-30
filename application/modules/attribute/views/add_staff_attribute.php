<script src="<?=base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script>
$(function(){
	$('.component').draggable({
    cursor: 'move',
    helper: 'clone',
    scroll: false,
    connectToSortable: '#build',
    appendTo: '#build',
    start: function () {},
    stop: function (event, ui) { my_popover();}
	}).mousedown(function () {});

	 $('#build').sortable({
		sort: function () {},
		placeholder: 'ui-state-highlight',
		receive: function () {},
		update: function (event, ui) {}
	});
	
	$('.dropped').on('dblclick', function () {
		$(this).remove();
	}); 

	
	

});

function my_popover()
{
	$('#build .component').on('click',function(e){
		e.stopImmediatePropagation();
		var popover_id = $(this).attr('pop-over');
		$(this).addClass('editing');
		$('#'+popover_id).show();
	});
}

function edit_input(form){
	switch(form){
		case 'input_text':
			//label text will be cleaned and used as the name for the input field as well
			var pop_label = $('#pop-textinput-label').val();
			var pop_placeholder = $('#pop-textinput-placeholder').val();
			
			var textinput_label = $('.editing #textinput-label');
			var textinput = $('.editing #textinput');
			
			textinput_label.html(pop_label);
			textinput.attr('name',remove_special_chars(pop_label));
			textinput.attr('placeholder',pop_placeholder);
			
			$('#popover-textinput').hide();
			$('#build .component').removeClass('editing')
		break;	
		
	}
	
	
}

function close_me(){
	$('.popover').hide();	
}

function remove_special_chars(text){
	text = text.toLowerCase();
	var   spec_chars = {a:/\u00e1/g,e:/u00e9/g,i:/\u00ed/g,o:/\u00f3/g,u:/\u00fa/g,n:/\u00f1/g}
	for (var i in spec_chars) text = text.replace(spec_chars[i],i);
	var hyphens = text.replace(/\s/g,'-');
	var clean_text = hyphens.replace(/[^a-zA-Z0-9\-]/g,'');
	clean_text = clean_text.toLowerCase();
	return clean_text;
}

</script>
<style>
#build{ border:2px solid #000; min-height:400px;}
</style>
<h2>Manage Custom Attributes</h2>

<p>Manage your custom attribute.</p>



<div class="col-md-6">
    <div id="build">
    
    
    
    
    	
    </div>
    
    <!--pop overs-->
    <div id="popover-textinput" class="popover fade right in">
        <div class="arrow"></div>
        <h3 class="popover-title">Input Field</h3>
        <div class="popover-content">
        <div class="popover-content">
            <div class="controls">               
                <label class="control-label"> Label Text </label>
                <input class="form-control" data-type="input" type="text" id="pop-textinput-label" value="Text Input" />
                <label class="control-label"> Placeholder </label>
                <input class="form-control" data-type="input" type="text" id="pop-textinput-placeholder" value="placeholder" />
                <hr>
                <button onclick="edit_input('input_text');" class="btn btn-info">Save</button><button onclick="close_me();" id="cancel" class="btn btn-danger">Cancel</button>
              </div>
            </div>
        </div>
    </div>
    
    <div id="popover-textarea" class="popover fade right in">
        <div class="arrow"></div>
        <h3 class="popover-title">A Title</h3>
        <div class="popover-content">
        text area
        </div>
    </div>
    <!--end pop overs-->
</div>


<div class="col-md-6">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#input" data-toggle="tab">Input</a></li>
        <li><a href="#radios" data-toggle="tab">Radios / Checkboxes</a></li>
        <li><a href="#select" data-toggle="tab">Select</a></li> 
        <li><a href="#buttons" data-toggle="tab">Buttons</a></li> 
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="input">
            <div class="component" pop-over="popover-textinput"><!-- Text input-->
                <div class="control-group">
                   <label id="textinput-label">Text Input</label>
                  <div class="controls">
                    <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control"  />
                  </div>
                </div>
            </div>
            
            <div class="component" pop-over="popover-textarea"><!-- Textarea -->
                <div class="control-group">
                  <label>Text Area</label>
                  <div class="controls">                     
                    <textarea name="textarea" class="form-control">default text</textarea>
                  </div>
                </div>
            </div>
        </div><!--end input tab-->
        
        
        <div class="tab-pane" id="radios">
            
        </div>    
    </div><!--end tab-content-->

</div>

    
    



