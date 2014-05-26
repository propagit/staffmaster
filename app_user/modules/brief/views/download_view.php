<html>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
            	<td width="65%"><?=modules::run('setting/company_logo');?></td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td><b>Timesheet</b></td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
            	<td width="10%"><b>Job Name:</b></td>
                <td width="35%"><?=$job['name'];?></td>
                <td width="5%"><b>Venue:</b></td>
                <td width="40%"><?=$venue['name'];?></td>
            </tr>
            <tr>
            	<td><b>Date:</b></td>
                <td><?=date('dS M Y', strtotime($shift['job_date']));?></td>
                <td></td>
                <td><?=$venue['address'];?></td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td></td>
                <td><?=$venue['suburb'];?> <?=$venue['state'];?>, <?=$venue['postcode'];?></td>
            </tr>
            <tr>
            	<td colspan="4" style="height: 15px;"></td>
            </tr>
        	<tr>
        		<td><b>Supervisor</b></td>
        		<? if ($supervisor) { ?>
        		<td><?=$supervisor['first_name'] . ' ' . $supervisor['last_name'];?></td>
        		<td><b>Contact</b></td>
        		<td><?=$supervisor['phone'];?></td>
        		<? } else { ?>
        		<td colspan="3">
        			<div  style="border-bottom: 1px solid #ccc;"></div>
        		</td>
        		<? } ?>
        	</tr>
        </table>
        <p>As you record below the hours worked by our staff please also rate them on the listed attributes on a scale of 1 to 5.</p>
        <p><i>1 = unsatisfactory, 2 = somewhat unsatisfactory, 3 = satisfied, 4 = above expectations, 5 = outstanding</i></p>
        <br />
        <table width="100%" cellpadding="0" cellspacing="5" style="border:1px solid #ccc">
        	<tr>
        		<td>Staff Name</td>
        		<td>Start<br />Shift</td>
        		<td>Break<br />Start</td>
        		<td>Break<br />Finish</td>
        		<td>Break<br />Start</td>
        		<td>Break<br />Finish</td>
        		<td>Finish<br />Shift</td>
        		<td>Supervisor<br />Signature</td>
        		<td>Rating Staff<br />From 1-5</td>
        	</tr>
        </table>
	</body>
</html>        