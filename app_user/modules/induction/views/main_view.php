<div class="col-md-12">
    <div class="box top-box">
         <h2><i class="fa fa-dot-circle-o"></i> &nbsp; Manage Inductions</h2>
         <p>Build an induction process new staff you create to go through when they first log into their account. Inductions you build can be assigned to staff at any stage by viewing their account details under the settings tab.</p>

         <button class="btn btn-info" data-toggle="modal" href="#addForm" ><i class="fa fa-plus"></i> Create New Induction</button>
    </div>
</div>

<? if (count($inductions) > 0) { ?>
<div class="col-md-12">
    <div class="box bottom-box">
        <div class="inner-box table-responsive">
            <table class="table table-bordered table-hover table-middle">
            <thead>
                <tr class="heading">
                    <th class="left">Induction Name</th>
                    <th class="center col-md-1">Edit</th>
                    <th class="center col-md-1">Settings</th>
                    <th class="center col-md-1">View</th>
                    <th class="center col-md-1">Delete</th>
                </tr>
            </thead>
            <tbody>
            <? foreach($inductions as $induction) { ?>
                <tr id="form_<?=$induction['id'];?>">
                    <td class="left"><?=$induction['name'];?></td>
                    <td class="center"><a href="<?=base_url();?>induction/build/<?=$induction['id'];?>"><i class="fa fa-pencil"></i></a></td>
                    <td class="center"><a href="<?=base_url();?>induction/setting/<?=$induction['id'];?>"><i class="fa fa-gear"></i></a></td>
                    <td class="center"><a href="<?=base_url();?>induction/preview/<?=$induction['id'];?>" target="_blank"><i class="fa fa-eye"></i></a></td>
                    <td class="center"><a><i class="fa fa-trash-o"></i></a></td>
                </tr>
            <? } ?>
            </tbody>
            </table>
        </div>
    </div>
</div>
<? } ?>

<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Create New Induction</h4>
            </div>
            <form id="form-add-form">
            <div class="col-md-12">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" placeholder="Enter induction name">
                        </div>
                    </div>
                    <div class="form-group">
                         <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                          <button id="btn-add-form" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Create Induction</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
$(function(){
    $('#btn-add-form').click(function(){
        $('#form-add-form').find('.form-group').removeClass('has-error');
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>induction/ajax/add",
            data: $('#form-add-form').serialize(),
            success: function(data) {
                data = $.parseJSON(data);
                if (!data.ok) {
                    $('#form-add-form').find('.form-group').addClass('has-error');
                } else {
                    window.location = '<?=base_url();?>induction/build/' + data.id;
                }
            }
        })
    })
});
</script>
