<html>
	<head>
	<style>
	</style>
	</head>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
            	<td width="65%"><?=modules::run('setting/company_logo');?></td>
            	<td width="35%" align="right"><b><?=$date_from;?> - <?=$date_to;?></b></td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="5" cellspacing="5" border="0" style="border: 1px solid #ccc; border-collapse:collapse;">
        	<?=$content;?>
        </table>
    	<br />
	</body>
</html>