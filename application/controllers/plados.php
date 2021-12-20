<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plados extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('usuario', "", true);
        $this->load->model('m_plados', "", true);
        $this->load->model('m_admin', "", true);
        $this->load->model('m_stripe', "", true);

        $this->load->library('session');
        session_start();

        $stripeKeys = STRIPE_KEYS;
        $this->stripekey = $stripeKeys['serverside'][STRIPE_MODE];
    }

    public function index()
    {

        $head['title'] = "Portal de Pagos KOBER";
        //id del pago
        $id = $this->input->get('id');

        $this->load->view('inicio');

        if(!$id){
            $error['error'] = "ingrese la Compra";
            $this->load->view('errors', $error);
            return;
        }

        if($this->m_plados->esPagoRealizado($id)){
            $error['error'] = "Esta compra ya fue Pagada";
            $this->load->view('errors', $error);
            return;
        }
        
        $venta = $this->m_plados->obtVenta($id);

        if(empty($venta)) {
            $error['error'] = "La compra solicitada no existe";
            $this->load->view('errors', $error);
           return;
        }

        $this->m_stripe->generarCuenta($venta[0]);
        
        $sucursal = $this->m_plados->obtKeySucursal($venta[0]->Sucursal);

        //PARA PRUEBAS... BORRAR EN PROD
      //  $sucursal = $this->m_plados->obtKeySucursal(0);

        if(empty($sucursal)) {
            $error['error'] = "La sucursal no cuenta aún con Pagos a Meses sin intereses";
            $this->load->view('errors', $error);
            return;
         }

        $datos['venta'] = $venta; 
        $this->load->view('pagos', $datos);       
        
       
    }




}