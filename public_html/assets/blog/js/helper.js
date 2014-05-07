// JavaScript Document
/* * 
	Helper Script 
	v 1.0

*/

var help = {
	
	validate_email:function(emailAddress){
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	
		return pattern.test(emailAddress);
	},
	
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
	
	
	//set height of an element to the max height
	//eg find elements with same class name and set height to the max height
	unify_height:function(selector){
		$(selector).css({'min-height':0});
		var maxHeight = 0;
		$(selector)
		  .each(function() { maxHeight = Math.max(maxHeight, $(this).height()); })
		  .css({'min-height':maxHeight});	
	},
	
	
	//custom checkbox
	custom_checkbox:function(selector){
		$(selector).click(function(){
			 $(this).children('span').toggleClass('checked');  
			 if($(this).is(':checked')){
				$(this).attr('checked', false); 
			 }else{
				$(this).attr('checked', true);
			 }
	  	});	
		
	},
	
	//create permalink
	make_permalink:function(main_text_selector,permalink_selector){
		$(main_text_selector).keyup(function(){
			var main_text = $(main_text_selector).val();
			if(main_text){
				$(permalink_selector).val(help.format_to_link(main_text));	
			}else{
				$(permalink_selector).val('');
			}
		});
	},

	//permalink generator
	format_to_link:function(text){
		text = text.toLowerCase();
		var   spec_chars = {a:/\u00e1/g,e:/u00e9/g,i:/\u00ed/g,o:/\u00f3/g,u:/\u00fa/g,n:/\u00f1/g}
		for (var i in spec_chars) text = text.replace(spec_chars[i],i);
		var hyphens = text.replace(/\s/g,'-');
		var permalink = hyphens.replace(/[^a-zA-Z0-9\-]/g,'');
		permalink = permalink.toLowerCase();
		return permalink;
	},
	
	permalink_exists:function(controller_url,permalink,permalink_input){
		$.ajax({
			type:'post',
			url:controller_url,
			data:{permalink:permalink},
			success:function(html){
				if(html == 'exists'){
					$(permalink_input).addClass('error');	
				}else{
					$(permalink_input).removeClass('error');
				}
			},
			error:function(){
				alert('Something went wrong! Please try again!!!');
			}
		});//ajax		
	}
	

};



