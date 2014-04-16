/**
time.js input, based on [Bootstrap datetimepicker](http://eonasdan.github.io/bootstrap-datetimepicker/).   


@class time
@extends abstractinput
@final
@example
<a href="#" id="time" data-type="time" data-pk="1" data-url="/post" data-value="11:00" data-title="Input time"></a>
<script>
$(function(){
    $('#time').editable({
    	url: '/post',
    	title: 'Enter time',
    	value: '11:00',
        time: {
            pickDate: false,
	        minuteStepping: 15,
        }
    });
});
</script>
**/
(function ($) {
    "use strict";
    
    var Constructor = function (options) {
        this.init('time', options, Constructor.defaults);
    };

    $.fn.editableutils.inherit(Constructor, $.fn.editabletypes.text);

    $.extend(Constructor.prototype, {
        render: function() {
        	//this.renderClear();
            //this.setClass();
            //this.setAttr('placeholder');
        	
        },
        activate: function() {
	        this.$input.datetimepicker(this.options.time);
        }
    });      

    Constructor.defaults = $.extend({}, $.fn.editabletypes.list.defaults, {
        tpl:'<input type="text" class="form-control" />',
        /**
        Configuration of datetimepicker itself. 
        [Full list of options](http://eonasdan.github.io/bootstrap-datetimepicker/#options).
        
        @property time 
        @type object
        @default null
        **/
        time: {
	        pickDate: false,
	        minuteStepping: 15,
	        format: "HH:mm"
        },
        /**
        Whether to show `clear` button 
        
        @property clear 
        @type boolean
        @default true        
        **/
        clear: true
    });

    $.fn.editabletypes.time = Constructor;   
    
}(window.jQuery));