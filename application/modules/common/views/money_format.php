<?php
	echo '$'.$amount[0];
	if($subscript_cents){
		echo '<sub class="amount-cents-subscript">.'.$amount[1].'</sub>';
	}else{
		echo $amount[1];	
	}
?>