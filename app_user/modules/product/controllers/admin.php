<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'import':
					$this->import_products();
				break;
			case 'category':
					$this->product_categories($param);
				break;
			case 'brand':
					$this->product_brands($param);
				break;
			case 'export':
					$this->export_products();
				break;
			case 'details':
					$this->product_details($param);
				break;
			default:
					$this->products_list($method);
				break;
		}
	}
	
	function product_details($product_id)
	{
		$product = $this->product_model->get_product($product_id);
		if (!$product)
		{
			redirect('admin/product');
		}
		if ($this->input->post())
		{
			if($this->product_model->update_product($product_id, $this->input->post()))
			{
				$data['result'] = true;
				$product = $this->product_model->get_product($product_id);
			}
		}
		$data['product'] = $product;
		$data['brand'] = $this->product_model->get_brand($product['brand_id']);
		$data['category'] = $this->product_model->get_category($product['category_id']);
		$this->load->view('admin_product_details', $data);
	}
	
	function products_list($offset=0)
	{
		if ($this->input->post())
		{
			$this->session->set_userdata('keywords', $this->input->post('keywords'));
		}
		else
		{
			$this->session->unset_userdata('keywords');
		}
		$keywords = $this->session->userdata('keywords');
		
		$this->load->library('pagination');
		$config['base_url'] = base_url(). 'admin/product/';
		$config['per_page'] = 50;
		$config['num_links'] = 2;
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->product_model->get_total_products($keywords);
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
		$data['products'] = $this->product_model->get_products($config['per_page'], $offset, $keywords);
		$this->load->view('admin_products_list', $data);
	}
	
	function export_products()
	{
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Products");
		$objPHPExcel->getProperties()->setSubject("Products");
		$objPHPExcel->getProperties()->setDescription("Products Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'categoryID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'priority');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'brandID');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'title');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'description');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'partno');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'thumbURL');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'picURL');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'visible');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'alternate_part');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'price');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'checkitems');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'doclink');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'day3');
		
		$products = $this->product_model->get_products();
		for($i=0; $i<count($products); $i++)
		{			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $products[$i]['reference_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $products[$i]['category_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $products[$i]['priority']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $products[$i]['brand_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $products[$i]['title']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . ($i+2), $products[$i]['description']);
			#$objPHPExcel->getActiveSheet()->SetCellValue('G' . ($i+2), $products[$i]['part_no']);
			
			$objPHPExcel->getActiveSheet()->getStyle('G' . ($i+2))->getNumberFormat()->setFormatCode('@');
			$objPHPExcel->getActiveSheet()->getCell('G' . ($i+2))->setValueExplicit($products[$i]['part_no'], PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->getActiveSheet()->SetCellValue('H' . ($i+2), $products[$i]['thumb_url']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . ($i+2), $products[$i]['pic_url']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . ($i+2), ($products[$i]['visible']) ? TRUE : FALSE);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . ($i+2), $products[$i]['alternate_part']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . ($i+2), $products[$i]['price']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . ($i+2), $products[$i]['check_items']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . ($i+2), $products[$i]['doc_links']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . ($i+2), ($products[$i]['day3']) ? 1 : 0);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('product');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = "products_" . time() . ".csv";
		$objWriter->save("./exports/" . $file_name);
		die($file_name);
	}
		
	function import_products()
	{
		$config['upload_path'] = UPLOADS_PATH . '/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '2048';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('import_file'))
		{
			echo '<div class="alert alert-error">' . $this->upload->display_errors('','') . '</div>';
		}
		else
		{
			$this->db->truncate('products');
			$file_data = $this->upload->data();
			$file_name = UPLOADS_PATH . "/" . $file_data['file_name'];
			$this->load->library('excel');
			#$objPHPExcel = PHPExcel_IOFactory::load($file_name);		
			#$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			
			$savedValueBinder = PHPExcel_Cell::getValueBinder();
            PHPExcel_Cell::setValueBinder(new TextValueBinder());
            
            
			$objReader = PHPExcel_IOFactory::createReader('CSV');
			$objPHPExcel = $objReader->load($file_name);
			
			PHPExcel_Cell::setValueBinder($savedValueBinder);
			
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			for($i=2; $i<=count($sheetData); $i++)
			{
				$price = str_replace('$', '', $sheetData[$i]['L']);
				
				$part_no = $sheetData[$i]['G'];
				$this->product_model->insert_product(array(
					'reference_id' => $sheetData[$i]['A'],
					'category_id' => $sheetData[$i]['B'],
					'priority' => $sheetData[$i]['C'],
					'brand_id' => $sheetData[$i]['D'],
					'price' => $price,
					'title' => $sheetData[$i]['E'],
					'description' => $sheetData[$i]['F'],
					'part_no' => $part_no,
					'thumb_url' => $sheetData[$i]['H'],
					'pic_url' => $sheetData[$i]['I'],
					'visible' => $sheetData[$i]['J'],
					'alternate_part' => $sheetData[$i]['K'],
					'check_items' => $sheetData[$i]['M'],
					'doc_links' => $sheetData[$i]['N'],
					'day3' => $sheetData[$i]['O']
				));
			}
			unlink($file_name);
			redirect('admin/product');
		}
	}
	
	function product_categories($param='')
	{
		if ($param == 'import')
		{
			$this->import_product_categories();
		}
		else if ($param == 'export')
		{
			$this->export_product_categories();
		}
		
		$data['categories'] = $this->product_model->get_categories();
		$this->load->view('admin_product_categories', $data);
	}
	
	function export_product_categories()
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Categories");
		$objPHPExcel->getProperties()->setSubject("Categories");
		$objPHPExcel->getProperties()->setDescription("Product categories Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'parentID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'title');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'priority');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'intro');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'visible');
		
		$categories = $this->product_model->get_categories();
		for($i=0; $i<count($categories); $i++)
		{			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $categories[$i]['reference_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $categories[$i]['parent_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $categories[$i]['title']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $categories[$i]['priority']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $categories[$i]['intro']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . ($i+2), ($categories[$i]['visible']) ? TRUE : FALSE);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('category');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "categories_" . time() . ".xlsx";
		$objWriter->save("./exports/" . $file_name);
		die($file_name);
	}
	
	function import_product_categories()
	{
		$config['upload_path'] = UPLOADS_PATH . '/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '2048';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('import_file'))
		{
			echo '<div class="alert alert-error">' . $this->upload->display_errors('','') . '</div>';
		}
		else
		{
			$this->db->truncate('categories');
			$file_data = $this->upload->data();
			$file_name = UPLOADS_PATH . "/" . $file_data['file_name'];
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($file_name);			
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			for($i=2; $i<=count($sheetData); $i++)
			{
				$data = array(
					'reference_id' => $sheetData[$i]['A'],
					'parent_id' => $sheetData[$i]['B'],
					'title' => $sheetData[$i]['C'],
					'priority' => ($sheetData[$i]['D'] != NULL) ? $sheetData[$i]['D'] : 0,
					'intro' => ($sheetData[$i]['E'] != NULL) ? $sheetData[$i]['E'] : '',
					'visible' => $sheetData[$i]['F']
				);
				#var_dump($data);
				$this->product_model->insert_category($data);
			}
			unlink($file_name);
		}
	}
	
	function product_brands($param='')
	{
		if ($param == 'import')
		{
			$this->import_product_brands();
		}
		else if ($param == 'export')
		{
			$this->export_product_brands();
		}
		$data['brands'] = $this->product_model->get_brands();
		$this->load->view('admin_product_brands', $data);
	}
	
	function import_product_brands()
	{
		$config['upload_path'] = UPLOADS_PATH . '/';
		$config['allowed_types'] = '*';
		$config['max_size'] = '2048';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('import_file'))
		{
			echo '<div class="alert alert-error">' . $this->upload->display_errors('','') . '</div>';
		}
		else
		{
			$this->db->truncate('brands');
			$file_data = $this->upload->data();
			$file_name = UPLOADS_PATH . "/" . $file_data['file_name'];
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($file_name);			
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			for($i=2; $i<=count($sheetData); $i++)
			{
				#echo $sheetData[$i]['A'] . ' - ' . $sheetData[$i]['B'] . '<br />';
				$this->product_model->insert_brand(array(
					'reference_id' => $sheetData[$i]['A'],
					'name' => $sheetData[$i]['B']
				));
			}
			unlink($file_name);
		}
	}
	
	function export_product_brands()
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Brands");
		$objPHPExcel->getProperties()->setSubject("Brands");
		$objPHPExcel->getProperties()->setDescription("Product brands Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'title');
		
		$brands = $this->product_model->get_brands();
		for($i=0; $i<count($brands); $i++)
		{			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $brands[$i]['reference_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $brands[$i]['name']);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('brand');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "brands_" . time() . ".xlsx";
		$objWriter->save("./exports/" . $file_name);
		die($file_name);
	}
	
}