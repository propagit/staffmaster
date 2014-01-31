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