<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Manage Custom Attributes</h2>
		 <p class="desktop-visible">
         Add custom attributes that can be assigned to your staff profiles.<br  />
         Drag and drop questions from the menu on the right to create custom attributes.<br  />
		 After dragging the questions to the form box click the attribute to edit the question. 
         </p>
         <p class="desktop-hidden">
         Add custom attributes that can be assigned to your staff profiles.
         Drag and drop questions from the menu on the right to create custom attributes.
		 After dragging the questions to the form box click the attribute to edit the question. 
         </p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Custom Attributes</h2>
			<p>Drag questions to the form box, after dragging the question click to edit the attribute</p>
			
			<div class="row form-builder">
				<div class="col-md-6 custom-attributes">
			    	<div id="build">
			        	
			        </div><!-- build -->
			        
			        <div id="popover-field" class="popover fade right in"></div>
				
				</div>
				<div class="col-md-6 custom-attributes">
					<ul class="nav nav-tabs tab-respond" id="myTab">
						<li class="active"><a href="#text" data-toggle="tab">Text</a></li>
						<li><a href="#radioscheckboxes" data-toggle="tab">Radios / Checkboxes</a></li>
						<li><a href="#select" data-toggle="tab">Select</a></li>
						<li><a href="#fileupload" data-toggle="tab">File Upload</a></li>
					</ul>
					
					<div class="tab-content">
						
						<!--begin textinput tab-->
						<div class="tab-pane active" id="text">
						
							<div class="component" data-type="text">
								<div class="control-group">
									<label class="control-label">Text Input</label>
									<div class="controls">
										<input type="text" placeholder="placeholder" class="form-control" >
									</div>
								</div>
							</div>
									
							<div class="component" data-type="textarea"><!-- Textarea -->
								<div class="control-group">
									<label class="control-label">Text Area</label>
									<div class="controls">                     
										<textarea class="form-control"></textarea>
									</div>
								</div>
							</div>
							
						</div>
						<!--end textinput tab-->
			            
			            <!--begin radio tab-->
			            <div class="tab-pane" id="radioscheckboxes">
			            	<!-- Multiple Radios -->
							<div class="component" data-type="radio">
								<div class="control-group">
									<label class="control-label">Multiple Radios</label>
									<div class="controls">
										<label class="radio">
											<input type="radio" name="radio1" /> Option one
										</label>
										<label class="radio">
											<input type="radio" name="radio1" /> Option two
										</label>
									</div>									
								</div>
							</div>
							<!-- Multiple Radios (inline) -->
							<div class="component" data-type="radio" data-inline="true">
								<div class="control-group">
									<label class="control-label">Inline Radios</label>
									<div class="controls">
										<label class="radio inline">
											<input type="radio" name="radio2" /> Option one
										</label>
										<label class="radio inline">
											<input type="radio" name="radio2" /> Option two
										</label>
									</div>
								</div>
							</div>
							<!-- Multiple Checkboxes -->
							<div class="component" data-type="checkbox" data-multiple="true">
								<div class="control-group">
									<label class="control-label">Multiple Checkboxes</label>
									<div class="controls">
										<label class="checkbox">
											<input type="checkbox" name="checkboxe1" /> Option one
										</label>
										<label class="checkbox">
											<input type="checkbox" name="checkboxe1" />	Option two
										</label>
									</div>
								</div>
							</div>
							
							<!-- Multiple Checkboxes (inline) -->
							<div class="component" data-type="checkbox" data-multiple="true" data-inline="true">
								<div class="control-group">
									<label class="control-label">Inline Checkboxes</label>
									<div class="controls">
										<label class="checkbox inline">
											<input type="checkbox" name="checkboxe2" /> Option one
										</label>
										<label class="checkbox inline">
											<input type="checkbox" name="checkboxe2" /> Option two
										</label>
									</div>
								</div>
							</div>
						</div>
			            <!--end radio tab-->
			            
						<!--begin select-->
						<div class="tab-pane" id="select">
							<!-- Select Basic -->
							<div class="component" data-type="select">
								<div class="control-group">
									<label class="control-label">Select Basic</label>
									<div class="controls">
										<select class="form-control">
											<option>Option one</option>
											<option>Option two</option>
										</select>
									</div>
								</div>
							</div>
							<!-- Select Multiple -->
							<div class="component" data-type="select" data-multiple="true">
								<div class="control-group">
									<label class="control-label">Select Multiple</label>
									<div class="controls">
										<select class="form-control" multiple="multiple">
											<option>Option one</option>
											<option>Option two</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<!--end select-->
			        
						<!--begin button-->
						<div class="tab-pane" id="fileupload">
							<!-- File Button -->
							<div class="component" data-type="file"> 
								<div class="control-group">
									<label class="control-label">File Button</label>
									<div class="controls">
										<input class="input-file" type="file" />
									</div>
								</div>
							</div>
						</div>
						<!--end button-->
			        </div><!--end tab-content-->
				</div>
			</div>			        
			        
    	</div>
	</div>
</div>

<script src="<?=base_url();?>assets/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script>
$(function(){
	load_custom_fields();
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
		stop: function (event, ui) {
			form_builder.bind_with_popover();
			$('.drag-icon-box').remove();	
			$('#build').addClass('build-bottom-padding');
			var type = ui.helper.attr('data-type');
			var inline = ui.helper.attr('data-inline');
			var multiple = ui.helper.attr('data-multiple');
			var label = ui.helper.find('.control-label').html();
			var placeholder = ui.helper.find('.control-group').find('input').attr('placeholder');
			//alert(type + '/' + inline + '/' + multiple + '/' + label + '/' + placeholder);
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>attribute/ajax_custom/add_field",
				data: {type: type, inline: inline, multiple: multiple, label: label, placeholder: placeholder},
				success: function(html) {
					load_custom_fields();
				}
			})
		}
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
});//ready

function load_custom_fields() {
	preloading($('#build'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>attribute/ajax_custom/get_fields",
		success: function(html) {
			loaded($('#build'), html);
		}
	})
}

function delete_field(field_id) {
	help.confirm_delete('Delete field','Are you sure you want to delete this field?',function(confirmed){
		 if(confirmed){
			 $.ajax({
				 type: "POST",
				 url: "<?=base_url();?>attribute/ajax_custom/delete_field",
				 data: {field_id: field_id},
				 success: function(html) {
				 	if (html == 'true') {
					 	load_custom_fields();
				 	} else {
					 	alert(html);
				 	}					 
				 }
			 })
		 }
	});
}
function edit_field(field_id) {
	$('.popover').hide();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>attribute/ajax_custom/load_field_edit_form",
		data: {field_id: field_id},
		success: function(html) {
			$('#popover-field').html(html);
			var p = $('#field_' + field_id).position();
			$('#popover-field').css('top', (p.top - 110) + 'px');
			$('#popover-field').show();	
		}
	})
}

var form_builder = {
	

	
	sort_elements:function(){
		var count = 0;
		var sort_order = {
				'field_id':''
		};
		var sort_order_array = new Array();
		$('#build').find('.sort-index').each(function(){
			sort_order['field_id'] = $(this).attr('data');
			sort_order_array[count] = JSON.stringify(sort_order);
			count++;
		});
		$('#sort-order').val(sort_order_array);
		
	}

};
</script>
