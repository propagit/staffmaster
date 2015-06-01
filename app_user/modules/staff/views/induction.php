<table cellpadding="5">
<? foreach($inductions as $induction) { ?>
<tr>
    <td width="200"><?=$induction['name'];?></td>
    <td>
        <? if($induction['finished_on']) { ?>
            <?=date('H:i jS M Y', strtotime($induction['finished_on']));?>
        <? } else { ?>
        Not completed
        <? } ?>
    </td>
    <td width="20"></td>
    <td><a onclick="delete_induction(<?=$induction['id'];?>)"><i class="fa fa-times"></i></a></td>
</tr>
<? } ?>
</table>

<? if(count($more_inductions) > 0) { ?>
<br />
<div class="row"><div class="col" style="width:200px">
<select name="induction_id" class="form-control" id="induction_id">
    <? foreach($more_inductions as $induction) { ?>
    <option value="<?=$induction['id'];?>"><?=$induction['name'];?></option>
    <? } ?>
</select></div>
<div class="col">
<a class="btn btn-core" id="btn-add-induction">Add</a>
</div>
</div>
<? } ?>

<script>
$(function(){
    init_select();
    $('#btn-add-induction').click(function(){
        var induction_id = $('#induction_id').val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>staff/ajax/add_induction",
            data: {user_id: <?=$user_id;?>, induction_id: induction_id},
            success: function(html) {
                get_induction(<?=$user_id;?>);
            }
        })
    })
})
function delete_induction(id) {
    $.ajax({
        type: "POST",
        url: "<?=base_url();?>staff/ajax/delete_induction/" + id,
        success: function(html) {
            get_induction(<?=$user_id;?>);
        }
    })
}
</script>
