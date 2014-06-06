<form id="send-sms-form">
<input type="hidden" name="selected_user_ids" value="<?=implode(',', $selected_user_ids);?>" />
<input type="hidden" name="selected_shift_ids" value="<?=($selected_module_ids) ? implode(',', $selected_module_ids) : '';?>" />
<textarea class="form-control" rows="4" name="msg" onkeyup="updateTextboxCounter();" onkeydown="updateTextboxCounter();" onkeypress="updateTextboxCounter();">
Dear {FirstName}. Can you work as a {Role} at {Time}, on {Date} at {Venue}. Reply Y {code} for yes or N {code} for no. {CompanyName}
</textarea><br />
<p class="step-desc" id="message-desc">Note: 1 SMS message = 160 characters (Current number of characters: <span id="currentChars"><b>0</b> character, <b>0</b> SMS message</span>)</p>
<button type="button" class="btn btn-core" id="btn-send-sms"><i class="fa fa-mobile-phone"></i> Send SMS</button>
&nbsp;&nbsp;
(Selected Recipients: <b id="total-selected-receiver"><?=count($selected_user_ids);?></b>)
&nbsp;&nbsp;
<a href="#" id="view-sms-receiver-list"><i class="fa fa-eye"> </i> View Send List</a>
<div class="alert alert-success add-top-margin-20 hide" id="msg-sms-sent-successfully"><i class="fa fa-check"></i> &nbsp; SMS Successfully Sent</div>
</form>
<div id="sms-receiver-list" class="email-modal-receiver-list"></div>
<script>
$(function(){
	$('#btn-send-sms').click(function(){
		setTimeout(function(){
			$('#msg-sms-sent-successfully').removeClass('hide');
		}, 200);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/ajax/sendsms",
			data: $('#send-sms-form').serialize(),
			success: function(html) {
			}
		})
	});
	updateTextboxCounter();
	$('#view-sms-receiver-list').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/ajax/list_receivers",
			data: {user_ids: '<?=implode(',', $selected_user_ids);?>'},
			success: function(html) {
				$('#sms-receiver-list').html(html);
			}
		})
	})
})
function updateTextboxCounter() {
	var w = ("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$_ !#%&()*+,-./:;<=>?\"\'");
   	var whash = {};
  	for (var i = 0; i < w.length; i++)
       whash[w.charAt(i)] = true;
    var unicodeFlag = 0;
    var extraChars = 0;
    var msgCount = 0;
    var msg = $('textarea[name="msg"]').val();
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

 
   /*
   if (unicodeFlag) 
   {
      msgCount = m;
      if (msgCount <= 70) {
         msgCount = 1;
      }
      else {
         msgCount += (67-1);
         msgCount -= (msgCount % 67);
         msgCount /= 67;
      }

      document.getElementById("currentChars").innerHTML = "<b>" + (m) + "</b> unicode character(s), <b>" + msgCount + "</b> SMS message(s)";
   }
   */
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
      $("#currentChars").html("<b>" + (m + extraChars) + "</b> characters, <b>" + msgCount + "</b> SMS message(s)");
   //}   
}
</script>