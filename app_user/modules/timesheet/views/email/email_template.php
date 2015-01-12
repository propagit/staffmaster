<table width="528px" cellpadding="20" style="border-collapse:collapse; font-size:20px; font-family:Arial, Helvetica, sans-serif; background:#eaeaea;">
	<tbody>
   		<tr>
        	<td align="left" style="border:1px solid #ccc; border-right:none; width:52px;" valign="middle">
            <img src="<?=base_url();?>assets/img/email/user.png" title="Users Icon" alt="user.png" /> 
            </td>
            <td style="border:1px solid #ccc; border-left:none;">Employees</td>
            <td align="center" style="border:1px solid #ccc;" valign="middle"><b><?=$total_staff;?></b></td>
        </tr> 
        <tr>
        	<td align="left" style="border:1px solid #ccc; border-right:none; width:52px;" valign="middle">
            <img src="<?=base_url();?>assets/img/email/timesheet_icon.png" title="Time Sheet Icon" alt="timesheet_icon.png" />
            </td>
            <td style="border:1px solid #ccc; border-left:none;">Time Sheets For Approval</td>
            <td align="center" style="border:1px solid #ccc;" valign="middle"><b><?=$total_ts;?></b></td>
        </tr>
	</tbody>
</table>
<br><br>
<a href="<?=$url;?>" target="_blank"><img src="<?=base_url();?>assets/img/email/approve_timesheet_btn.png" title="Time Sheet Approve Button" alt="approve_timesheet_btn.png" /></a>