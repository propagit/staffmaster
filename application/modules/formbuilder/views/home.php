<h2>Form Builder</h2>
<p>Find your staff to communicate with them or view and edit their profile.</p>

<div class="row form-builder">
	<div class="col-md-6">
    	<form id="custom-form">
    	<div id="build">
        	<?=modules::run('formbuilder/existing_form_elements');?>
        </div><!-- build -->
        <button type="button" class="btn btn-info" onclick="form_builder.save_form();">Save</button>
        </form>
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

<!--begin button popover-->
<div id="popover-button" class="popover fade right in">
<div class="arrow"></div>
<h3 class="popover-title">Text Input</h3>
<div class="popover-content">
<div class="controls">
<label class="control-label"> Label </label>
<input class="form-control" type="text" id="pop-button" value="Text Input">    
<hr>
<button class="btn btn-info" onClick="form_builder.update_button();">Save</button><button class="btn btn-danger" onClick="form_builder.close_popover();">Cancel</button>
</div>
</div>
</div>
<!--end button popover-->
        
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
                    <div class="control-group" type="textinput">
                      <label class="control-label" id="textinput-label">Text Input</label>
                      <div class="controls">
                        <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control" >
                      </div>
                      <input class="sort-index" type="hidden" value="0" data="textinput"  />
                    </div>
                </div>
    
                <div class="component" data="popover-textarea"><!-- Textarea -->
                     <div class="control-group" type="textarea">
                        <label class="control-label" id="textarea-label">Text Area</label>
                        <div class="controls">                     
                          <textarea id="textarea" name="textarea" class="form-control"></textarea>
                        </div>
                        <input class="sort-index" type="hidden" value="0" data="textarea"  />
                      </div>
                </div>
            </div>
            <!--end textinput tab-->
            
            <!--begin radio tab-->
            <div class="tab-pane" id="radioscheckboxes">
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Radios -->
                    <div class="control-group" type="multi-radios">
                      <label class="control-label" id="radio-checkbox-label" data="multi-radios">Multiple Radios</label>
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
                      <input class="sort-index" type="hidden" value="0" data="radios"  />
                    </div>
                </div>
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Radios (inline) -->
                    <div class="control-group" type="inline-radios">
                      <label class="control-label" id="radio-checkbox-label" data="inline-radios">Inline Radios</label>
                      <div class="controls">
                        <label class="radio inline">
                          <input type="radio" name="radios" value="1234">
                          1234
                        </label>
                      </div>
                      <input class="sort-index" type="hidden" value="0" data="radios"  />
                    </div>
                </div>
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Checkboxes -->
                    <div class="control-group" type="multi-checkbox">
                      <label class="control-label" id="radio-checkbox-label" data="multi-checkbox">Multiple Checkboxes</label>
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
                      <input class="sort-index" type="hidden" value="0" data="checkboxes"  />
                    </div>
                </div>
                <div class="component push" data="popover-radio-checkbox"><!-- Multiple Checkboxes (inline) -->
                    <div class="control-group" type="inline-checkbox">
                      <label class="control-label" id="radio-checkbox-label" data="inline-checkbox">Inline Checkboxes</label>
                      <div class="controls">
                        <label class="checkbox inline">
                          <input type="checkbox" name="checkboxes" value="1234">
                          1234
                        </label>
                      </div>
                      <input class="sort-index" type="hidden" value="0" data="checkboxes"  />
                    </div>
                </div>
            </div>
            <!--end radio tab-->
            
            <!--begin select-->
            <div class="tab-pane" id="select">
                <div class="component push" data="popover-select"><!-- Select Basic -->
                    <div class="control-group" type="select-basic">
                      <label class="control-label" id="select-label" data="select-basic">Select Basic</label>
                      <div class="controls">
                        <select id="select-basic" name="select-basic" class="form-control">
                          <option value="Option one">Option one</option>
                          <option value="Option two">Option two</option>
                        </select>
                      </div>
                      <input class="sort-index" type="hidden" value="0" data="select-basic"  />
                    </div>
                </div>
                <div class="component push" data="popover-select"><!-- Select Multiple -->
                 <div class="control-group" type="select-multi">
                  <label class="control-label" id="select-label" data="select-multi">Select Multiple</label>
                  <div class="controls">
                    <select id="select-multiple" name="selec-tmultiple" class="form-control" multiple="multiple">
                      <option value="Option one">Option one</option>
                      <option value="Option two">Option two</option>
                    </select>
                  </div>
                  <input class="sort-index" type="hidden" value="0" data="select-multiple"  />
                </div>
                </div>
			</div>
            <!--end select-->
        
        	<!--begin button-->
            <div class="tab-pane" id="buttons">
            	<div class="component push" data="popover-button"><!-- File Button --> 
                <div class="control-group" type="filebutton">
                  <label class="control-label" id="filebutton-label">File Button</label>
                  <div class="controls">
                    <input id="filebutton" name="filebutton" class="input-file" type="file">
                  </div>
                  <input class="sort-index" type="hidden" value="0" data=""  />
                </div>
                </div>
			</div>
            <!--end button-->
        </div><!--end tab-content-->
    </div><!--col-md-6-->
</div><!--row-->
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

    stop: function (event, ui) {form_builder.bind_with_popover();}

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
	form_builder.bind_with_popover();
});//ready


var form_builder = {
	
	//after dropping to the droppable area bind even triggred function to the clone
	//add editing class on click so that we know which container to look for
	bind_with_popover:function(){
		$('#build').find('.component').addClass('dropped').removeClass('component');
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

			
			case 'popover-button':
				var label = editing.find('#filebutton-label').html();
				//populate edit box
				$('#pop-button').val(label);
			break;
		}
	},
	
	//populate radio and checkbox popver
	fillup_radio_or_checkbox_values:function(){
		$('#pop-radio-checkbox-values').val('');
		var editing = $('.editing');
		var label = editing.find('#radio-checkbox-label').html();

		$('#pop-radio-checkbox-label').val(label);
		
		var value = '';
		var count = 0;
		editing.find('input').each(function(){
			if(!$(this).hasClass('sort-index')){
				$('#pop-radio-checkbox-values').val($('#pop-radio-checkbox-values').val()+(count == 0 ? '' : '\n')+$(this).val());
				count++;
			}
		});	
	},
	
	//populate select popover
	fillup_select_values:function(){
		$('#pop-select-values').val('');
		var editing = $('.editing');

		var label = editing.find('#select-label').html();

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
		editing.find('.sort-index').attr('data',name);
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
		editing.find('.sort-index').attr('data',name);
		form_builder.close_popover();	
	},
	
	//update radio and checkbox with new values
	update_radio_checkbox:function(){
		var label = $('#pop-radio-checkbox-label').val();
		var name = form_builder.clean_text(label);
		//check if this is inline or multi line radio or checkbox
		var element_type = $('.editing').find('#radio-checkbox-label').attr('data');

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

		$('.editing').find('#radio-checkbox-label').html(label);
		
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
		$('.editing').find('.sort-index').attr('data',name);

		form_builder.close_popover();
		form_builder.start_prettychecker();
	},
	
	//update radio and checkbox with new values
	update_select:function(){
		var label = $('#pop-select-label').val();
		var name = form_builder.clean_text(label);
		//check if this is inline or multi line radio or checkbox
		var element_type = $('.editing').find('#select-label').attr('data');
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
		$('.editing').find('#select-label').html(label);
		
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
		$('.editing').find('.sort-index').attr('data',name);
		form_builder.close_popover();
		form_builder.start_prettychecker();
	},
	
	update_button:function(){
		var label = $('#pop-button').val();
		var name = form_builder.clean_text(label);
		
		//update form
		var editing = $('.editing');
		editing.find('#filebutton-label').html(label);
		editing.find('#filebutton').attr('name',name);
		$('.editing').find('.sort-index').attr('data',name);
		form_builder.close_popover();	
	},
	
	//save custom form
	//the idea here is to parse the final form on submit
	//the reason doing this is it eliminates the need to track each and every element which is dragged in or dragged out of the form builder area
	//feel free to change the code to make it more efficient in the future
	save_form:function(){
		//for input text
		var textinput_attrs = {
				'label':'',
				'name':'',
				'placeholder':''	
			};
		var textinput_array = new Array();
		
		//for textarea
		var textarea_attrs = {
				'label':'',
				'name':''
			};
		var textarea_array = new Array();
		
		//for multi radio
		var multi_radio_attrs = {
				'label':'',
				'name':''	
			};
		var multi_radio_values = {
				'value':''
		};
		var multi_radio_attr_array = new Array();
		var multi_radio_array = new Array();
		
		//for inline radio
		var inline_radio_attrs = {
				'label':'',
				'name':''
			};
		var inline_radio_values = {
				'value':''
		};
		var inline_radio_attr_array = new Array();
		var inline_radio_array = new Array();
		
		//for multi checkbox
		var multi_checkbox_attrs = {
				'label':'',
				'name':''
			};
		var multi_checkbox_values = {
				'value':''
		};
		var multi_checkbox_attr_array = new Array();
		var multi_checkbox_array = new Array();
		
		//for inline checkbox
		var inline_checkbox_attrs = {
				'label':'',
				'name':''	
			};
		var inline_checkbox_values = {
				'value':''
		};
		var inline_checkbox_attr_array = new Array();
		var inline_checkbox_array = new Array();
		
		//for select basic
		var select_basic_attrs = {
			'label':'',
			'name':''
		};
		var select_basic_values = {
			'option':'',
			'value':''
		};
		var select_basic_attr_array = new Array();
		var select_basic_array = new Array();
		
		//for select multi
		var select_multi_attrs = {
			'label':'',
			'name':''
		};
		var select_multi_values = {
			'option':'',
			'value':''
		};
		var select_multi_attr_array = new Array();
		var select_multi_array = new Array();
		
		//for file button
		var filebutton_attrs = {
				'label':'',
				'name':''
			};
		var filebutton_array = new Array();
		
		//c = count
		var it_c = 0;//inputtext
		var ta_c = 0;//textarea
		var mr_c = 0;//multi radios
		var ir_c = 0;//inline radios
		var mc_c = 0;//multi checkbox
		var ic_c = 0;//inline checkbox
		var sb_c = 0;//select basic
		var sm_c = 0;//select multi
		var fb_c = 0;//filebutton 


		var rendered_form = $('#custom-form');
		rendered_form.find('.control-group').each(function(){
			var element_type = $(this).attr('type');
			switch(element_type){
				case 'textinput':
					textinput_attrs['label'] = $(this).find('#textinput-label').html();
					textinput_attrs['name'] = $(this).find('#textinput').attr('name');
					textinput_attrs['placeholder'] = $(this).find('#textinput').attr('placeholder');
					textinput_array[it_c] = JSON.stringify(textinput_attrs);
					it_c++;
				break;

				case 'textarea':
					textarea_attrs['label'] = $(this).find('#textarea-label').html();
					textarea_attrs['name'] = $(this).find('#textarea').attr('name');
					textarea_array[ta_c] = JSON.stringify(textarea_attrs);
					ta_c++;
				break;
				
				case 'multi-radios':
					var pc = 0;//preset values count
					var label = $(this).find('#radio-checkbox-label').html();
					multi_radio_attrs['label'] = label;
					multi_radio_attrs['name'] = form_builder.clean_text(label);
					multi_radio_attr_array[pc] = JSON.stringify(multi_radio_attrs);
					pc++;
					$(this).find('.controls input').each(function(){
						multi_radio_values['value'] = $(this).val();
						multi_radio_attr_array[pc] = JSON.stringify(multi_radio_values);
						pc++;
					});
					multi_radio_array[mr_c] = JSON.stringify(multi_radio_attr_array);
					mr_c++;
				break;
				
				case 'inline-radios':
					var pc = 0;//preset values count
					var label = $(this).find('#radio-checkbox-label').html();
					inline_radio_attrs['label'] = label;
					inline_radio_attrs['name'] = form_builder.clean_text(label);
					inline_radio_attr_array[pc] = JSON.stringify(inline_radio_attrs);
					pc++;
					$(this).find('.controls input').each(function(){
						inline_radio_values['value'] = $(this).val();
						inline_radio_attr_array[pc] = JSON.stringify(inline_radio_values);
						pc++;
					});
					inline_radio_array[ir_c] = JSON.stringify(inline_radio_attr_array);
					ir_c++;
				break;
				
				case 'multi-checkbox':
					var pc = 0;//preset values count
					var label = $(this).find('#radio-checkbox-label').html();
					multi_checkbox_attrs['label'] = label;
					multi_checkbox_attrs['name'] = form_builder.clean_text(label);
					multi_checkbox_attr_array[pc] = JSON.stringify(multi_checkbox_attrs);
					pc++;
					$(this).find('.controls input').each(function(){
						multi_checkbox_values['value'] = $(this).val();
						multi_checkbox_attr_array[pc] = JSON.stringify(multi_checkbox_values);
						pc++;
					});
					multi_checkbox_array[mc_c] = JSON.stringify(multi_checkbox_attr_array);
					mc_c++;
				break;
				
				case 'inline-checkbox':
					var pc = 0;//preset values count
					var label = $(this).find('#radio-checkbox-label').html();
					inline_checkbox_attrs['label'] = label;
					inline_checkbox_attrs['name'] = form_builder.clean_text(label);
					inline_checkbox_attr_array[pc] = JSON.stringify(inline_checkbox_attrs);
					pc++;
					$(this).find('.controls input').each(function(){
						inline_checkbox_values['value'] = $(this).val();
						inline_checkbox_attr_array[pc] = JSON.stringify(inline_checkbox_values);
						pc++;
					});
					inline_checkbox_array[ic_c] = JSON.stringify(inline_checkbox_attr_array);
					ic_c++;
				break;
				
				case 'select-basic':
					var pc = 0;//preset values count
					var label = $(this).find('#select-label').html();
					select_basic_attrs['label'] = label;
					select_basic_attrs['name'] = form_builder.clean_text(label);
					select_basic_attr_array[pc] = JSON.stringify(select_basic_attrs);
					pc++;
					$(this).find('.controls option').each(function(){
						select_basic_values['option'] = $(this).html();
						select_basic_values['value'] = $(this).val();
						select_basic_attr_array[pc] = JSON.stringify(select_basic_values);
						pc++;
					});
					select_basic_array[sb_c] = JSON.stringify(select_basic_attr_array);
					sb_c++;
				break;
				
				case 'select-multi':
					var pc = 0;//preset values count
					var label = $(this).find('#select-label').html();
					select_multi_attrs['label'] = label;
					select_multi_attrs['name'] = form_builder.clean_text(label);
					select_multi_attr_array[pc] = JSON.stringify(select_multi_attrs);
					pc++;
					$(this).find('.controls option').each(function(){
						select_multi_values['option'] = $(this).html();
						select_multi_values['value'] = $(this).val();
						select_multi_attr_array[pc] = JSON.stringify(select_multi_values);
						pc++;
					});
					select_multi_array[sm_c] = JSON.stringify(select_multi_attr_array);
					sm_c++;
				break;
				
				case 'filebutton':
					filebutton_attrs['label'] = $(this).find('#filebutton-label').html();
					filebutton_attrs['name'] = $(this).find('#filebutton').attr('name');
					filebutton_array[fb_c] = JSON.stringify(filebutton_attrs);
					fb_c++;
				break;
			}

		});	
		
		
		//save values to the form
		$('#final_textinput').val(textinput_array);
		$('#final_textarea').val(textarea_array);
		$('#final_multi_radio').val(multi_radio_array);
		$('#final_inline_radio').val(inline_radio_array);
		$('#final_multi_checkbox').val(multi_checkbox_array);
		$('#final_inline_checkbox').val(inline_checkbox_array);
		$('#final_basic_select').val(select_basic_array);
		$('#final_multi_select').val(select_multi_array);
		$('#final_filebutton').val(filebutton_array);
		
		//sort elements
		form_builder.sort_elements();
		
		$('#final_form').submit();
	},
	
	sort_elements:function(){
		var count = 0;
		var sort_order = {
				'name':''
		};
		var sort_order_array = new Array();
		$('#build').find('.sort-index').each(function(){
			sort_order['name'] = $(this).attr('data');
			sort_order_array[count] = JSON.stringify(sort_order);
			count++;
		});
		$('#sort-order').val(sort_order_array);
		
	}

};

</script>
<div style="display:none;">
<form id="final_form" method="post" action="<?=base_url();?>formbuilder/add_form">
	<input id="final_textinput" name="final_textinput" />
    <input id="final_textarea" name="final_textarea" />
    <input id="final_multi_radio" name="final_multi_radio" />
    <input id="final_inline_radio" name="final_inline_radio" />
    <input id="final_multi_checkbox" name="final_multi_checkbox" />
    <input id="final_inline_checkbox" name="final_inline_checkbox" />
    <input id="final_basic_select" name="final_basic_select" />
    <input id="final_multi_select" name="final_multi_select" />
    <input id="final_filebutton" name="final_filebutton" />
    <input id="sort-order" name="sort_order" />
</form>
</div>

