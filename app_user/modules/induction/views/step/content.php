<div class="inner-box box-step">
    <div clas="row">
        <div class="col-md-2">
            <div class="step_induction">
                <div><div><?=$number;?></div></div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="pull-right alert alert-default">
                <a href="#"><i class="fa fa-pencil"></i> Edit</a>
            <a onclick="delete_step(<?=$step['id'];?>)"><i class="fa fa-times"></i> Delete</a>
            <a href="#"><i class="fa fa-arrows-v"></i> Change Order</a>
            </div>



            <h4><?=$step['title'];?></h4>

                <a class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x text-primary"></i>
                    <i class="fa fa-video-camera fa-stack-1x fa-inverse"></i>
                </a>

                <a class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-info"></i>
                    <i class="fa fa-image fa-stack-1x fa-inverse"></i>
                </a>

                <a class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                    <i class="fa fa-font fa-stack-1x fa-inverse"></i>
                </a>

                <a class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                    <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                </a>

        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="pull-right step-menu">
            </div>
        </div>
        <div class="col-md-10">
        </div>
    </div>
</div>
