<div class="col-md-12 visible-lg">
	<div class="box top-box" id="setup_wizard">
        <h2>Set Up Wizard</h2>
        <p>Use the set up wizard to personalise your system and start creating jobs.</p>
        <div class="wp_wizard">
        	<hr />
        	<div class="steps">
		        <div class="wizard_step first-child">
					<a href="<?=base_url();?>setting/company#setup_wizard"><div class="c1<?=($step=='company') ? ' current' : '';?><?=($company_profile) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Company Profile
						<? if ($company_profile) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incompleted</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>staff/add#setup_wizard"><div class="c1<?=($step=='staff') ? ' current' : '';?><?=($has_staff) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Add Staff
						<? if ($has_staff) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incomplete</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>client/add#setup_wizard"><div class="c1<?=($step=='client') ? ' current' : '';?><?=($has_client) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Add Client
						<? if ($has_client) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incomplete</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>attribute/payrate#setup_wizard"><div class="c1<?=($step=='payrate') ? ' current' : '';?><?=($has_payrate) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Add Pay Rates
						<? if ($has_payrate) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incomplete</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>attribute/venue#setup_wizard"><div class="c1<?=($step=='venue') ? ' current' : '';?><?=($has_venue) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Add Venues
						<? if ($has_venue) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incomplete</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>attribute/role#setup_wizard"><div class="c1<?=($step=='role') ? ' current' : '';?><?=($has_role) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Add Roles
						<? if ($has_role) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incomplete</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>attribute/uniform#setup_wizard"><div class="c1<?=($step=='uniform') ? ' current' : '';?><?=($has_uniform) ? ' done' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Add Uniforms
						<? if ($has_uniform) { ?>
						<div class="text-success"><b>Completed</b></div>
						<? } else { ?>
						<div><b>Incomplete</b></div>
						<? } ?>
					</div>
		        </div>
		        
		        <div class="wizard_step">
					<a href="<?=base_url();?>job/create#setup_wizard"><div class="c1<?=($step=='job') ? ' current' : '';?>">
						<i class="fa fa-check fa-2x fa-inverse"></i>
					</div></a>
					<div class="step_label">
						Create Jobs
						<div><b>Incomplete</b></div>
					</div>
		        </div>
        	</div>
        </div>
    </div>
</div>