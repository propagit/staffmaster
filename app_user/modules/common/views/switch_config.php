<div class="btn-group" id="key-<?=$key;?>">
    <? if($this->config_model->get($key)) { ?>
    <button type="button" class="btn btn-success btn-sm">On</button>
    <button type="button" class="btn btn-default btn-sm" onclick="switch_config('<?=$key;?>', '')">Off</button>
    <? } else { ?>
    <button type="button" class="btn btn-default btn-sm" onclick="switch_config('<?=$key;?>', '1')">On</button>
    <button type="button" class="btn btn-danger btn-sm">Off</button>
    <? } ?>
</div>
