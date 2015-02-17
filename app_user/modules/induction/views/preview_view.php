
<div id="induction" class="col-md-12">
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
        <div class="row">
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
                    echo '<div class="checkbox"><label><input type="checkbox"> Yes</label></div>';
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
                    <input type="text" class="form-control" name="<?=$field->key;?>" />
                    <? } ?>
                </div>
            </div>
        <? }
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class=" pull-right">
                <? if (isset($current_step)) {
                    if ($step_number == count($steps)) { ?>
                    <a class="btn btn-core btn-respond">Complete</a>
                    <? } else { ?>
                    <a class="btn btn-default btn-respond">Save For Later <i class="fa fa-save"></i></a> &nbsp;
                    <a class="btn btn-core btn-respond" href="<?=base_url();?>induction/preview/<?=$induction['id'];?>/<?=$step_number;?>">Proceed To Next Step <i class="fa fa-chevron-right"></i></a>
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
