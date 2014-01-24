<?php
	$modules = $this->documentor_model->get_all_modules();
	$total_modules = count($modules);
	$total_mvc_components = $this->documentor_model->get_total_mvc();
	$total_records = ($total_modules * 3) + $total_mvc_components;
	$buffer = ($total_records % 4 == 0 ? 0 : 1);
	$records_per_col = intval($total_records/4) + $buffer;
	$out = '<td class="td" valign="top">';
	$count = 0;
	foreach($modules as $m){
			$out .= '<h3 class="module-title">'.ucwords($m->name).'</h3>';
			$count++;
			if($count > $records_per_col){
				//start new col
				$count = 0;	
				$out .= '</td>
						 <td class="td_sep" valign="top">';	
			}
			
			//get controllers and modesl
			$controllers = $this->documentor_model->get_modules_mvc($m->id,'controllers');
			$models = $this->documentor_model->get_modules_mvc($m->id,'models');
			
			//for controllers
			if($controllers){
				  $out .= '<h3><em>&nbsp;&nbsp;&nbsp; - Controllers</em></h3>';
				  $count++;
				  $out .= '<ul>';
				  foreach($controllers as $con){
						  if($count > $records_per_col){
							 //start new col
							  $count = 0;
							  $out .= '</ul>
									   </td>
									   <td class="td_sep" valign="top">
									   <ul>'; 
						   }
							  $out .= '<li><a href="'.base_url().'documentor/show_documentation/'.$con->id.'">'.ucwords($con->name).'</a></li>';
							  $count++;
						  
				  }
				  $out .= '</ul>';
			}
			
			//for models
			if($models){
				  $out .= '<h3><em>&nbsp;&nbsp;&nbsp; - Models</em></h3>';
				  $count++;
				  $out .= '<ul>';
				  foreach($models as $mdl){
						  if($count > $records_per_col){
							 //start new col
							  $count = 0;
							  $out .= '</ul>
									   </td>
									   <td class="td_sep" valign="top">
									   <ul>'; 
						   }
							  $out .= '<li><a href="'.base_url().'documentor/show_documentation/'.$mdl->id.'">'.ucwords($mdl->name).'</a></li>';
							  $count++;
						  
				  }
				  $out .= '</ul>';
			}
		
	}
	$out .= '</td>';
?>
<script>
function toggle_meuu(){
	$('#nav').toggle();	
}
</script>
<!-- START NAVIGATION -->
<div id="nav">
<div id="nav_inner">

<table cellpadding="0" cellspaceing="0" border="0" style="width:98%">
    <tbody>
        <tr>
            <?=$out;?>
        </tr>
    </tbody>
</table>
</div>
</div>
<div id="nav2"><a name="top"></a><a href="javascript:void(0);" onclick="toggle_meuu();"><img src="<?=base_url();?>assets/documentation/img/nav_toggle_darker.jpg" width="154" height="43" border="0" title="Toggle Table of Contents" alt="Toggle Table of Contents"></a></div>
<!-- END NAVIGATION -->
