<div class="col-md-12 visible-lg">
	<div class="box top-box" id="setup_wizard">
        <h2>Set Up Wizard</h2>
        <p>Use the set up wizard to personalise your system and start creating jobs.</p>
        <div class="wp_wizard">
        	<hr />
        	<div class="steps" id="list-steps">
        		<?=$this->load->view('steps_view', $data);?>
			</div>
        </div>
    </div>
</div>