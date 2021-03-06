<form class="form-horizontal" id="form_search_staffs" role="form">
<input type="hidden" name="shift_ids" value="<?=$shift_ids;?>" />
    <div class="row">
        <div class="form-group">
            <label for="staff_name" class="col-md-2 control-label">Name:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="staff_name" name="keyword" placeholder="Enter staff name" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-lg-2 control-label">Role</label>
            <div class="col-lg-10">
                <?=modules::run('attribute/role/field_select', 'role_id');?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-lg-2 control-label">Location</label>
            <div class="col-lg-10">
                <?=modules::run('attribute/location/field_select', 'location_parent_id');?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-lg-2 control-label">Rating</label>
            <div class="col-lg-4">
                <?=modules::run('common/field_rating', 'rating', 0,'basic-search-form','wp-rating-0','no-user',false,false);?>
            </div>

            <label class="col-lg-2 control-label">Gender</label>
            <div class="col-lg-4">
                <?=modules::run('common/field_select_genders', 'gender');?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="col-lg-2 control-label">Available</label>
            <div class="col-lg-3">
                <div class="radio"><input type="radio" name="is_available" value="1" checked /> Only Show</div>
            </div>
            <div class="col-lg-4">
                <div class="radio"><input type="radio" name="is_available" value="0" /> Show All Staff</div>
            </div>
        </div>
    </div>

    <div id="custom-attr-search" class="custom-hidden">
        <?=modules::run('staff/custom_fields');?>
    </div>

    <div class="row">
        <div class="form-group">
            <div class="col-lg-3 col-lg-offset-2">
                <button type="button" class="btn btn-core" id="btn-shift-search-staffs"><i class="fa fa-search"></i> Search</button>
            </div>
            <div class="col-lg-4 help-block">
                <a class="toggle-custom-attrs"><i id="toggle-custom-attrs-fa" class="fa fa-plus-square"></i> <b>More Options</b></a>
            </div>
        </div>
    </div>


</form>
<script>
$(function() {
    $('#btn-shift-search-staffs').click(function(){
        shift_search_candidates();
    });

    //toggle custom attr search
    $('.toggle-custom-attrs').on('click',function(){
        $('#custom-attr-search').toggle();
        if($('#toggle-custom-attrs-fa').hasClass('fa-plus-square')){
            $('#toggle-custom-attrs-fa').removeClass('fa-plus-square').addClass('fa-minus-square');
        }else{
            $('#toggle-custom-attrs-fa').removeClass('fa-minus-square').addClass('fa-plus-square');
        }
    });

})
</script>
