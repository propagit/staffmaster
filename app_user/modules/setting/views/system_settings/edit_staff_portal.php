<div class="company-profile-detail-box">
    <h2>Staff Portal Configuration</h2>
    <p>
      Change the colours of the system look and feel to suite your companies branding.<br />
      The primary colour can be changed and the text colour used throughout the system
    </p>
</div>

<div class="table-responsive">
<table class="table" width="100%">
    <tr>
        <td colspan="2">Dashboard</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_dashboard');?>
        </td>
    </tr>
    <tr>
        <td colspan="3">Staff Profile</td>
    </tr>
    <tr>
        <td width="30"></td>
        <td>Pictures</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_picture');?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Financial Details</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_financial');?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Superannuation Details</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_super');?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Roles</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_role');?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Availability</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_availability');?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Locations</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_location');?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Groups</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_group');?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td>Attributes</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_attribute');?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Apply For Work</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_work');?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Timesheets</td>
        <td align="right">
            <?=modules::run('common/switch_config', 'sp_timesheet');?>
        </td>
    </tr>
</table>
</div>
