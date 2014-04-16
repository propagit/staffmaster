<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Department <i class="fa fa-sort sort-table" sort-by="name" sort-order="desc"></i></a></th>
        <th class="center col-md-1">Edit</th>
        <th class="center col-md-1">Delete</th>
    </tr>
    </thead>
    <tbody>
    <? foreach($departments as $department) { ?>
    <tr>
    	<td class="left"><?=$department['name'];?></td>
    	<td class="center"><a data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>client/ajax/edit_department/<?=$department['department_id'];?>"><i class="fa fa-pencil"></i></a></td>
    	<td></td>
    </tr>
    <? } ?>
    </tbody>
</table>