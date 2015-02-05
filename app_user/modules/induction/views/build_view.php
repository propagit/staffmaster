<div class="col-md-12">
    <div class="box top-box">
         <h2><i class="fa fa-dot-circle-o"></i> &nbsp; <?=$induction['name'];?> &raquo; Steps Building</h2>
         <p>Build an induction process new staff you create to go through when they first log into their account. Inductions you build can be assigned to staff at any stage by viewing their account details under the settings tab.</p>

         <a class="btn btn-info" href="<?=base_url();?>induction" ><i class="fa fa-arrow-left"></i> Back to Inductions List</a>
    </div>
</div>

<div class="col-md-12">
    <div class="box bottom-box">
        <div class="inner-box">
            <ul class="nav nav-tabs tab-respond">
                <li class="active"><a>Build Induction</a></li>
                <li><a href="<?=base_url();?>induction/setting/<?=$induction['id'];?>">Induction Settings</a></li>
                <li class="pull-right active"><a>Preview</a></li>
            </ul>

            <br />
            <h2>Create Step</h2>
            <p>Your induction is built with steps that you would like the employee to perform when they login to their account the first time. At the end of completing a step the employee will be asked to proceed to the next step.</p><br />

            <form class="form-horizontal" role="form" id="form_add_step">
                <div class="row">
                    <div class="form-group">
                        <label for="company_state" class="col-md-2 control-label">Step Type </label>
                        <div class="col-md-5">
                            <select id="step_type" class="form-control">
                                <option value="">Select Step Type</option>
                                <option value="profile">Make Staff Update Their Profile</option>
                                <option value="content">Content</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <a id="btn-add-step" class="btn btn-info"><i class="fa fa-plus"></i> Add Step</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="induction_steps"></div>
    </div>
</div>

<script>
$(function(){
    get_steps(<?=$induction['id'];?>);
    $('#btn-add-step').click(function(){
        var type = $('#step_type').val();
        if (type == '') {
            $('#step_type').parent().addClass('has-error');
            return;
        }
        var title = $("#step_type option:selected").text();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>induction/ajax/add_step",
            data: { induction_id: <?=$induction['id'];?>, type: type, title: title },
            success: function(html) {
                // reload steps
                get_steps(<?=$induction['id'];?>);
            }
        })
    });
})

function get_steps(induction_id) {
    preloading($('#induction_steps'));
    $.ajax({
        type: "GET",
        url: "<?=base_url();?>induction/ajax/get_steps/" + induction_id,
        success: function(html) {
            loaded($('#induction_steps'), html);
        }
    })
}
function delete_step(id) {
    $.ajax({
        type: "GET",
        url: "<?=base_url();?>induction/ajax/delete_step/" + id,
        success: function(html) {
            get_steps(<?=$induction['id'];?>);
        }
    })
}
</script>
