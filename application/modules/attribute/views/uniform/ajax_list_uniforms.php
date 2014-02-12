<? foreach($uniforms as $uniform) { ?>
<tr>
    <td class="left"><?=$uniform['name'];?></td>
    <td class="center"><a href="javascript:edit_uniform(<?=$uniform['uniform_id'];?>, '<?=$uniform['name'];?>')"><i class="fa fa-pencil"></i></a></td>
    <td class="center"><a href="javascript:delete_uniform(<?=$uniform['uniform_id'];?>)"><i class="fa fa-times"></i></a></td>
</tr>
<? } ?>