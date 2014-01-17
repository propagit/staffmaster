<div class="pull-right">
	<br />
	<p><span class="label label-default"><i class="icon-question"></i></span> &nbsp; Pending Jobs</p>
	<p><span class="label label-danger"><i class="icon-remove"></i></span> &nbsp;  Jobs Unconfirmed & Unfilled</p>
	<p><span class="label label-success"><i class="icon-ok"></i></span> &nbsp; Jobs Confirmed & Filled</p>
</div>
<h2>Job Calendar</h2>

<p>Manage and create jobs that will appear on the job calendar.</p>

<a href="<?=base_url();?>job/search"><i class="icon-search"></i> Search Jobs</a>
&nbsp; &nbsp; &nbsp;
<a href="<?=base_url();?>job/search"><i class="icon-plus-sign"></i> Create Job</a>
<br /><br />
<hr />
<br /><br />
<div style="text-align:center">
<select class="selectpicker" data-style="btn-info">
<option>Filter by client</option>
<option>Ketchup</option>
<option>Relish</option>
</select>
&nbsp;
<select class="selectpicker" data-style="btn-info">
<option>Filter by location</option>
<option>Ketchup</option>
<option>Relish</option>
</select>
</div>
<?=$calendar;?>