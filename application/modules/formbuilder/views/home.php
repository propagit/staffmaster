<script src="<?=base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script>
$(function(){
	$('.component').draggable({
    containment: '#build',
    cursor: 'move',
    helper: 'clone',
    scroll: false,
    connectToSortable: '#build',
    appendTo: '#build',
    start: function (e,ui) {
		$(ui.helper).addClass('ui-draggable-helper');	
	},
    stop: function (event, ui) { form_builder.bind_with_popover();}
	}).mousedown(function () {});
	
	var removeItem = false;
	$('#build').sortable({
		sort: function () {},
		placeholder: 'ui-state-highlight',
		receive: function () {},
		update: function (event, ui) {},
		over:function(){
			removeItem = false;
		},
		out: function () {
            removeItem = true;
        },
		beforeStop: function (event, ui) {
			if(removeItem == true){
				ui.item.remove();   
			}
		}
	});
	form_builder.start_prettychecker();
});//ready


var form_builder = {
	
	//after dropping to the droppable area bind even triggred function to the clone
	//add editing class on click so that we know which container to look for
	bind_with_popover:function(){
		$('#build').find('.component').addClass('dropped');
		$('.dropped').on('click',function(event){
			event.stopImmediatePropagation();
			$(this).addClass('editing');
			form_builder.open_edit_box();
		});
	},
	
	//clean the text so that it can be used for element names and possibly used to populate database fields
	clean_text:function(text){
		text = text.toLowerCase();
		var   spec_chars = {a:/\u00e1/g,e:/u00e9/g,i:/\u00ed/g,o:/\u00f3/g,u:/\u00fa/g,n:/\u00f1/g}
		for (var i in spec_chars) text = text.replace(spec_chars[i],i);
		var hyphens = text.replace(/\s/g,'');
		var clean_text = hyphens.replace(/[^a-zA-Z0-9\-]/g,'');
		clean_text = clean_text.toLowerCase();
		clean_text = clean_text.replace('-','_')
		return clean_text;
	},
	
	//open the popover box for editing
	//each clone has a data attribute which is used as a reference to know which pop over to open
	open_edit_box:function(){
		var editing = $('.editing');
		var popover_id = editing.attr('data');
		form_builder.fillup_editbox(popover_id);
		$('#'+popover_id).show();		
	}, 
	
	//close popover
	close_popover:function(){
		var editing = $('.editing');
		editing.removeClass('editing');
		$('.popover').hide();	
	},
	
	//restart prettycheckable
	start_prettychecker:function(){
		$('input[type="radio"]').prettyCheckable();
		$('input[type="checkbox"]').prettyCheckable();
	},
	
	//restart prettycheckable
	stop_prettychecker:function(){
		$('input[type="radio"]').prettyCheckable('destroy');
		$('input[type="checkbox"]').prettyCheckable('destroy');
	},
	
	//this is used to popupate the edit popover with the currenly active values
	fillup_editbox:function(container_id){
		var editing = $('.editing');
		switch(container_id){
			case 'popover-textinput':
				var label = editing.find('#textinput-label').html();
				var placeholder = editing.find('#textinput').attr('placeholder');
				
				//populate edit box
				$('#pop-textinput').val(label);
				$('#pop-placeholder').val(placeholder);
			break;
			
			case 'popover-textarea':
				var label = editing.find('#textarea-label').html();
				$('#pop-textarea').val(label);
			break;
			
			case 'popover-radio-checkbox':
				form_builder.fillup_radio_or_checkbox_values();
			break;	
			
			case 'popover-select':
				form_builder.fillup_select_values();
			break;
		}
	},
	
	//populate radio and checkbox popver
	fillup_radio_or_checkbox_values:function(){
		$('#pop-radio-checkbox-values').val('');
		var editing = $('.editing');
		var label = editing.find('#radio-checkbox-title').html();
		$('#pop-radio-checkbox-label').val(label);
		
		var value = '';
		var count = 0;
		editing.find('input').each(function(){
			$('#pop-radio-checkbox-values').val($('#pop-radio-checkbox-values').val()+(count == 0 ? '' : '\n')+$(this).val());
			count++;
		});	
	},
	
	//populate select popover
	fillup_select_values:function(){
		$('#pop-select-values').val('');
		var editing = $('.editing');
		var label = editing.find('#select-title').html();
		$('#pop-select-label').val(label);
		
		var value = '';
		var count = 0;
		editing.find('option').each(function(){
			$('#pop-select-values').val($('#pop-select-values').val()+(count == 0 ? '' : '\n')+$(this).val());
			count++;
			console.log($('#pop-select-values').val());
		});	
		console.log(label);
	},
	
	//update textinput with new values
	update_textinput:function(){
		var label = $('#pop-textinput').val();
		var name = form_builder.clean_text(label);
		var placeholder = $('#pop-placeholder').val();
		
		//update form
		var editing = $('.editing');
		editing.find('#textinput-label').html(label);
		editing.find('#textinput').attr('name',name).attr('placeholder',placeholder);
		form_builder.close_popover();
	},
	
	//update text area with new values
	update_textarea:function(){
		var label = $('#pop-textarea').val();
		var name = form_builder.clean_text(label);
		
		//update form
		var editing = $('.editing');
		editing.find('#textarea-label').html(label);
		editing.find('#textarea').attr('name',name);
		form_builder.close_popover();	
	},
	
	//update radio and checkbox with new values
	update_radio_checkbox:function(){
		var label = $('#pop-radio-checkbox-label').val();
		var name = form_builder.clean_text(label);
		//check if this is inline or multi line radio or checkbox
		var element_type = $('.editing').find('#radio-checkbox-title').attr('data');
		var values = $('#pop-radio-checkbox-values').val();
		
		//put the elements from the text area into an array with newline as break point
		var lines = values.split(/\n/);
		var new_values = [];
		for (var i=0; i < lines.length; i++) {
		  // only push this line if it contains a non whitespace character.
		  if (/\S/.test(lines[i])) {
			new_values.push($.trim(lines[i]));
		  }
		}
		
		//set label name
		$('.editing').find('#radio-checkbox-title').html(label);
		
		//create new elements
		var new_elements = '';
		$('.editing').find('.controls').html('');
		switch(element_type){
			case 'multi-radios':
				new_values.forEach(function(entry){
					new_elements += '<label class="radio"><input type="radio" name="'+name+'" value="'+entry+'">'+entry+'</label>';
				});
			break;	
			
			case 'inline-radios':
				new_values.forEach(function(entry){
					new_elements += '<label class="radio inline"><input type="radio" name="'+name+'" value="'+entry+'">'+entry+'</label>';
				});
			break;
			
			case 'multi-checkbox':
				new_values.forEach(function(entry){
					new_elements += '<label class="checkbox"><input type="checkbox" name="'+name+'" value="'+entry+'">'+entry+'</label>';
				});
			break;
			
			case 'inline-checkbox':
				new_values.forEach(function(entry){
					new_elements += '<label class="checkbox inline"><input type="checkbox" name="'+name+'" value="'+entry+'">'+entry+'</label>';
				});
			break;
		}
		$('.editing').find('.controls').html(new_elements);
		form_builder.close_popover();
		form_builder.start_prettychecker();
	},
	
	//update radio and checkbox with new values
	update_select:function(){
		var label = $('#pop-select-label').val();
		var name = form_builder.clean_text(label);
		//check if this is inline or multi line radio or checkbox
		var element_type = $('.editing').find('#select-title').attr('data');
		var values = $('#pop-select-values').val();
		
		//put the elements from the text area into an array with newline as break point
		var lines = values.split(/\n/);
		var new_values = [];
		for (var i=0; i < lines.length; i++) {
		  // only push this line if it contains a non whitespace character.
		  if (/\S/.test(lines[i])) {
			new_values.push($.trim(lines[i]));
		  }
		}
		
		//set label name
		$('.editing').find('#select-title').html(label);
		
		//create new elements
		var new_elements = '';
		var select_options = '';
		$('.editing').find('.controls').html('');
		switch(element_type){
			case 'select-basic':
				new_values.forEach(function(entry){
					select_options += '<option value="'+entry+'">'+entry+'</option>';
				});
				new_elements = '<select id="select-basic" name="'+name+'" class="form-control">'+select_options+'</select>';
			break;	
			
			case 'select-multi':
				new_values.forEach(function(entry){
					select_options += '<option value="'+entry+'">'+entry+'</option>';
				});
				new_elements = '<select id="select-basic" name="'+name+'" class="form-control" multiple="multiple">'+select_options+'</select>';
			break;
		}
		$('.editing').find('.controls').html(new_elements);
		form_builder.close_popover();
		form_builder.start_prettychecker();
	}
	
	
};

</script>
<style>
#build{ min-height:400px; border:1px solid #dddddd; border-radius:4px;}
.right{right: -205px;top: -80px;}
.popover{ left:auto;}
#build .component,.tab-pane .component{ padding:10px 0;}
#build .controls,.tab-pane .controls{ margin-left:180px;}
#build .control-group,.tab-pane .control-group{ margin:10px;}
#build .control-label,.tab-pane .control-label{float: left;/* width: 160px; */padding-top: 5px;text-align: right;}
.popover-content .btn{margin-right: 10px;}
.popover-content .control-label{padding:6px 0 3px 0;}
.ui-draggable-helper {
 border: 1px solid #dddddd;
 background: #fff;
 box-shadow: 10px 10px 5px #dddddd;
}
.radio{ margin-bottom:6px;}
.has-pretty-child{ line-height:30px; float:left; width:100%; margin-top:0;}
.prettycheckbox, .prettyradio{ float:left;}
.radio.inline, .checkbox.inline {
display: inline-block;
padding-top: 5px;
margin-bottom: 0;
vertical-align: middle;
margin-top:0;
padding-right:10px;
width:auto;
}
.push{ float:left;}
</style>

<h2>Form Builder</h2>
<p>Find your staff to communicate with them or view and edit their profile.</p>

<div class="row">
	<div class="col-md-6">
    	<div id="build">
        
        
        
        
        </div><!-- build -->
        
<!--begin inputtext popover-->
<div id="popover-textinput" class="popover fade right in">
<div class="arrow"></div>
<h3 class="popover-title">Text Input</h3>
<div class="popover-content">
<div class="controls">
<label class="control-label"> Label </label>
<input class="form-control" type="text" id="pop-textinput" value="Text Input">
<label class="control-label"> Placeholder </label>
<input class="form-control" type="text"  id="pop-placeholder" value="placeholder">       
<hr>
<button class="btn btn-info" onClick="form_builder.update_textinput();">Save</button><button class="btn btn-danger" onClick="form_builder.close_popover();">Cancel</button>
</div>
</div>
</div>
<!--end inputtext popover-->

<!--begin textarea popover-->
<div id="popover-textarea" class="popover fade right in">
<div class="arrow"></div>
<h3 class="popover-title">Text Area</h3>
<div class="popover-content">
<div class="controls">
<label class="control-label"> Label </label>
<input class="form-control" type="text" id="pop-textarea" value="Text Area">     
<hr>
<button class="btn btn-info" onClick="form_builder.update_textarea();">Save</button><button class="btn btn-danger" onClick="form_builder.close_popover();">Cancel</button>
</div>
</div>
</div>
<!--end textarea popover-->
               
<!--begin radio checkbox popover-->
<div id="popover-radio-checkbox" class="popover fade right in">
<div class="arrow"></div>
<h3 class="popover-title">Radios / Checkboxes</h3>
<div class="popover-content">
<div class="controls"> 
<label class="control-label"> Label </label>
<input class="form-control" data-type="input" type="text" name="label" id="pop-radio-checkbox-label" value="Multiple Radios">
<label class="control-label"> Options </label>
<textarea class="form-control" data-type="textarea-split" style="min-height: 200px" id="pop-radio-checkbox-values"></textarea>
<hr>
<button id="save" class="btn btn-info" onClick="form_builder.update_radio_checkbox();">Save</button><button id="cancel" class="btn btn-danger" onClick="form_builder.close_popover();">Cancel</button>
</div>

</div>
</div>
<!--end radio checkbox popover-->

<!--begin select popover-->
<div id="popover-select" class="popover fade right in">
<div class="arrow"></div>
<h3 class="popover-title">Select</h3>
<div class="popover-content">
<div class="controls"> 
<label class="control-label"> Label </label>
<input class="form-control" data-type="input" type="text" name="label" id="pop-select-label" value="Multiple Radios">
<label class="control-label"> Options </label>
<textarea class="form-control" data-type="textarea-split" style="min-height: 200px" id="pop-select-values"></textarea>
<hr>
<button id="save" class="btn btn-info" onClick="form_builder.update_select();">Save</button><button id="cancel" class="btn btn-danger" onClick="form_builder.close_popover();">Cancel</button>
</div>

</div>
</div>
<!--end select popover-->

        
    </div><!--col-md-6-->
    <div class="col-md-6">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#input" data-toggle="tab">Input</a></li>
            <li><a href="#radioscheckboxes" data-toggle="tab">Radios / Checkboxes</a></li>
            <li><a href="#select" data-toggle="tab">Select</a></li>
            <li><a href="#buttons" data-toggle="tab">Buttons</a></li>
        </ul>
        
        <div class="tab-content">
        
            <!--begin textinput tab-->
            <div class="tab-pane active" id="input">
                <div class="component" data="popover-textinput">
                    <div class="control-group">
                      <label class="control-label" id="textinput-label">Text Input</label>
                      <div class="controls">
                        <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control" >
                      </div>
                    </div>
                </div>
    
                <div class="component" data="popover-textarea"><!-- Textarea -->
                     <div class="control-group">
                        <label class="control-label" id="textarea-label">Text Area</label>
                        <div class="controls">                     
                          <textarea id="textarea" name="textarea" class="form-control"></textarea>
                        </div>
                      </div>
                </div>
            </div>
            <!--end textinput tab-->
            
            <!--begin radio tab-->
            <div class="tab-pane" id="radioscheckboxes">
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Radios -->
                    <div class="control-group">
                      <label class="control-label" id="radio-checkbox-title" data="multi-radios">Multiple Radios</label>
                      <div class="controls">
                        <label class="radio">
                          <input type="radio" name="radios" value="Option one" checked="checked">
                          Option one
                        </label>
                        <label class="radio">
                          <input type="radio" name="radios" value="Option two">
                          Option two
                        </label>
                      </div>
                    </div>
                </div>
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Radios (inline) -->
                    <div class="control-group">
                      <label class="control-label" id="radio-checkbox-title" data="inline-radios">Inline Radios</label>
                      <div class="controls">
                        <label class="radio inline">
                          <input type="radio" name="radios" value="1234">
                          1234
                        </label>
                      </div>
                    </div>
                </div>
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Checkboxes -->
                    <div class="control-group">
                      <label class="control-label" id="radio-checkbox-title" data="multi-checkbox">Multiple Checkboxes</label>
                      <div class="controls">
                        <label class="checkbox">
                          <input type="checkbox" name="checkboxes" value="Option one">
                          Option one
                        </label>
                        <label class="checkbox">
                          <input type="checkbox" name="checkboxes" value="Option two">
                          Option two
                        </label>
                      </div>
                    </div>
                </div>
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Checkboxes (inline) -->
                    <div class="control-group">
                      <label class="control-label" id="radio-checkbox-title" data="inline-checkbox">Inline Checkboxes</label>
                      <div class="controls">
                        <label class="checkbox inline">
                          <input type="checkbox" name="checkboxes" value="1234">
                          1234
                        </label>
                      </div>
                    </div>
                </div>
            </div>
            <!--end radio tab-->
            
            <!--begin select-->
            <div class="tab-pane" id="select">
                <div class="component" data="popover-select"><!-- Select Basic -->
                    <div class="control-group">
                      <label class="control-label" id="select-title" data="select-basic">Select Basic</label>
                      <div class="controls">
                        <select id="select-basic" name="select-basic" class="form-control">
                          <option value="Option one">Option one</option>
                          <option value="Option two">Option two</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="component" data="popover-select"><!-- Select Multiple -->
                     <div class="control-group">
                  <label class="control-label" id="select-title" data="select-multi">Select Multiple</label>
                  <div class="controls">
                    <select id="select-multiple" name="selec-tmultiple" class="form-control" multiple="multiple">
                      <option value="Option one">Option one</option>
                      <option value="Option two">Option two</option>
                    </select>
                  </div>
                </div>
                </div>
			</div>
            <!--end select-->
        
        	<!--begin button-->
            <div class="tab-pane" id="buttons">
            	<div class="component"><!-- File Button --> 
                	<div class="control-group">
                  <label class="control-label">File Button</label>
                  <div class="controls">
                    <input id="filebutton" name="filebutton" class="input-file" type="file">
                  </div>
                </div>
                </div>
			</div>
            <!--end button-->
        </div><!--end tab-content-->
    </div><!--col-md-6-->
</div><!--row-->
