<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Documentation</title>
<link rel='stylesheet' type='text/css' media='all' href="<?=base_url();?>assets/css/documentation.css" />

<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta name='robots' content='all' />

</head>
<body>

<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"></div></div>
<div id="nav2"><a name="top">&nbsp;</a></div>
<div id="masthead">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td><h1>Project Title</h1></td>
<td id="breadcrumb_right"><a href="#">Right Breadcrumb</a></td>
</tr>
</table>
</div>
<!-- END NAVIGATION -->


<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td id="breadcrumb">
<a href="http://example.com/">Project Home</a> &nbsp;&#8250;&nbsp;
<a href="#">User Guide Home</a> &nbsp;&#8250;&nbsp;
<?=$documents['class_info']['class_name'];?>
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="example.com/user_guide/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<?php
	

?>

<div id="content">
    <h1><?=$documents['class_info']['class_name'];?></h1>
    <p><?=$documents['class_info']['class_desc'];?></p>
    <p class="important"><?=$documents['class_info']['class_comments'];?></p>
    
    <h3>Functions:</h3>
    
   
    

	<?php 
		$function_lists = '';
		$main_body = '';
        if($documents['functions']){
            foreach($documents['functions'] as $functions){
				$h2 = '';
				$h3 = '';
				$p = '';
				$param = '';
				$func_attr = '';
				$attr_table = '';
				$func_code = '';
				$func_comments = '';
				if(isset($functions['function_param'])){
					$param = '<var>'.$functions['function_param'].'</var>';	
				} 
                $function_lists .= '<li><a href="#'.trim($functions['function_name']).'">'.$functions['function_name'].'</a></li>';
				$h2 = '<h2 id="'.trim($functions['function_name']).'"><dfn>'.$functions['function_access'].'</dfn> '.$functions['function_name'].'('.$param.')</h2>';
				$p = '<p>'.$functions['function_desc'].'</p>';
				if(isset($functions['function_comments'])){
					if($functions['function_comments']){
						$func_comments = '<p class="important">'.$functions['function_comments'].'</p>';
					}
				} 
				if(isset($functions['function_attr'])){
					foreach($functions['function_attr'] as $attr){	
						$func_attr .= '<tr>
										  <td class="td">'.$attr['attr_name'].'</td>
										  <td class="td">'.$attr['attr_desc'].'</td>
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
				$func_code = '<pre>'.$functions['function_code'].'</pre>';
				$main_body .= $h2.$p.$func_comments.$attr_table.$func_code;
            }
        }
    ?>
    
    <ul><?=$function_lists;?></ul>

	<?=$main_body;?>
</div>
<div id="footer">

</div>

</body>
</html>