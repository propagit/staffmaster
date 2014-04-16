<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('order_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'import':
					$this->import_orders();
				break;			
			case 'export':
					$this->export_orders();
				break;
			case 'details':
					$this->order_details($param);
				break;
			case 'empty':
					$this->empty_orders();
				break;
			case 'search':
					$this->search_orders();
				break;
			default:
					$this->orders_list($method);
				break;
		}
	}
	
	function search_orders()
	{
		if ($this->input->post())
		{
			$keywords = $this->input->post('keywords');
			$data['orders'] = $this->order_model->search_orders($keywords);
			$data['keywords'] = $keywords;
		}
		$this->load->view('admin_orders_search', isset($data) ? $data : NULL);
	}
	
	function order_details($order_id)
	{
		$order = $this->order_model->get_order($order_id);
		if (!$order)
		{
			redirect('admin/order');
		}
		
		$data['order'] = $order;
		$product = $this->order_model->get_product($order['product_part_no']);
		if (!$product)
		{
			echo 'Product Part No does not exist';
		}
		$data['product'] = $product;
		$this->load->model('product/customer_model');
		$data['states'] = $this->customer_model->get_states();
		
		$this->load->view('admin_order_details', $data);
	}
	
	function orders_list($offset=0)
	{
		$distributor_name = $this->session->userdata('order_distributor');
		$order_type = $this->session->userdata('order_type');
		$this->load->library('pagination');
		$config['base_url'] = base_url(). 'admin/order/';
		$config['per_page'] = 20;
		$config['num_links'] = 2;
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->order_model->get_total_orders($distributor_name, $order_type);
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config); 
		
		$data['pagination'] = $this->pagination->create_links();
		$data['orders'] = $this->order_model->get_orders($config['per_page'], $offset, $distributor_name, $order_type);
		$this->load->model('user/user_model');
		$data['users'] = $this->user_model->get_users();
		$data['distributor_name'] = $distributor_name;
		$this->load->view('admin_orders_list', isset($data) ? $data : NULL);
	}
	
	function export_orders()
	{
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Orders");
		$objPHPExcel->getProperties()->setSubject("Orders");
		$objPHPExcel->getProperties()->setDescription("Orders Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'DEALERNAME');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'PART#');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SERIAL #');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'REQ_NO');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'DIRECTION');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SYS RMA');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'TYPE');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'SALE DATE');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'RECEIVED DATE');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'REPAIR DATE');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'SHIP DATE');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'CON LINK');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'CUST NAME');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'CUST EMAIL');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'CUST ADDRESS');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'CUST SUBURB');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'CUST STATE');
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'CUST POSTCODE');
		$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'CONTACT NUMBER');
		$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'FAULT');
		$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'PRICE');
		
		$orders = $this->order_model->get_orders();
		for($i=0; $i<count($orders); $i++)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $orders[$i]['distributor_company_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $orders[$i]['product_part_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $orders[$i]['product_serial_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $orders[$i]['req_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $orders[$i]['ship_direction']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . ($i+2), $orders[$i]['sys_rma']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . ($i+2), $orders[$i]['type']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . ($i+2), ($orders[$i]['sale_date']) ? date('d/m/Y', $orders[$i]['sale_date']) : NULL);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . ($i+2), ($orders[$i]['received_date']) ? date('d/m/Y', $orders[$i]['received_date']) : NULL);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . ($i+2), ($orders[$i]['repair_date']) ? date('d/m/Y', $orders[$i]['repair_date']) : NULL);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . ($i+2), ($orders[$i]['ship_date']) ? date('d/m/Y', $orders[$i]['ship_date']) : NULL);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . ($i+2), $orders[$i]['consignment']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . ($i+2), $orders[$i]['customer_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . ($i+2), $orders[$i]['customer_email']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . ($i+2), $orders[$i]['customer_address']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . ($i+2), $orders[$i]['customer_suburb']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . ($i+2), $orders[$i]['customer_state']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . ($i+2), $orders[$i]['customer_postcode']);
			$objPHPExcel->getActiveSheet()->SetCellValue('S' . ($i+2), $orders[$i]['customer_phone']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T' . ($i+2), htmlentities($orders[$i]['fault']));
			$objPHPExcel->getActiveSheet()->SetCellValue('U' . ($i+2), $orders[$i]['total']);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('order');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "orders_" . time() . ".csv";
		$objWriter->save(EXPORTS_PATH . "/" . $file_name);
		die($file_name);
	}
	
	
	function import_orders()
	{
		$config['upload_path'] = UPLOADS_PATH.'/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '2048';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('import_file'))
		{
			echo '<div class="alert alert-error">' . $this->upload->display_errors('','') . '</div>';
		}
		else
		{
			$file_data = $this->upload->data();
			$file_name = UPLOADS_PATH."/".$file_data['file_name'];
			#$file_name = UPLOADS_PATH."/orders.xls";
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($file_name);		
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			for($i=2; $i<=count($sheetData); $i++)
			{
				if ($sheetData[$i]['B'])
				{
					$this->order_model->insert_order(array(
						'distributor_company_name' => $sheetData[$i]['A'],
						'product_part_no' => $sheetData[$i]['B'],
						'product_serial_no' => $sheetData[$i]['C'],
						'req_no' => $sheetData[$i]['D'],
						'ship_direction' => $sheetData[$i]['E'],
						'sys_rma' => $sheetData[$i]['F'],
						'type' => $sheetData[$i]['G'],
						'sale_date' => time_convert($sheetData[$i]['H']),
						'received_date' => time_convert($sheetData[$i]['I']),
						'repair_date' => time_convert($sheetData[$i]['J']),
						'ship_date' => time_convert($sheetData[$i]['K']),
						'consignment' => $sheetData[$i]['L'],
						'customer_name' => $sheetData[$i]['M'],
						'customer_email' => $sheetData[$i]['N'],
						'customer_address' => $sheetData[$i]['O'],
						'customer_suburb' => $sheetData[$i]['P'],
						'customer_state' => $sheetData[$i]['Q'],
						'customer_postcode' => $sheetData[$i]['R'],
						'customer_phone' => $sheetData[$i]['S'],
						'fault' => $sheetData[$i]['T'],
						'total' => $sheetData[$i]['U']
					));
				}
			}
			
			unlink($file_name);
			redirect('admin/order');
		}
	}
	
	function empty_orders()
	{
		$this->db->truncate('orders');
		redirect('admin/order');
	}
	
	
}