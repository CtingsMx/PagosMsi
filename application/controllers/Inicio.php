<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('m_seguridad', "", TRUE);
		$this->load->model('m_usuario', "", TRUE);
		$this->load->model('m_inicio', "", TRUE);
		$this->load->model('m_admin', "", TRUE);
	}

	public function index()
	{

		$head['title'] = "Inicio | Administrador";

		$datos['pedidos'] = $this->m_inicio->pedidosAbiertos();
		$this->load->view('_encabezado', $head);
		$this->load->view('_menuLateral1');
		$this->load->view('v_inicio', $datos);
		$this->load->view('_footer1');
	}



	public function noaccess()
	{
		$this->load->view('_head');
		$this->load->view('errors/_noaccess');
	}
}
