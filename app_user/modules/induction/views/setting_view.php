<div class="col-md-12">
    <div class="box top-box">
         <h2><i class="fa fa-dot-circle-o"></i> &nbsp; <?=$induction['name'];?> &raquo; Settings</h2>
         <p>Build an induction process new staff you create to go through when they first log into their account. Inductions you build can be assigned to staff at any stage by viewing their account details under the settings tab.</p>

         <a class="btn btn-info" href="<?=base_url();?>induction" ><i class="fa fa-arrow-left"></i> Back to Inductions List</a>
    </div>
</div>

<div class="col-md-12" ng-init="id = <?=$induction['id'];?>">
    <div class="box bottom-box" ng-controller="InductionSetting">
        <div class="inner-box">
            <ul class="nav nav-tabs tab-respond">
                <li><a href="<?=base_url();?>induction/build/<?=$induction['id'];?>">Build Induction</a></li>
                <li class="active"><a>Induction Settings</a></li>
                <li class="pull-right active"><a href="<?=base_url();?>induction/preview/<?=$induction['id'];?>" target="_blank">Preview</a></li>
            </ul>

            <br />
            <h2>Induction Settings</h2>
            <p>Your induction can be set to automatically initiate base on the settings you put in below.</p><br />

            <form class="form-horizontal" role="form" id="form_induction_setting">
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">Induction Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="name" ng-model="induction.name" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-checked="induction.status == 1" ng-true-value="'1'" ng-false-value="'0'" ng-model="induction.status"> Actived</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Target Staff</label>
                    <div class="col-md-6">
                        <label class="radio-inline">
                            <input type="radio" name="target_all" value="1" ng-model="induction.target_all"> All Staff
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="target_all" value="0" ng-model="induction.target_all"> Only new staff
                        </label>
                    </div>
                </div>
                <hr /><!--
                <h2>Staff Target Filter</h2> -->

                <div class="form-group">
                    <label class="col-md-2 control-label">Filtered by State</label>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="state_filter" value="1"> Enable</label>
                        </div>
                    </div>
                    <div class="col-md-8" ng-show="state_filter">
                        <div
                            multi-select
                            input-model="states"
                            button-label="code"
                            item-label="code name"
                            tick-property="ticked"
                        >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Group</label>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="group_filter" value="1"> Enable</label>
                        </div>
                    </div>
                    <div class="col-md-8" ng-show="group_filter">
                        <div
                            multi-select
                            input-model="groups"
                            button-label="name"
                            item-label="name"
                            tick-property="ticked"
                        >
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Role</label>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="role_filter" value="1"> Enable</label>
                        </div>
                    </div>
                    <div class="col-md-8" ng-show="role_filter">
                        <div
                            multi-select
                            input-model="roles"
                            button-label="name"
                            item-label="name"
                            tick-property="ticked"
                        >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Age</label>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="age_filter" value="1"> Enable</label>
                        </div>
                    </div>
                    <div class="col-md-8" ng-show="age_filter">
                        <div
                            multi-select
                            input-model="ages"
                            button-label="name"
                            item-label="name"
                            tick-property="ticked"
                        >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Gender</label>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox" ng-model="gender_filter" value="1"> Enable</label>
                        </div>
                    </div>
                    <div class="col-md-2" ng-show="gender_filter">
                        <label class="radio-inline">
                            <input type="radio" value="<?=GENDER_MALE;?>" ng-model="induction.gender"> Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="<?=GENDER_FEMALE;?>" ng-model="induction.gender"> Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date_from" class="col-md-2 control-label">Worked From</label>
                    <div class="col-md-4">
                        <div class="input-group date" id="date_from">
                            <input type="text" class="form-control" ng-model="induction.work_from" name="date_from" readonly />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <label for="date_to" class="col-md-2 control-label">Worked To</label>
                    <div class="col-md-4">
                        <div class="input-group date" id="date_to">
                            <input type="text" class="form-control" ng-model="induction.work_to" name="date_to" readonly />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <div class="alert alert-success" ng-show="updated"><i class="fa fa-check"></i> &nbsp; Induction settings has been updated successfully!</div>

                        <button ng-click="update(induction)" id="btn-update-induction-setting" class="btn btn-core"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>

$(function(){
    $('#date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
        var date_from = moment(e.date.valueOf() - 11*60*60*1000);
        $('#date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
        var date_to = moment(e.date.valueOf() - 11*60*60*1000);
        $('#date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
});
</script>
