<html>
	<head>
	<style>
	</style>
	</head>
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
        <table width="100%" cellpadding="5" cellspacing="5" border="0" style="border: 1px solid #ccc; border-collapse:collapse;">
        	<tr valign="top">
        		<td style="border:1px solid #ccc;" width="22%">Staff<br />Name</td>
        		<td style="border:1px solid #ccc;" width="7%">Start<br />Shift</td>
        		<td style="border:1px solid #ccc;" width="7%">Break<br />Start</td>
        		<td style="border:1px solid #ccc;" width="7%">Break<br />Finish</td>
        		<td style="border:1px solid #ccc;" width="7%">Break<br />Start</td>
        		<td style="border:1px solid #ccc;" width="7%">Break<br />Finish</td>
        		<td style="border:1px solid #ccc;" width="7%">Finish<br />Shift</td>
        		<td style="border:1px solid #ccc;" width="14%">Supervisor<br />Signature</td>
        		<td style="border:1px solid #ccc;" width="22%">Rating Staff<br />From 1-5</td>
        	</tr>
        	<? foreach($shifts as $s) {
        		$breaks = json_decode($s['break_time']);
        	?>
        	<tr valign="top">
        		<td style="border:1px solid #ccc;">
        			<?=$s['first_name'];?><br />
        			<?=$s['last_name'];?>
        			<br /><br /><?=$s['role_name'];?>
        		</td>
        		<td valign="top" style="border:1px solid #ccc;"><?=date('H:i', $s['start_time']);?></td>
        		<td valign="top" style="border:1px solid #ccc;">
	        		<? if (isset($breaks[0])) {
	        			echo date('H:i', $breaks[0]->start_at);
	        		} ?>
        		</td>
        		<td valign="top" style="border:1px solid #ccc;">
	        		<? if (isset($breaks[0])) {
	        			echo date('H:i', $breaks[0]->start_at + $breaks[0]->length);
	        		} ?>
        		</td>
        		<td valign="top" style="border:1px solid #ccc;">
	        		<? if (isset($breaks[1])) {
	        			echo date('H:i', $breaks[1]->start_at);
	        		} ?>
        		</td>
        		<td valign="top" style="border:1px solid #ccc;">
	        		<? if (isset($breaks[1])) {
	        			echo date('H:i', $breaks[1]->start_at + $breaks[1]->length);
	        		} ?>
        		</td>
        		<td valign="top" style="border:1px solid #ccc;"><?=date('H:i', $s['finish_time']);?></td>
        		<td style="border:1px solid #ccc;"></td>
        		<td style="border:1px solid #ccc;">
	        		Presentable<br />
	        		Punctual<br />
	        		Productive<br />
	        		Efficient
        		</td>
        	</tr>
        	<? } ?>
        </table>
    	<br />
    	<table width="100%" cellpadding="5" cellspacing="5" border="0" style="border: 1px solid #ccc; border-collapse:collapse;">
    		<tr>
    			<td>
    				<h2 style="font-weight:600">Comment:</2>
    				<br /><br /><br /><br /><br /><br />
    			</td>
    		</tr>
    	</table>
    	<br /><br />
    	<p>TIME SHEET.<span style="text-transform:uppercase"><?=$company_profile['company_name'];?></span> P:<?=$company_profile['telephone'];?> F:<?=$company_profile['fax'];?> E: <a href="mailto:<?=$company_profile['email'];?>"><?=$company_profile['email'];?></a> ABN: <?=$company_profile['abn_acn'];?></p>
    	<p>Company's Representative Authorising Signature certifies that hours shown are correct and work was done satisfactorily. A timesheet is a legal document - it is an offence to falsify a timesheet.</p>
    	<p><b><i>Note: Timesheets without client signatures will not be authorised/paid.</i></b></p>
	</body>
</html>    