<div id="survey-box-<?=$topic_id;?>" class="survey-wrap">
	<?php 
		//$count = 0;
		$color = "success";
		if($poll_results){
			//$total_answer_count
			foreach($poll_results as $pr){
			$percentage = 0;
			if($total_answer_count){
				$percentage = round(($pr->answer_count / $total_answer_count) * 100);
			}
			/* if($count <= 3){
				$count++;	
			}else{
				$count = 0;	
			}
			switch($count){
				case 1:$color = 'success';break;
				case 2:$color = 'info';break;
				case 3:$color = 'warning';break;
				case 4:$color = 'danger';break;	
			} */
	?>
    <div class="col-md-12 remove-gutters">
        <div class="col-md-3 poll-question remove-gutters">
             <div class="survey-result-stat"><?=$pr->answer;?> (<?=$percentage?>%)</div> 	
        </div>
        <div class="col-md-9 remove-gutters">
            <div class="progress survey-bar">
              <div class="progress-bar progress-bar-<?=$color;?>" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percentage?>%"></div>
            </div>
        </div>
    </div>
    <?php }}?>
</div>
