
<div id="induction" class="col-md-12" ng-controller="InductionStaff">
    <div class="list-group list-step">
        <? if (count($steps) > 0) {
            $n = 1; foreach($steps as $step) { ?>

        <a href="<?=base_url();?>induction/publish/<?=$induction['id'];?>/<?=$n-1;?>" class="list-group-item<?=($step['id'] == $current_step['id']) ? ' current' : '';?><?=($user_induction['status'] > $n - 1) ? ' done' : '';?>">
            <div class="step-number">
                <div><?=$n++;?></div>
            </div>
            <div class="step-title"><span><?=$step['title'];?></span></div>
        </a>
        <? }
        } ?>
    </div>
    <div class="step-connect"></div>
    <div class="step-content">
    <form method="post" action="<?=current_url();?>" />
        <input type="hidden" name="user_id" value="<?=$user_induction['user_id'];?>" />
        <div class="row induction-row">
            <div class="col-md-12">
                <div class="logo-wrap">
                    <?=modules::run('setting/company_logo',true); # gets full image and not the reized image?>
                </div>
                <h2 class="induction-title"><?=$induction['name'];?></h2>
                <p>Please proceed through each step of the induction process</p>
                <hr />
                <? if (isset($current_step)) { ?>
                <div class="row">
                    <div class="col">
                        <div class="step-number">
                            <div><?=++$step_number;?></div>
                        </div>
                    </div>
                    <h3><?=$current_step['title'];?></h3>
                    <p><?=$current_step['description'];?></p>
                </div>
                <hr />
                <? } ?>
            </div>
        </div><div class="clearfix"></div>

        <?php if(validation_errors()) { ?>
        <div class="col-md-12">
        <div class="alert alert-danger"><?=validation_errors();?></div>
        </div>
        <? } ?>

        <? if (isset($contents) && count($contents) > 0) {
            foreach($contents as $content) {
            echo '<div class="row"><div class="col-md-12"><div class="sec">';
            switch($content['type']) {
                case 'video':
                case 'text': echo $content['value'];
                    break;
                case 'image': echo '<img src="' . base_url() . UPLOADS_URL . '/tmp/' . $content['value'] . '">';
                    break;
                case 'file': echo '<i class="fa fa-download"></i> Download File<br />';
                    echo '<a href="' . base_url() . UPLOADS_URL . '/tmp/' . $content['value'] . '">' . $content['value'] . '</a>';
                    break;
                case 'compliance': echo $content['value'];
                    $checked = (in_array($content['id'], $user_contents)) ? ' checked' : '';
                    echo '<div class="checkbox"><label><input type="checkbox" name="contents[' . $content['id'] . ']" value="' . $content['id'] . '" ' . $checked . '> Yes</label></div>';
                    break;
            }
            echo '</div></div></div>';
            }
        } ?>

        <? if(isset($fields)) {
            foreach($fields as $field) { ?>
            <div class="form-group induction-form-group">
                <label class="col-md-3 control-label"><?=$field->label;?></label>
                <div class="col-md-9">
                    <? if($field->key == 'title') { ?>
                    <?=modules::run('common/field_select_title', 'title',
                        (set_value($field->key) ? set_value($field->key) : $field->value)
                        );?>
                    <? } else if ($field->key == 'gender') { ?>
                    <?=modules::run('common/field_select_genders', 'gender',
                        (set_value($field->key) ? set_value($field->key) : $field->value)
                        );?>
                    <? } else if ($field->key == 'dob') { ?>
                    <?=modules::run('common/field_dob', 'dob',
                        (set_value('dob[day]') ? set_value('dob[day]') : date('d', strtotime($field->value))),
                        (set_value('dob[month]') ? set_value('dob[month]') : date('m', strtotime($field->value))),
                        (set_value('dob[year]') ? set_value('dob[year]') : date('Y', strtotime($field->value)))
                        );?>
                    <? } else if ($field->key == 'state') { ?>
                    <?=modules::run('common/field_select_states', 'state',
                        (set_value($field->key) ? set_value($field->key) : $field->value)
                        );?>
                    <? } else if ($field->key == 'country') { ?>
                    <?=modules::run('common/field_select_countries', 'country',
                        (set_value($field->key) ? set_value($field->key) : $field->value)
                        );?>
                    <? } else if ($field->key == 'password') { ?>
                    <input type="password" class="form-control" name="password" />
                    <? } else { ?>
                    <input type="text" class="form-control" name="<?=$field->key;?>" value="<?=(set_value($field->key) ? set_value($field->key) : $field->value);?>" />
                    <? } ?>
                </div>
            </div>
        <? }
        } ?>

        <? if ($current_step['type'] == 'picture') { ?>
        <? if (isset($pictures)) foreach($pictures as $picture) {
            $thumb_src = base_url() . UPLOADS_URL.'/staff/' . $user_induction['user_id'] . '/thumb/' . $picture['name'];
            ?>
            <div><img style="width:auto!important; height:216px;" src="<?=$thumb_src;?>" /></div><br />
        <? } ?>
        <div
              class="btn btn-core btn-upload"
              upload-button
              param="image"
              url="<?=base_url();?>induction/ajax/upload_staff_picture/<?=$user_induction['user_id'];?>"
              on-success="onSuccess(response)"
            >Upload</div>
        <? } ?>

        <? if ($current_step['type'] == 'role') { ?>
        <div class="row">
        <? foreach($roles as $role) {
            $checked = (modules::run('staff/check_staff_has_role',$user_induction['user_id'],$role['role_id'])) ? ' checked' : '';
            ?>
            <div class="col-md-4">
            <div class="checkbox checkbox_role">
                <label>
                    <input type="checkbox" name="roles[]" value="<?=$role['role_id'];?>" <?=$checked;?> /> <?=$role['name'];?>
                </label>
            </div>
            </div>
            <? } ?>
        </div>
        <? } ?>

        <? if ($current_step['type'] == 'group') { ?>
        <div class="row">
        <? foreach($groups as $group) {
            $checked = (modules::run('staff/check_staff_has_group',$user_induction['user_id'],$group['group_id'])) ? ' checked' : '';
            ?>
            <div class="col-md-4">
            <div class="checkbox checkbox_role">
                <label>
                    <input type="checkbox" name="groups[]" value="<?=$group['group_id'];?>" <?=$checked;?> /> <?=$group['name'];?>
                </label>
            </div>
            </div>
            <? } ?>
        </div>
        <? } ?>

        <? if ($current_step['type'] == 'availability') { ?>
        <div class="row">
        <? foreach($days as $day_no => $day_label) { ?>
            <div class="col-md-12">
            <div class="checkbox checkbox_role">
                <label>
                    <input type="checkbox" name="days[]" value="<?=$day_no;?>" /> <?=$day_label;?>
                </label>
            </div>
            </div>
            <? } ?>
        </div>
        <? } ?>

        <? if ($current_step['type'] == 'location') { ?>
        <div class="row">
            <div class="col-md-12">
                <?=modules::run('attribute/location/field_input', 'location');?>
            </div>
        </div>
        <? } ?>

        <div class="row">
            <div class="col-md-12">
                <div class=" pull-right"><br />
                <? if (isset($current_step)) {
                    if ($step_number == count($steps)) { ?>
                    <button class="btn btn-core btn-respond" type="submit">Complete</button>
                    <? } else { ?>
                    <a class="btn btn-default btn-respond">Save For Later <i class="fa fa-save"></i></a> &nbsp;
                    <button class="btn btn-core btn-respond" type="submit">Proceed To Next Step <i class="fa fa-chevron-right"></i></button>
                    <? }
                } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </form>
    </div>
</div>

<div class="clearfix"></div>
<br />
