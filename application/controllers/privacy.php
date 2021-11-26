<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Privacy extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$head['title'] = "Aviso de Privacidad";

		$data = [];

		$this->load->view('eco/_head', $head);
		$this->load->view('eco/_menu');
		$this->load->view('eco/pages/privacy', $data);
		$this->load->view('eco/_footer');
	}
}
