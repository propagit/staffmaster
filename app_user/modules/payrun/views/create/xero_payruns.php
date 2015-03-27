<?=modules::run('common/field_select_xero_payruns', 'xero_payrun_id');?>


<script>
$(function(){
    init_select();


    $('#xero_payrun_id').change(function(){
        preloading($('#payrun-period'));
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>payrun/ajax/populate_xero_payrun_period",
            data: {id: id},
            success: function(payrun) {
                var data = $.parseJSON(payrun);
                $('input[name="date_from"]').val(data.start_date);
                $('input[name="date_to"]').val(data.end_date);
                $('input[name="payable_date"]').val(data.payment_date);
                loaded($('#payrun-period'));
            }
        })
    });
})
</script>
