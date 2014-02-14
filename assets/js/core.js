/* Preloading data functions */
function preloading(obj)
{
	var h = $(obj).height();
	var w = $(obj).width();
	$(obj).prepend('<div id="wrapper_loading" style="height:' + h + 'px;width:' + w + 'px;line-height:' + h + 'px;"><img src="' + base_url + 'assets/img/loading.gif" /></div>');
}
function loaded(obj,html)
{
	setTimeout(function(){
		$(obj).html(html);
	}, 200);
}

/* Reset modal popup */
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});


/**  
	Helper Scripts
*/
var help = {
	
	//email validator
	validate_email:function(emailAddress){
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	
		return pattern.test(emailAddress);
	},
	
	
	//form validator
	//validates input, email, textarea, select
	// use <input data="required" />
	//email <input data="email" />
	validate_form:function(form_id){
		var valid = true;
		var validation_rule = '';
		$('#'+form_id+' input,#'+form_id+' textarea,#'+form_id+' select').each(function(){
			validation_rule = $(this).attr('data');
			switch(validation_rule){
				case 'required':
					if(!$(this).val()){
						valid = false;
						$(this).addClass('error');	
					}else{
						$(this).removeClass('error');
					}
				break;
				
				case 'email':
					if(!$(this).val()){
						valid = false;	
						$(this).addClass('error');
					}else{
						if(!help.validate_email($(this).val())){
							valid = false;
							$(this).addClass('error');	
						}else{
							$(this).removeClass('error');
						}
					}
				break;
				
				case 'checked':
					if(!$(this).is(':checked')){
						valid = false;	
						$(this).addClass('error');
					}else{
						$(this).removeClass('error');
					}
				break;	
			}
		});
		
		if(valid){
			return valid;
			//$('#'+form_id).submit();	
		}
		
	},
	
	//set width of an element to the max width
	//eg find elements with same class name and set width to the max width
	unify_width:function(selector){
		$(selector).css({'min-width':0});
		var max_width = 0;
		$(selector)
		  .each(function() { max_width = Math.max(max_width, $(this).width()); })
		  .css({'min-width':max_width});	
	},
	
	//nav tabs respond
	respond_nav_tab:function(selector,respond_window_width){
		var window_width = $(window).width();
		if(window_width < respond_window_width){
			help.unify_width(selector);		
		}else{
			$(selector).css({'min-width':''});	
		}
	},
	
	
	//check numeric 
	//type: nd = numeric with dot, n = numeric without dot
	//onkeypress="return help.check_numeric(this, event,'n');"
	check_numeric:function(field, event,type){
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		//numeric with dot 0-9,.
		if(type=="nd"){
			if((keyCode >=48 && keyCode<=57)||keyCode==46||keyCode==8||keyCode==9){return true;} 
			else{return false;}
		}
		//numeric without dot		
		if(type=="n"){
			if((keyCode >=48 && keyCode<=57) || keyCode==8 || keyCode==9){return true;} 
			else{return false;}
		}
	},
	
	//scrolls to the top of the page
	go_to_top:function(selector){			
		$(window).scroll(function(){
			$(window).scrollTop() ? $(selector).removeClass('custom-hidden')  : $(selector).addClass('custom-hidden');
		});
		
		$(selector).click(function(){
			$('html, body').animate({ scrollTop:0},300);
		});
	},
	
	//this var is used on open_select function
	custom_select_open:false,
	
	//open select on a button click
	open_select:function(selector){
		if(help.custom_select_open){
			help.custom_select_open = false;	
		}else{
			var element = $(selector)[0], worked = false;
			if (document.createEvent) { // all browsers
				var e = document.createEvent("MouseEvents");
				e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
				worked = element.dispatchEvent(e);
			} else if (element.fireEvent) { // ie
				worked = element.fireEvent("onmousedown");
			} 
			help.custom_select_open = true;
		}

	},
	
	//load content by ajax
	//a generalized function to load ajax content
	//does not have a call back and does not handle json output
	load_content:function(params){
		preloading($(params.output_container));
		$.ajax({
			type: params.type,
			url: params.url,
			data:{params:params.data},
			success: function(html) {
				$(params.output_container).html(html);
			}
		})		
	},
	
	//a generalized function for confirm delete modal
	confirm_delete:function(title,message,callback){
		var delete_modal = '<div class="modal fade" id="confirm_delete_modal" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><h4 class="modal-title">'+title+'</h4></div><input type="hidden" name="role_id" id="role_id" /><div class="col-md-12"><div class="modal-body"><div id="modal-delete-msg">'+message+'</div></div></div><div class="modal-footer"><button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-info confirm-delete">Delete</button></div></div></div></div>';
		$('body').append(delete_modal);
		$('#confirm_delete_modal').modal('show');
		$('.confirm-delete').on('click',function(){
			callback(true);
			$('#confirm_delete_modal').modal('hide');
		});
	},
	
	//sort table
	//uses help.load_content
	sort_list:function(selector,load_params){
		$(selector).on('click',function(){
			sort_data.sort_by = $(this).attr('sort-by');
			//toggle sort order data for next sort
			(sort_data.sort_order == 'asc' ? sort_data.sort_order = 'desc' : sort_data.sort_order = 'asc');	
			load_params.data = JSON.stringify(sort_data);	
			help.load_content(load_params);
		});
	} ,
	
	//submit form data throught ajax
 	submit_form_data:function(form_id,callback){
		$.ajax({
			type: 'POST',
			url: $('#'+form_id).attr('data-url'),
			data:$('#'+form_id).serialize(),
			success: function(html) {
				callback(true);
			}
		});	
	},
	
	//delete data and returns true on success
	delete_data:function(delete_params,load_params){
		$.ajax({
			type: 'POST',
			url: delete_params.url,
			data:{delete_id:delete_params.delete_id},
			success: function(html) {
				help.load_content(load_params);
			}
		});		
	}

	
	
	
	 
};

$(function(){
	help.go_to_top('#go-to-top');	
});