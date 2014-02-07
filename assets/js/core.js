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
			$('#'+form_id).submit();	
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
			$(window).scrollTop() ? $(selector).removeClass('hidden')  : $(selector).addClass('hidden');
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

	}
	
	
	
	
};