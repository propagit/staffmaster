<div class="col-md-12">
    <div class="box top-box">
         <h2><i class="fa fa-dot-circle-o"></i> &nbsp; <?=$induction['name'];?> &raquo; Settings</h2>
         <p>Build an induction process new staff you create to go through when they first log into their account. Inductions you build can be assigned to staff at any stage by viewing their account details under the settings tab.</p>

         <a class="btn btn-info" href="<?=base_url();?>induction" ><i class="fa fa-arrow-left"></i> Back to Inductions List</a>
    </div>
</div>

<div class="col-md-12">
    <div class="box bottom-box">
        <div class="inner-box">
            <ul class="nav nav-tabs tab-respond">
                <li><a href="<?=base_url();?>induction/build/<?=$induction['id'];?>">Build Induction</a></li>
                <li class="active"><a>Induction Settings</a></li>
                <li class="pull-right active"><a>Preview</a></li>
            </ul>

            <br />
            <h2>Induction Settings</h2>
            <p>Your induction can be set to automatically initiate base on the settings you put in below.</p>
        </div>
    </div>
</div>
