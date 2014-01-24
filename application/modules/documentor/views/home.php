
<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="<?=base_url();?>">Project Home</a> &nbsp;&#8250;&nbsp;
<a href="<?=base_url();?>documentor/show_documentation">User Guide Home</a> &nbsp;&#8250;&nbsp;
<?=ucwords($mvc->name);?>
</td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<div id="content">
    <h1><?=ucwords($mvc->name);?></h1>
    <p><?=$mvc->description;?></p>
    <p class="important"><?=$mvc->comment;?></p>
    
    <h3>Functions:</h3>
    <?php
		$all_functions = $this->documentor_model->get_functions($mvc->id);
	?>
    <ul>
    	<?php
			if($all_functions){
				foreach($all_functions as $func){
					echo '<li><a href="#'.trim($func->name).'">'.$func->name.'</a></li>';
				}
			}
		?>
    </ul>

	<?php 
		$main_body = '';
        if($all_functions){
            foreach($all_functions as $functions){
				$h2 = '';
				$h3 = '';
				$p = '';
				$param = '';
				$func_attr = '';
				$attr_table = '';
				$func_code = '';
				$func_comments = '';
				if(isset($functions->params)){
					$param = '<var>'.$functions->params.'</var>';	
				} 

				$h2 = '<h2 id="'.trim($functions->name).'"><dfn>'.$functions->access.'</dfn> '.$functions->name.'('.$param.')</h2>';
				$p = '<p>'.$functions->description.'</p>';
				if(isset($functions->comment)){
					if($functions->comment){
						$func_comments = '<p class="important">'.$functions->comment.'</p>';
					}
				} 
				if(isset($functions->attributes)){
					$function_attr = json_decode($functions->attributes);
				
					foreach($function_attr as $attr){	
						$func_attr .= '<tr>
										  <td class="td">'.$attr->attr_name.'</td>
										  <td class="td">'.$attr->attr_desc.'</td>
									   </tr>';	
					}
					$attr_table = '<h3>Attributes</h3>
									<p><table cellpadding="0" cellspacing="1" border="0" style="width:100%;" class="tableborder">
									<tr>
										<th>Name</th>
										<th>Description</th>
									</tr>
									'.$func_attr.'
									</table></p>';
					
				}
				$func_code = '<pre>'.$functions->code.'</pre>';
				$main_body .= $h2.$p.$func_comments.$attr_table.$func_code;
            }
        }
		echo $main_body;
    ?>
</div>