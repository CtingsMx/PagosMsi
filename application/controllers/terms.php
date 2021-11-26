<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Terms extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$head['title'] = "Términos y Condiciones";

		$data = [];

		$this->load->view('eco/_head', $head);
		$this->load->view('eco/_menu');
		$this->load->view('eco/pages/terms', $data);
		$this->load->view('eco/_footer');
	}
}
