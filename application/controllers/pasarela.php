<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Openpay\Data\Openpay;

class Pasarela extends CI_Controller
{

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('m_plados', "", true);
        $this->load->model('m_stripe', "", true);
        $this->load->library('session');
        $this->load->library('encrypt');

        session_start();

    }

    public function index()
    {
       // header('Content-Type: application/json');
        $openpay = Openpay::getInstance('mex0qnhtpq3m0yvkl3sa', 'sk_0d2dbc7f9a6a4f88a5320c75a28815dd', 'MX');

       /* $customerData = array(
            'name' => 'Teofilo',
            'last_name' => 'Velazco',
            'email' => 'teofilo@payments.com',
            'phone_number' => '4421112233',
            'address' => array(
                'line1' => 'Privada Rio No. 12',
                'line2' => 'Co. El Tintero',
                'line3' => '',
                'postal_code' => '76920',
                'state' => 'Querétaro',
                'city' => 'Querétaro.',
                'country_code' => 'MX'));

        $customer = $openpay->customers->add($customerData);
        */

        $findData = array(
            'creation[gte]' => '2022-03-01',
            'creation[lte]' => '2022-03-31',
            'offset' => 0,
            'limit' => 5);

        $customerList = $openpay->customers->getList($findData);

        $customer = $openpay->customers->get('amhd2eavnlxrobz48wff');


        echo json_encode($customer);
        //Openpay :: getProductionMode(false);
    }
}
