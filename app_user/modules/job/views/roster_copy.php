<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Copy Roster</h4>
        </div>
        <div class="col-md-12">
            <div class="modal-body">

                <div class="btn-group">
                    <a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
                    <span type="button" class="btn btn-info" id="modal-header-month"> &nbsp; </span>
                    <a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i></a>
                </div>
                <div id="calendar-copy" style="min-height:380px;"></div>

                <div class="has-error"><span class="help-block" id="error_day_selected"></span></div>


            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger btn-clear-days">Clear</button>
            <button type="button" class="btn btn-primary btn-copy-selected-days">Copy to selected dates</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
var selected_dates = new Array();

$(function(){
    load_copy_calendar();
    $('.btn-clear-days').click(function(){
        selected_dates.length = 0;
        $('#calendar-copy').find('.events-list').remove();
    });
    $('.btn-copy-selected-days').click(function(){
        preloading($('#calendar-copy'));
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>job/ajax/copy_selected_weeks",
            data: {job_id: <?=$job_id;?>, date: '<?=$date;?>', dates: selected_dates},
            success: function(data) {
                data = $.parseJSON(data);
                if (data.ok) {
                    load_job_shifts(<?=$job_id;?>, data.date);
                    $('#copy_shift').modal('hide');
                    //location.reload();
                }
                else
                {
                    loaded($('#calendar-copy'));
                    $('#error_day_selected').html(data.msg);
                    setTimeout(function(){
                        $('#error_day_selected').html('');
                    }, 1500);
                }
            }
        })
    })
});
function load_copy_calendar()
{
    var options = {
        events_source: function () { return []; },
        view: 'month',
        tmpl_path: "<?=base_url();?>assets/bootstrap-calendar/roster_copy/",
        tmpl_cache: false,
        day: '<?=$date;?>',
        first_day: 1,
        onAfterViewLoad: function(view) {
            $('#modal-header-month').text(this.getTitle());
        },
    };
    var calendar = $('#calendar-copy').calendar(options);
    $('.modal-dialog').find('a[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
            select_dates();
            update_date();
        });
    });
    update_date();
}
function select_dates() {
    for(var i =0; i < selected_dates.length; i++) {
        $('#calendar-copy').find('[data-cal-date=' + selected_dates[i] + ']').parent().append('<div class="events-list" data-cal-start="' + selected_dates[i] + '" data-cal-end="' + selected_dates[i] + '"><i class="fa fa-check fa-1x"></i></div>');
    }
}
function update_date() {
    $('.modal-dialog').find('*[data-cal-date]').parent().click(function() {
        $(this).parent().parent().find('[data-cal-date]').each(function(){
            clicked_date = $(this).data('cal-date');
            if ($.inArray(clicked_date, selected_dates) != -1) { // in array
                selected_dates.splice($.inArray(clicked_date, selected_dates),1);
                $(this).parent().find('.events-list').remove();
            } else { // not in array
                selected_dates.push(clicked_date);
                $(this).parent().append('<div class="events-list" data-cal-start="' + clicked_date + '" data-cal-end="' + clicked_date + '"><i class="fa fa-check fa-1x"></i></div>');
            }
        });
    });
}
</script>
