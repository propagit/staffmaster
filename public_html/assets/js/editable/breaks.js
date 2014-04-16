/**
Breaks editable input.
Internally value stored as 'a:2:{s:6:"length";i:900;s:8:"start_at";i:1390186800;}'

@class breaks
@extends abstractinput
@final
@example
<a href="#" id="breaks" data-type="breaks" data-pk="1">awesome</a>
<script>
$(function(){
    $('#breaks').editable({
        url: '/post',
        title: 'Enter breaks length and start time',
        value: [
        	{length: 900, start_at: '9:30'},
        	{length: 900, start_at: '12:00'} 
        ]
    });
});
</script>
**/
(function ($) {
    "use strict";
    
    var Breaks = function (options) {
        this.init('breaks', options, Breaks.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(Breaks, $.fn.editabletypes.abstractinput);

    $.extend(Breaks.prototype, {
        /**
        Renders input from tpl

        @method render() 
        **/        
        render: function() {
           this.$input = this.$tpl.find('input');
           this.$tpl.find('.editable-add').click(function(){
           })
        },
        /**
        Default method to show value in element. Can be overwritten by display option.
        
        @method value2html(value, element) 
        **/
        value2html: function(value, element) {
            if(!value) {
                $(element).empty();
                return; 
            }
            var html = $('<div>').text(value.city).html() + ', ' + $('<div>').text(value.street).html() + ' st., bld. ' + $('<div>').text(value.building).html();
            $(element).html(html); 
        },
        
        /**
        Gets value from element's html
        
        @method html2value(html) 
        **/        
        html2value: function(html) {        
          /*
            you may write parsing method to get value by element's html
            e.g. "Moscow, st. Lenina, bld. 15" => {city: "Moscow", street: "Lenina", building: "15"}
            but for complex structures it's not recommended.
            Better set value directly via javascript, e.g. 
            editable({
                value: {
                    city: "Moscow", 
                    street: "Lenina", 
                    building: "15"
                }
            });
          */ 
          return null;  
        },
      
       /**
        Converts value to string. 
        It is used in internal comparing (not for sending to server).
        
        @method value2str(value)  
       **/
       value2str: function(value) {
           var str = '';
           if(value) {
               for(var k in value) {
                   str = str + k + ':' + value[k] + ';';  
               }
           }
           return str;
       }, 
       
       /*
        Converts string to value. Used for reading value from 'data-value' attribute.
        
        @method str2value(str)  
       */
       str2value: function(str) {
           /*
           this is mainly for parsing value defined in data-value attribute. 
           If you will always set value by javascript, no need to overwrite it
           */
           return str;
       },                
       
       /**
        Sets value of input.
        
        @method value2input(value) 
        @param {mixed} value
       **/         
       value2input: function(value) {
           if(!value) {
             return;
           }
           this.$input.filter('[name="city"]').val(value.city);
           this.$input.filter('[name="street"]').val(value.street);
           this.$input.filter('[name="building"]').val(value.building);
       },       
       
       /**
        Returns value of input.
        
        @method input2value() 
       **/          
       input2value: function() { 
           return {
              city: this.$input.filter('[name="city"]').val(), 
              street: this.$input.filter('[name="street"]').val(), 
              building: this.$input.filter('[name="building"]').val()
           };
       },        
       
        /**
        Activates input: sets focus on the first field.
        
        @method activate() 
       **/        
       activate: function() {
       		
       },  
       
       /**
        Attaches handler to submit form in case of 'showbuttons=false' mode
        
        @method autosubmit() 
       **/       
       autosubmit: function() {
           this.$input.keydown(function (e) {
                if (e.which === 13) {
                    $(this).closest('form').submit();
                }
           });
       }       
    });

    Breaks.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-breaks">' +
        		'<div class="break_length">' +
        			'<div class="input-group">' + 
        				'<input type="text" class="form-control input_number_only" name="break_length" value="0" maxlength="3" />' + 
        				'<span class="input-group-addon">min(s)</span>' + 
        			'</div>' + 
        		'</div>' + 
        		'<div class="break_start_at">' + 	
        			'<div class="input-group break_start_at">' +
        				'<input type="text" class="form-control" name="break_start_at" data-format="HH:mm" />' + 
        				'<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>' + 
        			'</div>' + 
        		'</div>' +         		
        	'</div>'  + 
        	'<div class="editable-breaks">' +
        		'<div class="break_length">' +
        			'<div class="input-group">' + 
        				'<input type="text" class="form-control input_number_only" name="break_length" value="0" maxlength="3" />' + 
        				'<span class="input-group-addon">min(s)</span>' + 
        			'</div>' + 
        		'</div>' + 
        		'<div class="break_start_at">' + 	
        			'<div class="input-group break_start_at">' +
        				'<input type="text" class="form-control" name="break_start_at" data-format="HH:mm" />' + 
        				'<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>' + 
        			'</div>' + 
        		'</div>' +         		
        	'</div>'  + 
        	'<div class="break_add">' +
    			'<button type="button" class="btn btn-success btn-sm editable-add">' +
					'<i class="glyphicon glyphicon-plus"></i> Add break' +
				'</button>' + 
    		'</div>',
             
        inputclass: ''
    });
      

    $.fn.editabletypes.breaks = Breaks;

}(window.jQuery));