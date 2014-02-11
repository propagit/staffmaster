<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Attribute Pay Rate
 * @author: namnd86@gmail.com
 */

class Payrate extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrate_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_payrate();
				break;
			case 'edit':
					$this->edit_payrate();
				break;
			case 'update_payrate':
					$this->update_payrate();
				break;
			case 'delete':
					$this->delete_payrate($param);
				break;
			case 'sort':
					$this->sort_payrates();
				break;
			case 'build_payrate':
					$this->build_payrate();
				break;
			default:
					$this->list_payrates();
				break;
		}
	}
	
	/**
	*    @desc This is a function to build the payrate table, to tune the speed of page loading
	*    @name build_payrate
	*    @access public
	*    @param id
	*    @return built table
	*    
	*/
	
	function build_payrate()
	{
		$id = $_POST['id'];
		$tbody = '';
		$payrate = $this->payrate_model->identify($id);
		$def_staff = number_format($payrate['staff_rate'],2,'.',',');
		$def_client = number_format($payrate['client_rate'],2,'.',',');
		$hour_payrate = $payrate['hour_payrate'];
		$hp = json_decode($hour_payrate,TRUE);
					$j = 0;
					for($i=0;$i<24;$i++)
					{
						$ttl = '';
						if($i == 0)
						{
							$ttl = 'Midnight';
						}
						else 
						{
							if($i<12)
							{
								$ttl = $i.':00 AM<br/>('.$i.':00)';
							}
							else 
							{
								if($i>12) {$j = $i-12;}
								$ttl = $j.':00 PM<br/>('.$i.':00)';
							}
						}
						
						$mon_staff = $def_staff;
						$tue_staff = $def_staff;
						$wed_staff = $def_staff;
						$thu_staff = $def_staff;
						$fri_staff = $def_staff;
						$sat_staff = $def_staff;
						$sun_staff = $def_staff;
						
						$mon_client = $def_client;
						$tue_client = $def_client;
						$wed_client = $def_client;
						$thu_client = $def_client;
						$fri_client = $def_client;
						$sat_client = $def_client;
						$sun_client = $def_client;
						
						if($hour_payrate)
						{
							$mon_staff = $hp['monday-'.$i.'-staff'];
							$tue_staff = $hp['tuesday-'.$i.'-staff'];
							$wed_staff = $hp['wednesday-'.$i.'-staff'];
							$thu_staff = $hp['thursday-'.$i.'-staff'];
							$fri_staff = $hp['friday-'.$i.'-staff'];
							$sat_staff = $hp['saturday-'.$i.'-staff'];
							$sun_staff = $hp['sunday-'.$i.'-staff'];
							
							$mon_client = $hp['monday-'.$i.'-client'];
							$tue_client = $hp['tuesday-'.$i.'-client'];
							$wed_client = $hp['wednesday-'.$i.'-client'];
							$thu_client = $hp['thursday-'.$i.'-client'];
							$fri_client = $hp['friday-'.$i.'-client'];
							$sat_client = $hp['saturday-'.$i.'-client'];
							$sun_client = $hp['sunday-'.$i.'-client'];
						}
											
						$tbody.='
						<tr >
							<th>'.$ttl.'</th>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="monday-'.$i.'-staff" name="monday-'.$i.'-staff" value="'.$mon_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="monday-'.$i.'-client" name="monday-'.$i.'-client" value="'.$mon_client.'">
								<div style="clear: both"></div>
							</td>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="tuesday-'.$i.'-staff" name="tuesday-'.$i.'-staff" value="'.$tue_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="tuesday-'.$i.'-client" name="tuesday-'.$i.'-client" value="'.$tue_client.'">
								<div style="clear: both"></div>
							</td>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="wednesday-'.$i.'-staff" name="wednesday-'.$i.'-staff" value="'.$wed_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="wednesday-'.$i.'-client" name="wednesday-'.$i.'-client" value="'.$wed_client.'">
								<div style="clear: both"></div>
							</td>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="thursday-'.$i.'-staff" name="thursday-'.$i.'-staff" value="'.$thu_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="thursday-'.$i.'-client" name="thursday-'.$i.'-client" value="'.$thu_client.'">
								<div style="clear: both"></div>
							</td>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="friday-'.$i.'-staff" name="friday-'.$i.'-staff" value="'.$fri_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="friday-'.$i.'-client" name="friday-'.$i.'-client" value="'.$fri_client.'">
								<div style="clear: both"></div>
							</td>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="saturday-'.$i.'-staff" name="saturday-'.$i.'-staff" value="'.$sat_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="saturday-'.$i.'-client" name="saturday-'.$i.'-client" value="'.$sat_client.'">
								<div style="clear: both"></div>
							</td>
							<td >
								<div class="label-rate">Staff Rate</div>
								<input type="text" class="input-rate staff" id="sunday-'.$i.'-staff" name="sunday-'.$i.'-staff" value="'.$sun_staff.'">
								<div style="clear: both"></div>
								<div class="label-rate">Client Rate</div>
								<input type="text" class="input-rate client" id="sunday-'.$i.'-client" name="sunday-'.$i.'-client" value="'.$sun_client.'">
								<div style="clear: both"></div>
							</td>
						</tr>';
					}
		
					
		
		
		$text = '
		
		<form method="post" action="'.base_url().'attribute/payrate/update_payrate" id="form-payrate-'.$payrate['payrate_id'].'">
  		<input type="hidden" name="id" value="'.$payrate['payrate_id'].'">
  		<div class="table-responsive selectable"  id="wrapper-table">
			<table class="table">
				<thead>
					<tr>
						<th style="width:12.5%">&nbsp;</th>
						<th style="width:12.5%">Monday</th>
						<th style="width:12.5%">Tuesday</th>
						<th style="width:12.5%">Wednesday</th>
						<th style="width:12.5%">Thursday</th>
						<th style="width:12.5%">Friday</th>
						<th style="width:12.5%">Saturday</th>
						<th style="width:12.5%">Sunday</th>
					</tr>
				</thead>
				<tbody >
					'.$tbody.'
				</tbody>
			</table>
		</div>
		
		</form>
		
		
		
		<script>
$(function() {
	$( ".selectable" ).selectable();
	
	$( ".selectable" )
	.mouseup(function() {
		var count = $(".ui-selecting.input-rate.staff").size() + $(".ui-selecting.input-rate.client").size();
		if(count > 0)
		{
			$("#setPayrate").modal("show");
		}
	});
	
});</script>
		';
		
		echo $text;
		exit;
	}
	
	function list_payrates()
	{
		$data['payrates'] = $this->payrate_model->get_payrates();
		$this->load->view('payrate/main_view', isset($data) ? $data : NULL);
	}
	
	function get_payrate_data($payrate_id, $type, $day, $hour)
	{
		return $this->payrate_model->get_payrate_data($payrate_id, $type, $day, $hour);
	}
	
	function sort_payrates()
	{
		if (!$this->session->userdata('sort_payrate'))
		{
			$this->session->set_userdata('sort_payrate', 1);
		}
		else
		{
			$this->session->unset_userdata('sort_payrate');
		}
		redirect('attribute/payrate');
	}
	
	function add_payrate()
	{
		$data = $this->input->post();
		$this->payrate_model->insert_payrate($data);
		redirect('attribute/payrate');
	}
	
	function edit_payrate()
	{
		$data = $this->input->post();
		$this->payrate_model->update_payrate($data['payrate_id'], $data);
		redirect('attribute/payrate');
	}
	
	/**
	*    @desc This is a function to update a specific payrate based on the payrate ID
	*    @name update_payrate
	*    @access public
	*    @param null
	*    @return none
	*    
	*/
	
	
	function update_payrate()
	{
		//print_r($_POST);
		$id = $_POST['id'];
		$hp = array();
		for($i=0;$i<24;$i++)
		{
			$hp['monday-'.$i.'-staff'] = $_POST['monday-'.$i.'-staff'];
			$hp['tuesday-'.$i.'-staff'] = $_POST['tuesday-'.$i.'-staff'];
			$hp['wednesday-'.$i.'-staff'] = $_POST['wednesday-'.$i.'-staff'];
			$hp['thursday-'.$i.'-staff'] = $_POST['thursday-'.$i.'-staff'];
			$hp['friday-'.$i.'-staff'] = $_POST['friday-'.$i.'-staff'];
			$hp['saturday-'.$i.'-staff'] = $_POST['saturday-'.$i.'-staff'];
			$hp['sunday-'.$i.'-staff'] = $_POST['sunday-'.$i.'-staff'];
			
			$hp['monday-'.$i.'-client'] = $_POST['monday-'.$i.'-client'];
			$hp['tuesday-'.$i.'-client'] = $_POST['tuesday-'.$i.'-client'];
			$hp['wednesday-'.$i.'-client'] = $_POST['wednesday-'.$i.'-client'];
			$hp['thursday-'.$i.'-client'] = $_POST['thursday-'.$i.'-client'];
			$hp['friday-'.$i.'-client'] = $_POST['friday-'.$i.'-client'];
			$hp['saturday-'.$i.'-client'] = $_POST['saturday-'.$i.'-client'];
			$hp['sunday-'.$i.'-client'] = $_POST['sunday-'.$i.'-client'];
		}
		$data['hour_payrate'] = json_encode($hp);
		$this->payrate_model->update_payrate($id, $data);
		$this->session->set_flashdata('payrate_just_updated',$id);
		redirect('attribute/payrate');
	}
	
	function delete_payrate($payrate_id)
	{
		$this->payrate_model->delete_payrate($payrate_id);
		redirect('attribute/payrate');
	}
	
	function get_payrates()
	{
		return $this->payrate_model->get_payrates();
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['payrates'] = $this->payrate_model->get_payrates();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_payrates', isset($data) ? $data : NULL);
	}
	
}