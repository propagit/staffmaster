<div class="col-md-12">
	<div class="wp-page-invoice full-width push">
    	<h1 class="brief-viewer-header" id="brief-viewer-header">Job Brief</h1>
        
        <?php if($briefs || $shift_info->information_sheet){ ?>
        
        <div class="col-md-6 brief-list remove-gutters">
            <table id="brief-list-table" class="table table-bordered table-hover table-middle table-expanded">
                <thead>
                    <tr>
                        <th class="left">Title</th>
                        <th class="center" width="80">View</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
					if($shift_info->information_sheet)
					{
					$first_brief = 'info_sheet';
				?>
                	<tr class="brief-tr active-brief view-information-sheet" data-shift-id="<?=$shift_info->shift_id;?>" >
                        <td class="left">Information Sheet</td>
                        <td class="center"><i class="fa fa-eye"></i></td>
                    </tr>
                <?php } ?>
                <?php
					$first_brief = $brief_id;
					if(isset($briefs) && $briefs){
						if(!$first_brief){
							$first_brief = $briefs[0]->brief_id;
						}
						foreach($briefs as $brief){
				?>
                    <tr class="brief-tr <?=($brief->brief_id == $first_brief ? 'active-brief' : '');?> view-brief" data-brief-id="<?=$brief->brief_id;?>" id="brief-tr-<?=$brief->brief_id;?>">
                        <td class="left"><?=$brief->name;?></td>
                        <td class="center"><i class="fa fa-eye"></i></td>
                    </tr>
                 <?php
						}
					}
				 ?>
                </tbody>
            </table>
        </div>
        
        <hr class="full-width push" />
        <?php 
		} else{
			echo '<h4>No brief attached to this shift.</h4>';	
		}?>
        <div id="ajax-brief-preview" class="push full-width"></div>
    </div>
</div>
<?php
	if(isset($shift_info)){ 
		$header = str_replace(array("\r", "\r\n", "\n", ","), '-', $shift_info->campaign_name).' - '.str_replace(array("\r", "\r\n", "\n", ","), '-', $shift_info->venue_name).' - '.date('l dS F Y',strtotime($shift_info->job_date));
	}else{
		$header = $brief_name;	
	}
?>
<script>
$(function(){
	<?php
		if($shift_info->information_sheet){
	?>
	//load information sheet
	load_information_sheet(<?=$shift_info->shift_id?>);
	<?php
		}else{
	?>
	//load the first brief
	load_brief(<?=$first_brief?>);
	<?php
		}
	?>
	
	//load view when view brief button is clicked
	$('.view-brief').on('click',function(){
		load_brief($(this).attr('data-brief-id'));
	});
	
	//load information sheet when view button is clicked
	$('.view-information-sheet').on('click',function(){
		load_information_sheet($(this).attr('data-shift-id'));
	});
	
	//update header
	$('#brief-shift-info').html('<?=$header;?>');
	
});//ready


function load_brief(brief_id)
{
	preloading($('#ajax-brief-preview'));
	$.ajax({
	type: "POST",
	url: "<?=base_url();?>brief/ajax/load_brief_for_brief_viewer",
	data: {brief_id:brief_id},
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#ajax-brief-preview').html(html);
			$('.view-information-sheet').removeClass('active-brief');
			$('.brief-tr').removeClass('active-brief');
			$('#brief-tr-'+brief_id).addClass('active-brief');
			
			//scroll to brief
			var scroll_height = $('#brief-viewer-header').height()+$('#brief-list-table').height()+200;
			$('html, body').animate({ scrollTop:scroll_height},300);
		}
	});
}

function load_information_sheet(shift_id)
{
	preloading($('#ajax-brief-preview'));
	$.ajax({
	type: "POST",
	url: "<?=base_url();?>brief/ajax/load_information_sheet_for_brief_viewer",
	data: {shift_id:shift_id},
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#ajax-brief-preview').html(html);
			$('.brief-tr').removeClass('active-brief');
			$('.view-information-sheet').addClass('active-brief');
			//scroll to brief
			var scroll_height = $('#brief-viewer-header').height()+$('#brief-list-table').height()+200;
			$('html, body').animate({ scrollTop:scroll_height},300);
		}
	});
}
</script>