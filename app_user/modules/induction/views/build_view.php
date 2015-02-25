
<div class="col-md-12">
    <div class="box top-box">
         <h2><i class="fa fa-dot-circle-o"></i> &nbsp; <?=$induction['name'];?> &raquo; Steps Building</h2>
         <p>Build an induction process new staff you create to go through when they first log into their account. Inductions you build can be assigned to staff at any stage by viewing their account details under the settings tab.</p>

         <a class="btn btn-info" href="<?=base_url();?>induction" ><i class="fa fa-arrow-left"></i> Back to Inductions List</a>
    </div>
</div>

<div class="col-md-12" ng-init="id = <?=$induction['id'];?>">
    <div class="box bottom-box" ng-controller="InductionBuildCtrl">
        <div class="inner-box">
            <ul class="nav nav-tabs tab-respond">
                <li class="active"><a>Build Induction</a></li>
                <li><a href="<?=base_url();?>induction/setting/<?=$induction['id'];?>">Settings</a></li>
                <li class="pull-right active"><a href="<?=base_url();?>induction/preview/<?=$induction['id'];?>" target="_blank">Preview</a></li>
            </ul>
            <br />
            <h2>Build Induction</h2>
            <p>Build an induction process for your staff to go through when they first or next log into their account.<br />Build your induction by adding steps, employees will be required to complete the first step before moving to the next step. When employees complete all the steps in the induction they will gain access to their staff account.</p><br />

            <form class="form-horizontal" role="form" id="form_add_step">
                <div class="row">
                    <div class="form-group">
                        <label for="company_state" class="col-md-2 control-label">Step Type </label>
                        <div class="col-md-5">
                            <select ng-model="step_type" class="form-control">
                                <option value="">Select Step Type</option>
                                <option value="content">Content (Video, Document, Image, Text)</option>
                                <optgroup label="Make Staff Update Their Profile">
                                    <option value="personal">Personal Details</option>
                                    <option value="financial">Financial Details</option>
                                    <option value="super">Super Details</option>
                                    <option value="picture">Pictures</option>
                                    <option value="role">Roles</option>
                                    <option value="availability">Availability</option>
                                    <option value="location">Locations</option>
                                    <option value="group">Groups</option>
                                    <option value="custom">Custom Attributes</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <a id="btn-add-step" class="btn btn-info" ng-click="addStep(step_type)"><i class="fa fa-plus"></i> Add Step</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div ng-if="steps.length == 0"><br /><br /><br /></div>

        <div data-as-sortable="dragControlListeners" data-ng-model="steps">
        <div class="inner-box box-step" data-ng-repeat="step in steps" id="step{{ step.id }}" data-as-sortable-item>
            <div class="row">
                <div class="col-md-2">
                    <div class="step_induction">
                        <div><div>{{ $index + 1 }}</div></div>
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="pull-right btn-group">
                        <button ng-if="current_step.id != step.id && (step.type == 'personal' || step.type == 'custom' || step.type == 'content')" ng-click="editStep($index)" type="button" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Edit</button>

                        <button ng-if="current_step.id != step.id" type="button" class="btn btn-sm btn-default" ng-click="deleteStep($index)"><i class="fa fa-times"></i> Delete</button>

                        <div data-as-sortable-item-handle ng-if="current_step.id != step.id" type="button" class="btn btn-sm btn-default"><i class="fa fa-arrows-v"></i> Change Order</div>

                        <button ng-if="current_step.id == step.id" ng-click="closeStep($index)" class="btn btn-sm btn-default"><i class="fa fa-check"></i> Done</button>
                    </div>

                    <div class="row">
                        <h4 ng-if="edit_title_step.id != step.id"><a ng-click="editTitle($index)">{{ step.title ? step.title : 'Click to add title' }}</a></h4>

                        <div ng-if="edit_title_step.id == step.id" class="col-md-8 remove-left-gutter">
                            <form ng-submit="updateStep($index)">
                            <input type="text" class="form-control" ng-model="step.title">
                            <input type="submit" class="hide" />
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <p ng-if="edit_description_step.id != step.id" ng-click="editDescription($index)">{{ step.description ? step.description : 'Click to add description' }}</p>

                        <div ng-if="edit_description_step.id == step.id">
                            <form ng-submit="updateStep($index)">
                            <input type="text" class="form-control" ng-model="step.description">
                            <input type="submit" class="hide" />
                            </form>
                        </div>
                    </div>


                    <div ng-if="step.id == current_step.id">
                        <div ng-if="step.type == 'personal' || step.type == 'custom'">
                            <div
                                multi-select
                                input-model="fields"
                                button-label="label"
                                item-label="label"
                                tick-property="ticked"
                                on-close="updateFields($index, fields)"
                            >
                            </div>
                        </div>

                        <div data-as-sortable="subDragControlListeners" data-ng-model="contents">
                        <div ng-if="step.type == 'content'" ng-repeat="content in contents" class="panel panel-default content_induction" data-as-sortable-item>

                            <div class="panel-heading">
                                <div class="pull-right btn-group">
                                    <button ng-click="editContent($index)" type="button" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></button>
                                    <button ng-click="deleteContent($index)" type="button" class="btn btn-xs btn-default"><i class="fa fa-times"></i></button>
                                    <div type="button" class="btn btn-xs btn-default"><i class="fa fa-arrows-v" data-as-sortable-item-handle></i></div>
                                </div>
                                {{ content.type | uppercase}}
                            </div>

                            <div class="panel-body">
                                <div ng-if="content.type == 'video'">
                                    <div ng-if="content.id == current_content.id">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                                            <input type="text" class="form-control" placeholder="Paste your Youtube embedded code here" ng-model="content.value" >
                                            <span class="input-group-btn">
                                                <button ng-click="updateContent($index)" class="btn btn-core btn-default" type="button">Embed <i class="fa fa-paperclip"></i></button>
                                            </span>
                                        </div>
                                        <br /><br />
                                    </div>
                                    <div ng-if="content.value" ng-bind-html="content.html"></div>
                                </div>

                                <div ng-if="content.type == 'image'">
                                    <div ng-if="content.id == current_content.id">
                                        <div
                                          class="btn btn-core btn-upload"
                                          upload-button
                                          param="image"
                                          url="<?=base_url();?>induction/ajax/upload_image/{{ content.id }}"
                                          on-success="onSuccess(response, $index)"
                                        >Upload</div>
                                        <br /><br />
                                    </div>

                                    <div ng-if="content.value"><img ng-src="<?=base_url() . UPLOADS_URL;?>/tmp/{{ content.value }}"></div>
                                </div>

                                <div ng-if="content.type == 'file'">
                                    <div ng-if="content.id == current_content.id">
                                        <div
                                          class="btn btn-core btn-upload"
                                          upload-button
                                          param="file"
                                          url="<?=base_url();?>induction/ajax/upload_file/{{ content.id }}"
                                          on-success="onSuccess(response, $index)"
                                        >Upload</div>
                                        <br /><br />
                                    </div>

                                    <div ng-if="content.value">
                                        <i class="fa fa-download"></i> Download File<br />
                                        <a href="<?=base_url() . UPLOADS_URL;?>/tmp/{{ content.value }}">{{ content.value }}</a>
                                    </div>
                                </div>

                                <div ng-if="content.type == 'text'">
                                    <div ng-if="content.id == current_content.id">
                                        <div text-angular ng-model="content.value" ta-text-editor-class="border-around" ta-html-editor-class="border-around"></div><br />
                                        <button class="btn btn-core" ng-click="updateContent($index)">Save</button>

                                    </div>
                                    <div ng-if="content.value && content.id != current_content.id" ng-bind-html="content.html"></div>
                                </div>

                                <div ng-if="content.type == 'compliance'">
                                    <div ng-if="content.id == current_content.id">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox">
                                            </span>
                                            <input type="text" class="form-control" ng-model="content.value" placeholder="Do you accept and agree ...">
                                            <span class="input-group-btn">
                                                <button ng-click="updateContent($index)" class="btn btn-core btn-default" type="button">Add <i class="fa fa-plus"></i></button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </div>
                                    <div ng-if="content.value && content.id != current_content.id">
                                        <p>{{ content.value }}</p>
                                        <div class="checkbox">
                                            <label><input type="checkbox"> Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="menu_induction" ng-if="step.type == 'content'">
                            <a class="fa-stack fa-lg" ng-click="addContent('video')">
                                <i class="fa fa-square fa-stack-2x text-primary"></i>
                                <i class="fa fa-video-camera fa-stack-1x fa-inverse"></i>
                            </a>

                            <a class="fa-stack fa-lg" ng-click="addContent('image')">
                                <i class="fa fa-square fa-stack-2x text-info"></i>
                                <i class="fa fa-image fa-stack-1x fa-inverse"></i>
                            </a>

                            <a class="fa-stack fa-lg" ng-click="addContent('file')">
                                <i class="fa fa-square fa-stack-2x text-warning"></i>
                                <i class="fa fa-file fa-stack-1x fa-inverse"></i>
                            </a>

                            <a class="fa-stack fa-lg" ng-click="addContent('text')">
                                <i class="fa fa-square fa-stack-2x text-danger"></i>
                                <i class="fa fa-font fa-stack-1x fa-inverse"></i>
                            </a>

                            <a class="fa-stack fa-lg" ng-click="addContent('compliance')">
                                <i class="fa fa-square fa-stack-2x text-success"></i>
                                <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                            </a>

                            <a href="#step{{ step.id }}" class="fa-stack fa-lg">
                                <i class="fa fa-square fa-stack-2x text-muted"></i>
                                <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
