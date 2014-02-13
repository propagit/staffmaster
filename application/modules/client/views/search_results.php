<br />
<? if (isset($clients)) { ?>

<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr>
        <th>Company Name </td>
        <th class="center" width="18%"><i class="icon-map-marker"></i> Jobs <a href="#"><i class="icon-sort-by-alphabet"></i></a></th>
        <th class="center" width="18%"><i class="icon-location-arrow"></i> Jobs This Year <a href="#"><i class="icon-sort-by-alphabet"></i></a></th>
        <th class="center" width="12%"><i class="icon-time"></i> Status</th>
        <th class="center" width="12%"><i class="icon-eye-open"></i> View</th>
        <th class="center" width="12%"><i class="icon-trash"></i> Delete</th>
    </tr>
    </thead>
    <? foreach($clients as $client) { ?>
    <tr>
        <td><?=$client['company_name'];?></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"><a href="<?=base_url();?>client/edit/<?=$client['user_id'];?>"><i class="fa fa-eye"></i></a></td>
        <td class="center"><a><i class="fa fa-trash-o"></i></a></td>
        
    </tr>
    <? } ?>
</table>

<? } ?>