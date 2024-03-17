<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function datatable(){
		$data = $this->db->get('users')->result_array();
		$json['data'] = $data;
		return $this->output
					->set_content_type('application/json')
					->set_output(json_encode($json));
	}
}
