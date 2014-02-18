<div class="avatar pull">
	<?php
		$user_data = $this->session->userdata('user_data');
	?>
    <div id="profile-bar-avatar">
		<?=modules::run('common/profile_picture','',$user_data['user_id']);?>
    </div>
</div>
<ul>
    <li><a title="Dashboard" href=""><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li><li class="li-seprator">|</li>
    <li><a title="Logout" href="<?=base_url();?>logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
    <li><a title="Message" href=""><i class="fa fa-comments"></i> <span>Message</span></a></li><li class="li-seprator">|</li>
    <? if ($this->session->userdata('force_staff')) { ?>
    <li><a title="Staff Account" href="<?=base_url();?>account/admin"><i class="fa fa-user"></i> <span>Admin Account</span></a></li>
    <? } else { ?>
    <li><a title="Staff Account" href="<?=base_url();?>account/staff"><i class="fa fa-user"></i> <span>Staff Account</span></a></li>
    <? } ?>
</ul>
<div class="message-badge">
    <span class="badge badge-xs danger">1</span>
    <i class="fa fa-caret-right"></i>
    <i class="fa fa-caret-down"></i>
</div>