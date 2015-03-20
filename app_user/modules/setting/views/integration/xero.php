
<div class="alert alert-success">
    Your Xero Account is connected successfully!
</div>
</p><br />

<div id="platform-data" class="table-responsive">
    <table class="table table-bordered table-hover table-middle" width="100%">
    <thead>
        <tr>
            <th>Data Type</th>
            <th class="center">Auto Add</th>
            <th class="center">Auto Update</th>
            <th class="center" colspan="2">StaffBooks</th>
            <th class="center" colspan="2"><?=ucwords($accounting_platform = $this->config_model->get('accounting_platform'));?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Staff / Employee</td>
            <td class="center">
                <label>
                    <input type="checkbox" id="auto-add-staff" <?=($this->config_model->get('auto_add_staff')) ? 'checked' : '';?>>
                </label>
            </td>
            <td class="center">
                <label>
                    <input type="checkbox" id="auto-update-staff" <?=($this->config_model->get('auto_update_staff')) ? 'checked' : '';?>>
                </label>
            </td>
            <td class="center">
                <span class="badge success"><?=modules::run('staff/get_total_staff', STAFF_ACTIVE);?></span>
            </td>
            <td class="center">
                <a class="btn btn-core" id="btn-push-xero">
                    <i class="fa fa-arrow-up"></i> Push to Xero
                </a>
            </td>
            <td class="center">
                <span class="badge primary"><?=modules::run('api/xero/total_employees');?></span>
            </td>
            <td class="center">
                <a class="btn btn-core" id="btn-pull-staffbooks">
                    <i class="fa fa-arrow-down"></i> Pull to StaffBooks
                </a>
            </td>
        </tr>
    </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="order-message">
            <img src="<?=base_url();?>assets/img/loading3.gif" />
            <h2>Please wait!</h2>
            <p>Please wait a moment while we are processing your request ...</p>
        </div>
    </div>
</div>
<script>
$(function(){
    $('#btn-pull-staffbooks').click(function(){
        $('#waitingModal').modal('show');
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>setting/ajax/pull_xero_employees_to_staffbooks",
            success: function(html) {
                $('#order-message').html(html);
            }
        })
    });

    $('#btn-push-xero').click(function(){
        $('#waitingModal').modal('show');
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>setting/ajax/push_xero_employees",
            success: function(html) {

            }
        })
    })

    $('#auto-add-staff').click(function(){
        var auto = '';
        if ($(this).is(':checked')) {
            auto = 1;
        }
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>config/ajax/add",
            data: {auto_add_staff: auto},
            success: function(html) {}
        })
    })
    $('#auto-update-staff').click(function(){
        var auto = '';
        if ($(this).is(':checked')) {
            auto = 1;
        }
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>config/ajax/add",
            data: {auto_update_staff: auto},
            success: function(html) {}
        })
    })
})
</script>
