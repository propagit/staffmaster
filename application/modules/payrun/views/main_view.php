<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Pay Run</h2>
		<p>As time sheets are approved they appear below. Time sheets are batched together by the staff member in preparation for creating the pay run.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond">
				<li><a href="<?=base_url();?>timesheet">Time Sheets</a></li>
				<li class="active"><a>Pay Run</a></li>
			</ul>
			<br />
			<h2>Batched Time Sheets</h2>
			<p>The below time sheets have been approved. Add time sheets to the pay run by clicking. Revert a time sheet for editing by clicking.</p>
			
			<div id="nav_payruns">
				<div class="btn-group btn-nav">
					<button type="button" class="btn btn-core">Action</button>
					<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a>Edit name</a></li>
						<li><a>Duplicate</a></li>
						<li><a>Delete</a></li>
					</ul>
				</div>
				<div class="btn-group btn-nav">
					<button type="button" class="btn btn-core">Filter by Location</button>
					<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a>Edit name</a></li>
						<li><a>Duplicate</a></li>
						<li><a>Delete</a></li>
					</ul>
				</div>
				<div class="btn-group btn-nav">
					<button type="button" class="btn btn-core">Filter by Status</button>
					<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a>Edit name</a></li>
						<li><a>Duplicate</a></li>
						<li><a>Delete</a></li>
					</ul>
				</div>
				<div class="btn-group btn-nav">
					<button type="button" class="btn btn-core">Filter by TFN</button>
					<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a>Edit name</a></li>
						<li><a>Duplicate</a></li>
						<li><a>Delete</a></li>
					</ul>
				</div>
			</div>
			<div id="list_payruns"></div>
		</div>
	</div>
</div>

<script>
$(function() {
	list_payruns();
})

function list_payruns() {
	preloading($('#list_payruns'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/list_payruns",
		success: function(html) {
			loaded($('#list_payruns'), html);
		}
	})
}
</script>