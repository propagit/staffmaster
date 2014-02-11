<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
        <tr>
            <th class="left">Role <i class="fa fa-sort" onclick="sort_list('name');"></i></th>
            <th class="center col-md-2">Staff Assigned To Role <i class="fa fa-sort"></i></th>
            <th class="center col-md-1">Edit Role</th>
            <th class="center col-md-1">Delete Role</th>
        </tr>
    </thead>
    <tbody>
    <? foreach($roles as $role) { ?>
    <tr>
        <td class="left"><?=$role['name'];?></td>
        <td class="center"><?=$this->role_model->get_role_frequency($role['role_id']);?></td>
        <td class="center"><a href="javascript:open_edit_modal(<?=$role['role_id'];?>,'<?=$role['name'];?>')"><i class="fa fa-pencil"></i></a></td>
        <td class="center"><a href="javascript:confirm_delete(<?=$role['role_id'];?>)"><i class="fa fa-times"></i></a></td>
        
    </tr>
    <? } ?>
    </tbody>
</table>
