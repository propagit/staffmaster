<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h4 class="modal-title" id="myModalLabel">Send Candidates</h4>
        </div>
        <div class="col-md-12">
            <div class="modal-body modal-form">
                <div class="col-md-7">
                    <h4>Search Staff</h4>
                    <p>Find staff to fill this shift<br />&nbsp;</p>
                    <?=modules::run('job/shift/search_candidate_form', $shift_ids);?>
                </div>
                <div class="col-md-5">
                    <h4>Most Suitable Staff</h4>
                    <p>Based on your staff profiles, below staffs are best suited to fill this shift.</p>
                    <div id="shift-search-staff-results">
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<script>
$(function(){
})
function shift_search_candidates() {
    preloading($('#shift-search-staff-results'));
    $.ajax({
        type: "POST",
        url: "<?=base_url();?>job/ajax_shift/search_candidates",
        data: $('#form_search_staffs').serialize(),
        success: function(html) {
            loaded($('#shift-search-staff-results'), html);
        }
    })
}
</script>
