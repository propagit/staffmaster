<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Public_dispatcher
 * Description: control main flow of the public pages
 * @author: namnd86@gmail.com
 */

class Public_dispatcher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{		
		
	}
	
	function form($form_id, $action='')
	{
		if ($this->input->post()) {
			#var_dump($this->input->post());
		}
		
		$this->load->model('form/form_model');
		$form = $this->form_model->get_form($form_id);
		if (!$form) {
			show_error('Sorry, form not found');
			exit();
		}
		if ($action == 'upload_files') {
			$this->upload_files();
		}
		if ($action == 'submit') {
			$this->submit($form_id);
			die();
		}
		
		$data['form'] = $form;
		$fields = $this->form_model->get_fields($form_id);
		$data['personal_fields'] = modules::run('form/personal_fields', $fields);
		$data['extra_fields'] = modules::run('form/extra_fields', $fields);
		$data['custom_fields'] = $this->form_model->get_custom_fields(true);
		
		$data['roles'] = modules::run('attribute/role/get_roles');
		$data['groups'] = modules::run('attribute/group/get_groups');
		$this->load->view('public/form_view', isset($data) ? $data : NULL);
	}
	
	function submit($form_id) {
		$input = $this->input->post();
		$fields = $this->form_model->get_fields($form_id);
		$errors = array();
		foreach($fields as $field) {
			if ($field['required'] && (!isset($input[$field['form_field_id']]) || !$input[$field['form_field_id']])) {
				$errors[] = $field['form_field_id'];
			}
		}
		if (count($errors) > 0) {
			echo json_encode(array(
				'ok' => false,
				'errors' => $errors
			));
			return;
		}
		$applicant_id = $this->form_model->add_applicant(array('form_id' => $form_id));
		foreach($input as $form_field_id => $value) {
			if (is_array($value)) {
				$value = json_encode($value);
			}
			$this->form_model->add_applicant_data(array(
				'applicant_id' => $applicant_id,
				'form_field_id' => $form_field_id,
				'value' => $value
			));
		}
		echo json_encode(array(
			'ok' => true,
			'errors' => count($errors)
		));
	}
	
	function upload_files() {
		// Make sure file is not cached (as it happens for example on iOS devices)
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		/*
		// Support CORS
		header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}
		*/

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Settings
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		//$targetDir = 'uploads';
		# Create dir for storing file related to the product
		$targetDir = UPLOADS_PATH.'/tmp'; # './user_assets/'.$sub_domain.'/uploads');
		#modules::run('upload/create_upload_folders', $targetDir);

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


		// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}


		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename("{$filePath}.part", $filePath);
			# Add to database
			#$this->staff_model->update_custom_field($user_id, $field_id, $fileName, true);
		}

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
	
}