<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: attribute
*	@controller: ajax_venue
*/

class Ajax_import extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('client_model');
		$this->load->library('excel');
	}
	
	function upload_csv()
	{
		$config['upload_path'] = './uploads/import/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '2048'; // 2 MB
		echo modules::run('upload/do_upload', $config);
	}
	
	function configure_import()
	{
		$upload_id = $this->input->post('upload_id');
		$upload = modules::run('upload/get_upload', $upload_id);
		
		$file_name = './uploads/import/' . $upload['file_name'];
		$objReader = PHPExcel_IOFactory::createReader('CSV');
		$objPHPExcel = $objReader->load($file_name);
		
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();  
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);  
		
		$row1 = array();
		$row2 = array();
		for ($col = 0; $col <= $highestColumnIndex; ++$col) {
		    $row1[] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
		    $row2[] = $objWorksheet->getCellByColumnAndRow($col, 2)->getValue();
		}
		
		
		$data['fields'] = $row1;
		$data['samples'] = $row2;
		$data['total_records'] = $highestRow - 1;
		$data['upload_id'] = $upload_id;
		$this->load->view('client/import/configure_view', isset($data) ? $data : NULL);
	}
	
	function verify_import()
	{
		$fields = $this->input->post('fields');
		$upload_id = $this->input->post('upload_id');
		$upload = modules::run('upload/get_upload', $upload_id);
		$file_name = './uploads/import/' . $upload['file_name'];
		$savedValueBinder = PHPExcel_Cell::getValueBinder();
        PHPExcel_Cell::setValueBinder(new TextValueBinder());
        
        
		$objReader = PHPExcel_IOFactory::createReader('CSV');
		$objPHPExcel = $objReader->load($file_name);
		
		PHPExcel_Cell::setValueBinder($savedValueBinder);
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$records = array();
		for($i=2; $i<=count($sheetData); $i++)
		{
			$record = array();
			$k = 0;
			foreach($sheetData[$i] as $field)
			{
				$record[$fields[$k]] = $field;
				$k++;
			}
			$records[] = $record;
		}
		$errors = array();
		$row = 1;
		foreach($records as $record)
		{
			$row++;
			$column = 0;
			foreach($record as $key => $value)
			{
				$column++;
				if(!$this->validate_field($key, $value))
				{
					$errors[] = array(
						'row' => $row,
						'column' => $column,
						'key' => $key,
						'value' => $value
					);
				}				
			}
		}
		$data['errors'] = $errors;
		$data['error_report_file'] = $this->generate_error_report($errors);
		$data['records'] = json_encode($records);
		$data['upload_id'] = $upload_id;
		$this->load->view('client/import/verify_view', isset($data) ? $data : NULL);
	}
	
	function commit_upload()
	{
		$records = $this->input->post('records');
		foreach($records as $data)
		{
			$status = 0;
			if (strtolower($data['status']) == 'active')
			{
				$status = CLIENT_ACTIVE;
			}
			$user_data = array(
				'status' => $status,
				'is_admin' => 0,
				'is_staff' => 0,
				'is_client' => 1,
				'email_address' => $data['email_address'],
				'username' => $data['email_address'],
				'full_name' => $data['full_name'],
				'address' => $data['address'],
				'suburb' => $data['suburb'],
				'city' => $data['city'],
				'state' => $data['state'],
				'postcode' => $data['postcode'],
				'country' => $data['country'],
				'phone' => $data['phone']
			);
			$user_id = $this->user_model->insert_user($user_data);
		
			$client_data = array(
				'user_id' => $user_id,
				'external_client_id' => $data['external_client_id'],
				'company_name' => $data['company_name'],
				'abn' => $data['abn']
			);
			$client_id = $this->client_model->insert_client($client_data);
		}
	}
	
	function validate_field($key, $value)
	{
		if ($key == 'company_name')
		{
			return ($value != '');
		}
		if ($key == 'postcode')
		{
			return ($value == '' || (is_numeric((int)$value) && (int)$value < 10000 && (int)$value > 999));
		}
		if ($key == 'state')
		{
			$states = modules::run('common/get_states');
			$array = array();
			foreach($states as $state) {
				$array[] = strtolower($state['code']);
				$array[] = strtolower($state['name']);
			}
			return ($value == '' || in_array(strtolower($value), $array));
		}
		if ($key == 'country')
		{
			$countries = modules::run('common/get_countries');
			$array = array();
			foreach($countries as $country) {
				$array[] = strtolower($country['code']);
				$array[] = strtolower($country['name']);
			}
			return ($value == '' || in_array(strtolower($value), $array));
		}
		if ($key == 'email')
		{
			$this->load->helper('email');
			return valid_email($value);
		}
		if ($key == 'status')
		{
			$status = array('active','inactive');
			return in_array(strtolower($value), $status);
		}
		return true;
	}
	
	function generate_error_report($errors)
	{
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Import Error Report");
		$objPHPExcel->getProperties()->setSubject("Import Error Report");
		$objPHPExcel->getProperties()->setDescription("Import Error Report Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Row');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Column');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Field');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Value');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Error Message');
		
		for($i=0; $i<count($errors); $i++)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $errors[$i]['row']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $errors[$i]['column']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $errors[$i]['key']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $errors[$i]['value']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $this->get_sample($errors[$i]['key']));
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('error_report_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "error_report_" . time() . ".xlsx";
		$objWriter->save("./exports/error/" . $file_name);
		return $file_name;
	}
	
	function get_sample($key)
	{
		if ($key == 'company_name')
		{
			return 'Required field';
		}
		if ($key == 'postcode')
		{
			return '4 digit number';
		}
		if ($key == 'state')
		{
			return 'VIC, NSW, QLD, TAS, ACT, SA, WA, NT';
		}
		if ($key == 'country')
		{
			return '';
		}
		if ($key == 'email')
		{
			return 'name@example.com';
		}
		return true;
	}
}