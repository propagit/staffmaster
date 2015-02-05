<div class="inner-box box-step">
    <div clas="row">
        <div class="col-md-2">
            <div class="step_induction">
                <div><div><?=$number;?></div></div>
            </div>
        </div>
        <div class="col-md-10">
            <h4><?=$step['title'];?></h4>
            <a href="#"><i class="fa fa-pencil"></i> Edit</a>
            <a onclick="delete_step(<?=$step['id'];?>)"><i class="fa fa-times"></i> Delete</a>
            <a href="#"><i class="fa fa-arrows-v"></i> Change Order</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
        </div>
    </div>
</div>
