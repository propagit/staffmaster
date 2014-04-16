<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('order/order_model');
	}
	
	public function index()
	{
		$data['total_stocks'] = $this->dashboard_model->get_total_stocks();
		$data['total_products'] = $this->dashboard_model->get_total_products();
		$data['total_accounts'] = $this->dashboard_model->get_total_accounts();
		$data['total_users'] = $this->dashboard_model->get_total_users();
		$data['orders'] = $this->order_model->get_orders(2,0);
		$this->load->view('admin_dashboard', isset($data) ? $data : NULL);
	}
		
}