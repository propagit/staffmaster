<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: upload
*	@controller: upload
*/

class Upload extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('upload/upload_model');
	}
	
	/**
	*	@name: do_upload
	*	@desc: function to upload a file and store file information to database
	*	@access: public
	*	@param: (array) $config
	*	@return: (json) {ok: false, msg: string} or {ok: true, upload_id: int}
	*/
	function do_upload($config) 
	{
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload())
		{
			$msg = $this->upload->display_errors('','');
			return json_encode(array(
				'ok' => false,
				'msg' => $msg
			));
		}
		else
		{
			$data = $this->upload->data();
			$upload_id = $this->upload_model->insert_upload($data);
			return json_encode(array(
				'ok' => true,
				'upload_id' => $upload_id
			));
		}
	}
	
	/**
	*	@name: get_upload
	*	@desc: function to get file information from database
	*	@access: public
	*	@param: (int) $upload_id
	*	@return: (array) file data
	*/
	function get_upload($upload_id)
	{
		return $this->upload_model->get_upload($upload_id);
	}
	
}