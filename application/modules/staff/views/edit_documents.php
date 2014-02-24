<div class="staff-profile-detail-box">
	<h2> Documents </h2>
	<p> Staff can choose the "Documents" </p>
</div>

<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?=base_url();?>staff/upload_custom_document">
<input type="hidden" name="user_staff_id" value="<?=$staff['user_id'];?>" />
	<?=modules::run('staff/custom_file_uploads_for_staff_profile',$staff['user_id']);?>
<form>
