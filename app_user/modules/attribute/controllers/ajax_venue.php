<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: attribute
*	@controller: ajax_venue
*/

class Ajax_venue extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('venue_model');
		$this->load->library('excel');
	}
	
	function upload_csv()
	{
		$config['upload_path'] = UPLOADS_PATH.'/import/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '2048'; // 2 MB
		echo modules::run('upload/do_upload', $config);
	}
	
	function configure_import()
	{
		$upload_id = $this->input->post('upload_id');
		$upload = modules::run('upload/get_upload', $upload_id);
		
		$file_name = UPLOADS_PATH.'/import/' . $upload['file_name'];
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
		$this->load->view('attribute/venues/import/configure_view', isset($data) ? $data : NULL);
	}
	
	function verify_import()
	{
		$fields = $this->input->post('fields');
		$upload_id = $this->input->post('upload_id');
		$upload = modules::run('upload/get_upload', $upload_id);
		$file_name = UPLOADS_PATH.'/import/' . $upload['file_name'];
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
		$this->load->view('attribute/venues/import/verify_view', isset($data) ? $data : NULL);
	}
	
	function commit_upload()
	{
		$records = $this->input->post('records');
		foreach($records as $data)
		{
			$location_id = 0;
			if (isset($data['location']))
			{
				$location = modules::run('attribute/location/get_location_by_name', $data['location']);
				if ($location)
				{
					$location_id = $location['location_id'];
					$area = modules::run('attribute/location/get_child_location_by_name', $location_id, $data['area']);
					if ($area)
					{
						$location_id = $area['location_id'];
					}
				}
			}
			
			
			$data_venue = array(
				'location_id' => $location_id,
				'name' => $data['name'],
				'address' => $data['address'],
				'suburb' => $data['suburb'],
				'postcode' => $data['postcode'],
				'state' => $location['state']
			);
			$this->venue_model->insert_venue($data_venue);
		}
	}
	
	function validate_field($key, $value)
	{
		if ($key == 'postcode')
		{
			return ($value == '' || (is_numeric((int)$value) && (int)$value < 10000 && (int)$value > 999));
		}
		if ($key == 'location')
		{
			if ($value == '') { return true; }
			if (modules::run('attribute/location/get_location_by_name', $value))
			{
				return true;	
			}
			return false;
		}
		if ($key == 'area')
		{
			if ($value == '') { return true; }
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
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), 'Unrecognized location. Refer to the add venue / location dropdown for available locations');
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('error_report_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "error_report_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		return $file_name;
	}
}