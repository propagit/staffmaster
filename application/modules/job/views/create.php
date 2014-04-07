<div class="col-md-12">
	<div class="box top-box">
        <h2>Create Jobs</h2>
        <p>To start creating jobs select a client and a campaign name. A campaign name is used for you to find the shifts you create later. A job campaign can contain many shifts across many days, weeks or months.</p>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Create Job - Step 1</h2>
            <p>Choose a client and enter a campaign name to start creating jobs. Client departments can be set up when you create clients, 
a client will be able to filter jobs associated to them by the client department when they login to their client account.</p>
        
            <form class="form-horizontal" role="form" method="post" action="<?=base_url();?>job/create">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group<?=form_error('name')? ' has-error' : '';?>">
                            <label for="name" class="col-lg-2 control-label">Campaign Name</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?=set_value('name');?>" />
                            </div>
                            <div class="col-lg-6"><span class="help-block">Enter a unique campaign name that you will be able to search for later</span></div>
                        </div>
                        <? if (!modules::run('auth/is_client')) { ?>
                        <div class="form-group<?=form_error('client_id')? ' has-error' : '';?>">
                            <label for="client_id" class="col-lg-2 control-label">Client</label>
                            <div class="col-lg-4">
                                <?=modules::run('client/field_select', 'client_id', set_value('client_id'));?>
                            </div>
                            <div class="col-lg-4">
                            	<span class="help-block"><a><i class="fa fa-plus"></i></a> &nbsp; <a href="#">Create New Client</a></span>
                            </div>
                        </div>
                        <? } ?>
                    </div>            
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-lg-offset-4 col-lg-8">
                                <button type="submit" class="btn btn-core"><i class="fa fa-plus"></i> Create Job</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--inner box-->
	</div><!--box-->
</div>




