<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plados extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('m_plados', "", true);
        $this->load->model('m_stripe', "", true);

        $this->load->library('session');
        session_start();

        $stripeKeys = STRIPE_KEYS;
        $this->stripekey = $stripeKeys['serverside'][STRIPE_MODE];
    }

   




}