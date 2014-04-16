<script type="text/javascript" src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinyMCE.init({
    selector: "textarea",
});
</script>


<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/page">Contents Management</a> <span class="divider">/</span></li>
	<li class="active">Edit Page</li>
</ul>
<? if (isset($updated)) { ?>
<div class="alert alert-success">
	You have updated content successfully!
</div>
<? } ?>
<div class="box">
<form method="post" action="<?=base_url();?>admin/page/edit/<?=$page['page_id'];?>">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="page_title">Page Title</label>
			<div class="controls">
				<input type="text" id="page_title" name="title" value="<?=$page['title'];?>" disabled />
			</div>
		</div>
		<div class="control-group textarea">
			<label class="control-label" for="page_content">Page Content</label>
			<div class="controls">
				<textarea rows="10" id="page_content" name="content"><?=$page['content'];?></textarea>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Update Page</button>
			</div>
		</div>
	</div>
</form>
</div>