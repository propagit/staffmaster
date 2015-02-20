<div id="induction" class="col-md-12" ng-controller="InductionStaff">
    <div class="list-group list-step">
        <? if (count($steps) > 0) {
            $n = 1; foreach($steps as $step) { ?>

        <a href="<?=base_url();?>induction/preview/<?=$induction['id'];?>/<?=$n-1;?>" class="list-group-item<?=($step['id'] == $current_step['id']) ? ' current' : '';?>">
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
        </div>


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
                    <?=modules::run('common/field_select_title', 'title');?>
                    <? } else if ($field->key == 'gender') { ?>
                    <?=modules::run('common/field_select_genders', 'gender');?>
                    <? } else if ($field->key == 'dob') { ?>
                    <?=modules::run('common/field_dob', 'dob');?>
                    <? } else if ($field->key == 'state') { ?>
                    <?=modules::run('common/field_select_states', 'state');?>
                    <? } else if ($field->key == 'country') { ?>
                    <?=modules::run('common/field_select_countries', 'country');?>
                    <? } else if ($field->key == 'password') { ?>
                    <input type="password" class="form-control" name="password" />
                    <? } else { ?>
                        <? if (isset($field->type)) { ?>

                            <? if($field->type == 'text') { ?>
                            <input type="text" class="form-control" name="<?=$field->key;?>" />
                            <? } else if ($field->type == 'textarea') { ?>
                            <textarea class="form-control" name="<?=$field->key;?>"></textarea>
                            <? } else if ($field->type == 'file') { ?>

                            <div
                                  class="btn btn-core btn-upload"
                                  upload-button
                                  param="file-<?=$field->key;?>"
                                  url="#"
                                  on-success="onSuccess(response)"
                                >Upload</div>
                            <? } else if ($field->type == 'radio') { ?>
                            <?php
                                $attrs = json_decode($field->attributes);
                                if($attrs){
                                    foreach($attrs as $attr){ ?>
                                    <label class="<?=($field->inline == 'true' ? 'radio-inline' : 'radio' );?>">
                                        <input type="radio" name="<?=$field->key;?>" value="<?=$attr;?>" /> <?=$attr;?>
                                    </label>
                            <?php   }
                            } ?>

                            <? } else if ($field->type == 'checkbox') { ?>
                            <?php
                                $attrs = json_decode($field->attributes);
                                if($attrs){
                                    foreach($attrs as $attr){ ?>
                                    <label class="<?=($field->inline == 'true' ? 'checkbox-inline' : 'checkbox' );?>">
                                        <input type="checkbox" name="<?=$field->key;?>[]" value="<?=$attr;?>" /> <?=$attr;?>
                                    </label>
                            <?php   }
                            } ?>
                            <? } else if ($field->type == 'select') { ?>
                            <select name="<?=$field->key;?>" class="form-control" <?=($field->multiple == 'true' ? 'multiple="multiple"' : '');?>>
                                <? if ($field->multiple != "true") { ?>
                                <option value="">Select One</option>
                                <? }
                                $attrs = json_decode($field->attributes);
                                if($attrs) {
                                    foreach($attrs as $attr) { ?>
                                <option value="<?=$attr;?>"><?=$attr;?></option>
                                <? }
                                } ?>
                            </select>
                            <? } ?>


                        <? } else { ?>
                        <input type="text" class="form-control" name="<?=$field->key;?>" />
                        <? } ?>
                    <? } ?>
                </div>
            </div>
        <? }
        } ?>

        <? if ($current_step['type'] == 'financial') { ?>
            <div class="form-group induction-form-group">
                <label for="f_acc_name" class="col-md-4 control-label">Account Name</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="f_acc_name" name="f_acc_name" />
                </div>
            </div>
            <div class="form-group">
                <label for="f_bsb" class="col-md-4 control-label">BSB</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="f_bsb" name="f_bsb" onkeypress="return help.check_numeric(this, event,'n');" maxlength="6" />
                </div>
            </div>

            <div class="form-group">
                <label for="f_acc_number" class="col-md-4 control-label">Account Number</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="f_acc_number" name="f_acc_number" onkeypress="return help.check_numeric(this, event,'n');" maxlength="14" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Employed As</label>
                <div class="col-md-1">
                    <div class="radio">
                        <input type="radio" name="f_employed" ng-model="employed_as" value="1" /> TFN
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="radio">
                        <input type="radio" name="f_employed" ng-model="employed_as" value="2" /> ABN
                    </div>
                </div>
            </div>

            <div ng-show="employed_as == 1">

                <div class="form-group">
                    <label for="f_tfn" class="col-md-4 control-label">TFN Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="f_tfn" name="f_tfn" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Are you an Australian Resident?</label>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_aus_resident" value="1" /> Yes
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_aus_resident" value="0" /> No
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Do you want to claim the tax free threshold?</label>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_tax_free_threshold" value="1" /> Yes
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_tax_free_threshold" value="0" /> No
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Do you want to claim the Senior Australian Tax offset?</label>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_tax_offset" ng-model="tax_offset" value="1" /> Yes
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_tax_offset" ng-model="tax_offset" value="0" /> No
                        </div>
                    </div>
                </div>

                <div class="form-group" ng-show="tax_offset == 1">
                    <label class="col-lg-4 control-label">Your senior couple status <span class="required">**</span></label>
                    <div class="col-lg-3">
                        <?
                            $array = array(
                                array('value' => 'None', 'label' => 'None'),
                                array('value' => 'Member of couple', 'label' => 'Member of couple'),
                                array('value' => 'Member of illness-separated couple', 'label' => 'Member of illness-separated couple'),
                                array('value' => 'Single', 'label' => 'Single')
                            );
                            echo modules::run('common/field_select', $array, 'f_senior_status');
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-4 control-label">Do you have a HELP (higher education loan program) debt?</label>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_help_debt" ng-model="help_debt" value="1" /> Yes
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="radio">
                            <input type="radio" name="f_help_debt" ng-model="help_debt" value="0" /> No
                        </div>
                    </div>
                </div>

                <div class="form-group" ng-show="help_debt == 1">
                    <label class="col-lg-4 control-label">Your HELP variation <span class="required">**</span></label>
                    <div class="col-lg-3">
                        <?
                            $array = array(
                                array('value' => 'HELP', 'label' => 'HELP'),
                                array('value' => 'SFSS', 'label' => 'SFSS'),
                                array('value' => 'HELP + SFSS', 'label' => 'HELP + SFSS')
                            );
                            echo modules::run('common/field_select', $array, 'f_help_variation');
                        ?>
                    </div>
                </div>
            </div>

            <div ng-show="employed_as == 2">
                <div class="form-group">
                    <label for="f_abn" class="col-md-4 control-label">ABN Number</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="f_abn" name="f_abn" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="f_require_gst" class="col-md-4 control-label">Do you require GST?</label>
                    <div class="col-md-3">
                        <?
                            $array = array(
                                array('value' => '0', 'label' => 'No'),
                                array('value' => '1', 'label' => 'Yes')
                            );
                            echo modules::run('common/field_select', $array, 'f_require_gst');
                        ?>
                    </div>
                </div>
            </div>

        <? } ?>

        <? if ($current_step['type'] == 'super') { ?>
            <div class="form-group">
                <label class="col-md-4 control-label">Super Fund</label>
                <div class="col-md-4">
                    <?=modules::run('common/field_select_myob_super_fund', 's_external_id');?>
                </div>
            </div>
            <div class="form-group induction-form-group">
                <div class="col-md-offset-4 col-md-8">
                    <span class="help-block">If you cant find your super fund in the list please contact us</span>
                </div>
            </div>
            <div class="form-group">
                <label for="s_employee_id" class="col-md-4 control-label">Staff Membership Number</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="s_employee_id" name="s_employee_id" />
                </div>
            </div>
        <? } ?>

        <? if ($current_step['type'] == 'picture') { ?>
            <div class="row"><div class="col-md-12"><div
              class="btn btn-core btn-upload"
              upload-button
              param="image"
              url="#"
              on-success="onSuccess(response)"
            >Upload</div></div></div>
        <? } ?>

        <? if ($current_step['type'] == 'role') { ?>
        <div class="row">
        <? foreach($roles as $role) { ?>
            <div class="col-md-4">
            <div class="checkbox checkbox_role">
                <label>
                    <input type="checkbox" name="roles[]" value="<?=$role['role_id'];?>" /> <?=$role['name'];?>
                </label>
            </div>
            </div>
            <? } ?>
        </div>
        <? } ?>

        <? if ($current_step['type'] == 'group') { ?>
        <div class="row">
        <? foreach($groups as $group) { ?>
            <div class="col-md-4">
            <div class="checkbox checkbox_role">
                <label>
                    <input type="checkbox" name="groups[]" value="<?=$group['group_id'];?>" /> <?=$group['name'];?>
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
                    <button class="btn btn-core btn-respond">Complete</button>
                    <? } else { ?>
                    <a class="btn btn-default btn-respond">Save For Later <i class="fa fa-save"></i></a> &nbsp;
                    <a class="btn btn-core btn-respond" href="<?=base_url();?>induction/preview/<?=$induction['id'];?>/<?=$step_number++;?>">Proceed To Next Step <i class="fa fa-chevron-right"></i></a>
                    <? }
                } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="clearfix"></div>
<br />
