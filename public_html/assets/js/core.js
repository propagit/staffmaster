function select_menu(id, value, label) {
	$('#menu-' + id + ' ul li a').each(function(i, e){
		if ($(this).attr('data-value') == value) {
			$('#menu-' + id + ' .menu-label').html(label + ': ' + $(this).html());
		}
	});
}
function init_select()
{
	if($(window).width() >= 768){
		$('select').select2();
	}
}
/* Preloading data functions */
function preloading(obj)
{
	var h = $(obj).height();
	var w = $(obj).width();
	$(obj).prepend('<div id="wrapper_loading" style="height:' + h + 'px;width:' + w + 'px;line-height:' + h + 'px;"><img src="' + base_url + 'assets/img/loading.gif" /></div>');
}
function loaded(obj,html)
{
	if (html != null) {
		setTimeout(function(){
			//console.log(html);
			$(obj).html(html);
		}, 200);
	} else {
		setTimeout(function(){
			$(obj).find('#wrapper_loading').remove();
		}, 200);
	}
}
/* Disable element */
function disabled(obj)
{
	var w = $(obj).width();
	var h = $(obj).height();
	$(obj).append('<div class="wrapper_disabled" style="height:' + h + 'px;width:' + w + 'px;margin-left:-' + (w - 1) + 'px;line-height:' + h + 'px;"><div class="content-disabled"></div></div>');
}

/* Reset modal popup */
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});


/* Reset page number */
function reset_current_page(){
	$('#current_page').val(1);
}
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
		if(type == "nd"){
			if((keyCode >=48 && keyCode<=57)||keyCode==46||keyCode==8||keyCode==9){return true;} 
			else{return false;}
		}
		//numeric without dot		
		if(type == "n"){
			if((keyCode >=48 && keyCode<=57) || keyCode==8 || keyCode==9){return true;} 
			else{return false;}
		}
		
		//hyphen
		if(type == "h"){
			if((keyCode >=48 && keyCode<=57) || keyCode==8 || keyCode==9 || keyCode==45){return true;} 
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
			var element = $(selector)[0];
			var worked = false;
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
		var delete_modal = '<div class="modal fade" id="confirm_action_modal" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><h4 class="modal-title">'+title+'</h4></div><input type="hidden" name="role_id" id="role_id" /><div class="col-md-12"><div class="modal-body"><div id="modal-delete-msg">'+message+'</div></div></div><div class="modal-footer"><button type="button" class="btn btn-info" data-dismiss="modal">No</button><button type="button" class="btn btn-info confirm-action">Yes</button></div></div></div></div>';
		$('body').append(delete_modal);
		$('#confirm_action_modal').modal('show');
		$('.confirm-action').on('click',function(){
			callback(true);
			$('#confirm_action_modal').modal('hide');
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
	},
	
	//check uncheck all checkbox
	toggle_checkboxes:function(master,slaves){
		$(master).on('change',function(){
			if ($(master).is(':checked')) {
            	$(slaves).prop("checked", true);
       		 } else {
            	$(slaves).prop("checked", false);
        	}	
		});	
	},
	
	create_conversation:function(container_id,action_url){
		$(document).on('click','#start-conversation',function(){
			if(help.validate_form('start-conversation-form')){
				$('#start-conversation-form').submit();	
			}
		});
	
		$(document).on('submit','#start-conversation-form',function(){
			preloading($('#start-conversation-tab'));
			$(this).ajaxSubmit(function(html){
				$('#msg-conversation-started-successfully').removeClass('hide');
				setTimeout(function(){
					$('#msg-conversation-started-successfully').addClass('hide');
				}, 2000);
				help.reload_conversations(container_id,action_url);	
				$('#wrapper_loading').remove();
			});	
			return false;
		});
	},
	
	create_poll:function(container_id,action_url){
		$(document).on('click','#create-poll',function(){
			if(help.validate_form('create-poll-form')){
				$('#create-poll-form').submit();	
			}
		});
	
		$(document).on('submit','#create-poll-form',function(){
			preloading($('#create-poll-tab'));
			$(this).ajaxSubmit(function(html){
				$('#msg-poll-started-successfully').removeClass('hide');
				setTimeout(function(){
					$('#msg-poll-started-successfully').addClass('hide');
				}, 2000);
				help.reload_conversations(container_id,action_url);	
				$('#wrapper_loading').remove();
			});	
			return false;
		});
	},
	
	//reload conversations
	reload_conversations:function(container_id,action_url){
		$.ajax({
			type: "POST",
			url: action_url,
			success: function(html) {
				$('#'+container_id).html(html);
			}
		})	
	},
	
	//inline - x-editable
	make_x_editable_inline:function(){
		if($(window).width() <= 768){
			$.fn.editable.defaults.mode = 'inline';	
		}	
	},
	
	sticky_footer:function(){
		var wh = $(window).height();//window height
		var hh = $('#sm-head-wrap').height();//header height
		var bh = $('#sm-body-wrap').height();//body height	
		var fh = $('#sm-footer-wrap').height();//footer height
		var min_height = 0;
		var sum_height = hh+bh+fh;
		//if sum of all three is less than the window height
		//initialize sticky footer
		if(sum_height < wh){
			//since hh and fh are pretty much constant
			//adjust bh so that the footer sticks to the bottom
			min_height = wh - (hh+fh);
			$('#sm-body-wrap').css({'min-height':min_height});
		}else{
			$('#sm-body-wrap').css({'min-height':''});
		}
	}
	
	
	
	 
};

$(function(){
	help.go_to_top('.go-to-top');	
	help.make_x_editable_inline();
	help.sticky_footer();
	init_select();
});

$(window).resize(function(){
	help.make_x_editable_inline();
	help.sticky_footer();
});

$( document ).ajaxComplete(function() {
   init_select();
});
function updateTextboxCounter(field_name, id_element) {
	var w = ("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$_ !#%&()*+,-./:;<=>?\"\'");
   	var whash = {};
  	for (var i = 0; i < w.length; i++)
       whash[w.charAt(i)] = true;
    var unicodeFlag = 0;
    var extraChars = 0;
    var msgCount = 0;
    var msg = $('textarea[name="' +  field_name + '"]').val();
    var m = msg.length;
    for (var i = (m-1); (!unicodeFlag && (i > 0)); i--) 
	{
		if (whash[msg.charAt(i)]) {}
      	else if (msg.charCodeAt(i) == 0xA3) {}
      	else if (msg.charCodeAt(i) == 0xA5) {}
      	else if (msg.charCodeAt(i) == 0xE8) {}
      	else if (msg.charCodeAt(i) == 0xE9) {}
      	else if (msg.charCodeAt(i) == 0xF9) {}
      	else if (msg.charCodeAt(i) == 0xEC) {}
		else if (msg.charCodeAt(i) == 0xF2) {}
		else if (msg.charCodeAt(i) == 0xC7) {}  
		else if (msg.charAt(i) == '\r') {}  
		else if (msg.charAt(i) == '\n') {}  
		else if (msg.charCodeAt(i) == 0xD8) {}  
		else if (msg.charCodeAt(i) == 0xF8) {}  
		else if (msg.charCodeAt(i) == 0xC5) {}  
		else if (msg.charCodeAt(i) == 0xE5) {}  
		else if (msg.charCodeAt(i) == 0x394) {}  
		else if (msg.charCodeAt(i) == 0x3A6) {}  
		else if (msg.charCodeAt(i) == 0x393) {}  
		else if (msg.charCodeAt(i) == 0x39B) {}  
		else if (msg.charCodeAt(i) == 0x3A9) {}  
		else if (msg.charCodeAt(i) == 0x3A0) {}
		else if (msg.charCodeAt(i) == 0x3A8) {}  
		else if (msg.charCodeAt(i) == 0x3A3) {}  
		else if (msg.charCodeAt(i) == 0x398) {}  
		else if (msg.charCodeAt(i) == 0x39E) {}  
		else if (msg.charCodeAt(i) == 0xC6) {}  
		else if (msg.charCodeAt(i) == 0xE6) {}  
		else if (msg.charCodeAt(i) == 0xDF) {}  
		else if (msg.charCodeAt(i) == 0xC9) {}  
		else if (msg.charCodeAt(i) == 0xA4) {}  
		else if (msg.charCodeAt(i) == 0xA1) {} 
		else if (msg.charCodeAt(i) == 0xC4) {}  
		else if (msg.charCodeAt(i) == 0xD6) {}  
		else if (msg.charCodeAt(i) == 0xD1) {}  
		else if (msg.charCodeAt(i) == 0xDC) {}  
		else if (msg.charCodeAt(i) == 0xA7) {}  
		else if (msg.charCodeAt(i) == 0xBF) {}  
		else if (msg.charCodeAt(i) == 0xE4) {}  
		else if (msg.charCodeAt(i) == 0xF6) {}  
		else if (msg.charCodeAt(i) == 0xF1) {}  
		else if (msg.charCodeAt(i) == 0xFC) {}  
		else if (msg.charCodeAt(i) == 0xE0) {}  
		else if (msg.charCodeAt(i) == 0x391) {}  
		else if (msg.charCodeAt(i) == 0x392) {}  
		else if (msg.charCodeAt(i) == 0x395) {}  
		else if (msg.charCodeAt(i) == 0x396) {}  
		else if (msg.charCodeAt(i) == 0x397) {}  
		else if (msg.charCodeAt(i) == 0x399) {} 
		else if (msg.charCodeAt(i) == 0x39A) {}  
		else if (msg.charCodeAt(i) == 0x39C) {}  
		else if (msg.charCodeAt(i) == 0x39D) {}  
		else if (msg.charCodeAt(i) == 0x39F) {}  
		else if (msg.charCodeAt(i) == 0x3A1) {}  
		else if (msg.charCodeAt(i) == 0x3A4) {}
		else if (msg.charCodeAt(i) == 0x3A5) {}  
		else if (msg.charCodeAt(i) == 0x3A7) {}  
		else if (msg.charAt(i) == '^') {
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '{') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '}') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '\\') {  
		   extraChars++;  
		}
		else if (msg.charAt(i) == '[') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '~') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == ']') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '|') {  
		   extraChars++;  
		}  
		else if (msg.charCodeAt(i) == 0x20AC) {  
		   extraChars++;  
		}  
		else {  
		   unicodeFlag = 1;  
		}
   }

 
   
   //else {
      msgCount = m + extraChars;
      if (msgCount <= 160) {
         msgCount = 1;
      }
      else {
         //msgCount += (153-1);
         //msgCount -= (msgCount % 153);
         //msgCount /= 153;
		 msgCount = Math.ceil((msgCount / 160));
      }
      $('#' + id_element).html("<b>" + (m + extraChars) + "</b> characters, <b>" + msgCount + "</b> SMS message(s)");
   //}   
}