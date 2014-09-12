<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-exportTemplates"></i> &nbsp; Export Templates</h2>
		 <p>Create and save your export so that you can transport data easily into other systems.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <ul class="nav nav-tabs tab-respond" id="nav-export-types">
                <li class="active mobile-tab"><a href="#payrun_tfn" data-toggle="tab">Pay Run TFN</a></li>
                <li class="mobile-tab"><a href="#payrun_abn" data-toggle="tab">Pay Run ABN</a></li>
                <li class="mobile-tab"><a href="#invoice" data-toggle="tab">Client Invoice Export</a></li>
                <li class="mobile-tab"><a href="#expense" data-toggle="tab">Staff Expenses</a></li>
                <li class="mobile-tab"><a href="#staff" data-toggle="tab">Staff Data Export</a></li> 
                <li class="mobile-tab"><a href="#client" data-toggle="tab">Client Data Export</a></li>                             
			</ul>
			
			
			<div class="tab-content tab-export">
                <div class="tab-pane active" id="payrun_tfn"></div>			
				<div class="tab-pane" id="payrun_abn"></div>
				<div class="tab-pane" id="invoice"></div>
				<div class="tab-pane" id="expense"></div>
				<div class="tab-pane" id="staff"></div>
				<div class="tab-pane" id="client"></div>
				
			</div>
			
			<div class="clearfix"></div>
    	</div>
	</div>
</div>

<script>
function show_tab(tab)
{
	tab.load('<?=base_url();?>export/ajax/load_object/' + tab.attr('id'));
}
function init_tabs() {
	show_tab($('.tab-pane.active'));
	$('#nav-export-types a').on('shown.bs.tab', function(e) {
		tab = $('#' + $(e.target).attr('href').substr(1));
		show_tab(tab);	
	});
}

$(function(){
	init_tabs();	
});
</script>
