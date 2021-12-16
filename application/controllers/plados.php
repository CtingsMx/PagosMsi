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

        if(!$id){
            echo "ingrese la Compra";
            return;
        }
        
        $venta = $this->m_plados->obtVenta($id);

        if(empty($venta)) {
           echo "No existe el id de compra ingresado";
           die();
        }

        $this->m_stripe->generarCuenta($venta[0]);
        
        $sucursal = $this->m_plados->obtKeySucursal($venta[0]->Sucursal);

        //PARA PRUEBAS... BORRAR EN PROD
        $sucursal = $this->m_plados->obtKeySucursal(0);

        if(empty($sucursal)) {
            echo "La sucursal no cuenta con Pagos a Meses sin intereses aun";
            die();
         }

        $datos['venta'] = $venta;        
        $this->load->view('inicio', $datos);
       
    }


    /**
     * Vista del carrito
     * 
     * Valida el pedido antes de mandarlo a pago, tambien valida los
     * codigos de promocion!
     * 
     * @return view
     */
    function carrito()
    {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_merge($_SESSION['cart']);
            $datos['carrito'] = $_SESSION['cart'];

            unset($_SESSION['descuento']);
            unset($_SESSION['promoCode']);

            $datos['cuenta'] = $this->m_stripe->obtCuenta();
        } else {
            $datos['carrito'] = null;
        }


        $head['title'] = "Carrito";


        $this->load->view('eco/_head', $head);
        //$this->load->view('_menuLateral1');
        $this->load->view('eco/_menu');
        $this->load->view('eco/pages/carrito', $datos);
        $this->load->view('eco/_footer');
    }

    function eliminar_art()
    {
        $articulo = $this->input->get('articulo');
        unset($_SESSION['cart'][$articulo]);
        //var_export($_SESSION['cart']);
        $_SESSION['alertaNuevoProducto'] = 1;

        redirect($_SERVER['HTTP_REFERER']);
        //redirect('carrito');
    }

    function datos_cliente()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $usuario = false;

        if (isset($_SESSION['idCliente'])) {
            $usuario = $this->m_plados->obt_cliente($_SESSION['idCliente']);
        }
        if (!isset($_SESSION['cart'])) {
            redirect('productos');
        }
        if (sizeof($_SESSION['cart']) == 0) {
            redirect('productos');
        }

        if (!isset($_SESSION["datosFactura"])) {
            $_SESSION["datosFactura"] = [];
        }

        $datos['usuario'] = $usuario;
        $datos['factura'] = $_SESSION["datosFactura"];
        $datos['cuenta']  = $this->m_stripe->obtCuenta();

        $head['title'] = "Datos del cliente";
        $this->load->view('eco/_head', $head);
        $this->load->view('eco/_menu');
        $this->load->view('eco/pages/datos', $datos);
        $this->load->view('eco/_footer');
    }

    // Guarda los datos del cliente, paso 2 del proceso de compra:
    function guardar_datos()
    {
        $error = false;

        // Validaciones:
        if (!$this->input->post('nombre') || empty($this->input->post('nombre'))) {
            $error = "Es necesario indicar tu nombre completo.";
        } else if (!$this->input->post('correo') || !filter_var(trim($this->input->post('correo')), FILTER_VALIDATE_EMAIL)) {
            $error = "Es necesario indicar una cuenta de correo válida.";
        } else if (!$this->input->post('Calle') || empty($this->input->post('Calle'))) {
            $error = "Es necesario indicar el nombre de la calle para entrega.";
        } else if ((!$this->input->post('NumExterno') || empty($this->input->post('NumExterno'))) &&  (!$this->input->post('NumInterno') || empty($this->input->post('NumInterno')))) {
            $error = "Es necesario indicar el número exterior o interior para identificar el domicilio de entrega.";
        } else if (!$this->input->post('telefono') || empty($this->input->post('telefono')) || !is_numeric($this->input->post('telefono'))) {
            $error = "Es necesario indicar un número de teléfono válido para ponernos en contacto.";
        } else if (!$this->input->post('cp') || empty($this->input->post('cp'))) {
            $error = "Es necesario indicar el código postal para identificar el domicilio de entrega.";
        } else if (!$this->input->post('estado') || empty($this->input->post('estado'))) {
            $error = "Es necesario seleccionar un estado para identificar el domicilio de entrega.";
        } else if (!$this->input->post('ciudad') || empty($this->input->post('ciudad'))) {
            $error = "Es necesario indicar un municipio para identificar el domicilio de entrega.";
        } else if (!$this->input->post('colonia') || empty($this->input->post('colonia'))) {
            $error = "Es necesario indicar la colonia para identificar el domicilio de entrega.";
        }

        // Validación de datos de facturación
        if (!$error && $this->input->post('facturar')) {
            if (!$this->input->post('fiscal-name') || empty($this->input->post('fiscal-name'))) {
                $error = "Es necesario indicar el nombre fiscal para facturación.";
            } else if (!$this->input->post('fiscal-rfc') || empty($this->input->post('fiscal-rfc'))) {
                $error = "Es necesario indicar el RFC.";
            } else if (!$this->input->post('fiscal-email') || !filter_var(trim($this->input->post('fiscal-email')), FILTER_VALIDATE_EMAIL)) {
                $error = "Es necesario indicar una cuenta de correo válida para hacer llegar la factura.";
            } else if (!$this->input->post('fiscal-address') || empty($this->input->post('fiscal-address'))) {
                $error = "Es necesario indicar un domicilio fiscal para facturación.";
            } else if (!$this->input->post('fiscal-usage') || empty($this->input->post('fiscal-usage'))) {
                $error = "Es necesario indicar el uso de la factura.";
            }
        }

        if (!$error) {
            $cliente = array(
                'nombre'         => $this->input->post('nombre'),
                'aPaterno'        => $this->input->post('aPaterno'),
                'aMaterno'        => $this->input->post('aMaterno'),
                'correo'        => trim($this->input->post('correo')),
                'celular'        => $this->input->post('celular'),
                'telefono'        => $this->input->post('telefono')
            );

            $this->m_plados->guardar_cliente($cliente);
            $idCliente = $this->db->insert_id();

            $direccion = array(
                'cliente'        => $idCliente,
                'calle'         => $this->input->post('Calle'),
                'numExterno'    => $this->input->post('NumExterno'),
                'numInterno'     => $this->input->post('NumInterno'),
                'edificio'        => $this->input->post('edificio'),
                'estado'        => $this->input->post('estado'),
                'cp'            => $this->input->post('cp'),
                'ciudad'        => $this->input->post('ciudad'),
                'colonia'        => $this->input->post('colonia'),
                'referencias'    => $this->input->post('referencias')
            );
            $this->m_plados->guardar_direccion($direccion);

            $_SESSION['idCliente'] = $idCliente;


            // Datos de Facturación:
            if ($this->input->post('fiscal-name') && !empty($this->input->post('fiscal-name'))) {
                $array = array(
                    'nombre'    => $this->input->post('fiscal-name'),
                    'rfc'         => $this->input->post('fiscal-rfc'),
                    'correo'    => trim($this->input->post('fiscal-email')),
                    'direccion' => $this->input->post('fiscal-address'),
                    'uso'         => $this->input->post('fiscal-usage'),
                    //'facturar'  => $this->input->post('facturar'),
                    'cliente'    => $_SESSION['idCliente']
                );

                //$datos = array_filter($array);

                $_SESSION["datosFactura"] = $array;
                $this->m_plados->datos_factura($array);
                $_SESSION['factura'] = $this->db->insert_id();
            }
            redirect('checkout');
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => $error]);
        }
    }

    function datos_factura()
    {
        $array = array(
            'nombre'    => $this->input->post('nombre'),
            'rfc'         =>     $this->input->post('rfc'),
            'correo'    => $this->input->post('correo'),
            'direccion' => $this->input->post('direccion'),
            'cliente'    => $_SESSION['idCliente']
        );

        $datos = array_filter($array);

        if (sizeof($datos) == 5) {
            $this->m_plados->datos_factura($datos);
            $_SESSION['factura'] = $this->db->insert_id();
            $msg = ' Datos Guardados';
        } else {
            $msg = "debe llenar todos los datos";
        }

        echo json_encode($msg);
    }



    function checkout()
    {
        $usuario = $this->m_plados->obt_cliente($_SESSION['idCliente']);
        $datos['usuario'] = $usuario;
        include_once 'application/libraries/stripe-php/init.php';

        $carrito = '';
        $sub = 0;
        $cantProductos = 0;
        $p = '';

        if (isset($_SESSION['cart'])) {
            $datos['carrito'] = $_SESSION['cart'];
            $carrito = $_SESSION['cart'];
        } else {
            $datos['carrito'] = null;
            redirect('carrito');
        }

        foreach ($carrito as $c) {
            $subtotal = $c['cantidad'] * $c['precio'];
            $cantProductos = $cantProductos + $c['cantidad'];
            $sub = $sub + $subtotal;

            $p = $p . $c['descripcion'] . ' ';
        }

        $total = round(number_format($sub, 2, '.', ''));

        \Stripe\Stripe::setApiKey($this->stripekey);

        $session = \Stripe\Checkout\Session::create(
            [
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'name' => 'PEDIDO EN PLADOS MX',
                    //'description' => 'Comfortable cotton t-shirt',
                    //'images' => ['http://plados.koberdesarrollo.com/src/img/'.$carrito[0]['foto']],
                    'amount' => $total * 100,
                    'currency' => 'mxn',
                    'quantity' => 1,
                ]],
                'success_url' => base_url() . 'plados/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => base_url() . 'plados/checkout',
            ]
        );

        $stripeSession = array($session);
        $sessId = ($stripeSession[0]['id']);
        $datos['sesion'] = $sessId;
        $head['title'] = "Checkout";

        $this->load->view('eco/_head', $head);
        //$this->load->view('_menuLateral1');
        $this->load->view('eco/_menu');
        $this->load->view('eco/pages/checkout', $datos);
        $this->load->view('eco/_footer');
    }

    /**
     * Funcion de respaldo, ignorar en el futuro
     * 
     * Permite almacenar los detalles de la compra 
     * 
     * @return Json
     */
    public function collect_details()
    {

        $carrito = '';
        $sub = 0;
        $cantProductos = 0;
        $p = '';

        if (isset($_SESSION['cart'])) {
            $datos['carrito'] = $_SESSION['cart'];
            $carrito = $_SESSION['cart'];
        } else {
            $datos['carrito'] = null;
            redirect('carrito');
        }

        foreach ($carrito as $c) {
            $subtotal = $c['cantidad'] * $c['precio'];
            $cantProductos = $cantProductos + $c['cantidad'];
            $sub = $sub + $subtotal;

            $p = $p . $c['descripcion'] . ' ';
        }

        $total = round(number_format($sub, 2, '.', ''));


        try {

            // vendor using composer
            include_once 'application/libraries/stripe-php/init.php';
            \Stripe\Stripe::setApiKey($this->stripekey);
            header('Content-Type: application/json');

            // retrieve json from POST body
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);

            $intent = Stripe\PaymentIntent::create(
                [
                    'payment_method' => $json_obj->payment_method_id,
                    'amount' => $total * 100,
                    'currency' => 'mxn',
                    'payment_method_options' => [
                        'card' => [
                            'installments' => [
                                'enabled' => true
                            ]
                        ]
                    ],
                ]
            );
            echo json_encode(
                [
                    'intent_id' => $intent->id,
                    'available_plans' => $intent->payment_method_options->card->installments->available_plans
                ]
            );
        } catch (\Stripe\Exception\CardException $e) {
            // "e" contains a message explaining why the request failed
            echo 'Card Error Message is:' . $e->getError()->message . '';
            echo json_encode(
                [
                    'error_message' => $e->getError()->message
                ]
            );
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            echo 'Invalid Parameters Message is:' . $e->getError()->message . '
		';
            echo json_encode(
                [
                    'error_message' => $e->getError()->message
                ]
            );
        }
    }

    /**
     * Funcion de Respaldo, ignorar mas adelante
     * 
     * Confirma el pago desde Stripe
     * 
     * @return Json
     */
    function confirmarPago()
    {

        try {
            $confirm_data = '';
            // vendor using composer
            include_once 'application/libraries/stripe-php/init.php';
            \Stripe\Stripe::setApiKey($this->stripekey);
            header('Content-Type: application/json');

            // retrieve json from POST body
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str, true);

            if (isset($json_obj['selected_plan'])) {
                $confirm_data = ['payment_method_options' =>
                [
                    'card' => [
                        'installments' => [
                            'plan' => $json_obj['selected_plan']
                        ]
                    ]
                ]];
            }

            $intent = \Stripe\PaymentIntent::retrieve(
                $json_obj['payment_intent_id']
            );
            $intent->confirm($params = $confirm_data);
            //echo json_encode(['status' => $intent->status,]);
            if ($intent->status == 'succeeded') {
                $this->success2($json_obj['payment_intent_id'], $intent->status);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {

            //echo 'Card Error Message is:' . $e->getError()->message . '';
            echo json_encode(
                [
                    'status' => $intent->status,
                    'error_message' => $e->getError()->message
                ]
            );
        }
    }

    function success2($payment, $estatus)
    {
        $carrito = $_SESSION['cart'];
        $sub = 0;
        $cantProductos = 0;
        $idPago = $payment;

        foreach ($carrito as $c) {
            $subtotal = $c['cantidad'] * $c['precio'];
            $cantProductos = $cantProductos + $c['cantidad'];
            $sub = $sub + $subtotal;
        }
        $total = round(number_format($sub * 100, 2, '.', ''));
        $pedido = array(
            'cliente'         => $_SESSION['idCliente'],
            'sesCompra'        => 'chk',
            'idPago'        => $idPago,
            'cantArticulos'    => $cantProductos,
            'cuenta'        => $total
        );

        $this->m_plados->guardaPedido($pedido);
        $idPedido = $this->db->insert_id();
        $x = 0;
        foreach ($carrito as $c) {
            $carrito[$x]['pedido'] = $idPedido;
            $this->m_plados->articulo_pedido($carrito[$x]);
            $x++;
        }
        //si hay datos de facturacion...
        if (isset($_SESSION['factura'])) {
            $this->m_plados->ingresar_factura($idPedido, $_SESSION['factura']);
        }

        $_SESSION['cart'] = null;
        $this->correo_cliente($idPedido);
        $this->correo_ventas($idPedido);
        //redirect('exito/' . $idPedido);

        echo json_encode(
            [
                'status' => $estatus,
                'idPedido' => $idPedido
            ]
        );

        //    echo "ERROR, ESTE PEDIDO YA ESTA REGISTRADO";
        //    $this->checkout();
    }

    /**
     * Muestra la vista de compra satisfactoria!
     * 
     * @return view
     */
    function exito()
    {
        $pedido = $this->uri->segment(2);
        $datos['pedido'] = $this->m_plados->obt_pedido($pedido);

        // Obtenemos los productos del pedido:
        $items = $this->db->query("SELECT * FROM tb_articulosPedidos WHERE pedido = " . $datos["pedido"]->id_pedido . "")->result();
        $datos['pedido']->items = $items;

        $head['title']    = "Pedido Procesado con exito";

        $this->load->view('eco/_head', $head);
        $this->load->view('eco/_menu');
        $this->load->view('eco/pages/exito', $datos);
        $this->load->view('eco/_footer');
    }


    function correo_cliente($id)
    {
        $horario = $this->m_plados->hora_actual();
        $saludo = '';

        if ($horario <= '11:59:59') {
            $saludo = 'Buenos días';
        } elseif ($horario <= '19:59:59') {
            $saludo = 'Buenas tardes';
        } elseif ($horario <= '23:59:59') {
            $saludo = 'Buenas noches';
        }

        function addBizDays($start, $add)
        {
            $start = strtotime($start);
            $d = min(date('N', $start), 5);
            $start -= date('N', $start) * 24 * 60 * 60;
            $w = (floor($add / 5) * 2);
            $r = $add + $w + $d;
            return date('Y-m-d', strtotime(date("Y-m-d", $start) . " +$r day"));
        }

        $data['id']            = $id;
        $data['saludo']        = $saludo;
        $data['pedido']         = $this->m_plados->obt_pedido($id);
        $data['carrito']        = $this->m_plados->obt_productosPedidos($id);
        $data['factura']        = $this->m_plados->buscar_datosFactura($id);
        $data['total'] = 0;
        $data['items'] = 0;
        foreach ($data['carrito'] as $item) {
            $data['total'] += ($item->precio * $item->cantidad);
            $data['items'] += $item->cantidad;
        }


        $data['fecha_compra'] = date_format(date_create($data['pedido']->fecha_pedido), 'd M Y | H:i');
        $data['fecha_envio'] = date_format(date_create(addBizDays($data['pedido']->fecha_pedido, 3)), 'd M Y');

        $msg = $this->load->view('correos/order-redesign', $data, true);

        $this->load->library('email');
        $this->email->from('ventas@plados.mx', 'Plados');
        $this->email->to($data['pedido']->correo);
        $this->email->bcc('vflores@kober.com.mx', 'julio@yayestudio.com', 'giovana@yayestudio.com', 'msalgado@kober.com.mx', 'anduryn@gmail.com');
        $this->email->subject('COMPRAS PLADOS');
        $this->email->message($msg);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    function correo_ventas($pedido)
    {
        /*
        $horario = $this->m_plados->hora_actual();
        $saludo = '';

        if ($horario <= '11:59:59') {
        $saludo = 'Buenos días';
        } elseif ($horario <= '19:59:59') {
        $saludo = 'Buenas tardes';
        } elseif ($horario <= '23:59:59') {
        $saludo = 'Buenas noches';
        }

        $datos['pedido']         = $this->m_plados->obt_pedido($pedido);
        $datos['carrito']        = $this->m_plados->obt_productosPedidos($pedido);
        $datos['factura']        = $this->m_plados->buscar_datosFactura($pedido);
        $datos['saludo']         = $saludo;

        //  $this->load->view('_head');
        $msg = $this->load->view('correos/nueva_venta', $datos, true);

        $this->load->library('email');
        $this->email->from('ventas@plados.mx', 'Plados');
        $this->email->to('vflores@kober.com.mx');
        $this->email->bcc('julio@yayestudio.com','giovana@yayestudio.com','msalgado@kober.com.mx');
        $this->email->subject('COMPRAS PLADOS');
        $this->email->message($msg);
        $this->email->set_mailtype('html');
        $this->email->send();

        //echo $this->email->print_debugger();
        */
    }

    // Yay! Estudio: Puntos de Venta
    function puntosVenta()
    {
        $data = [];

        $head['title']    = "Puntos de Venta";
        $this->load->view('eco/_head', $head);
        $this->load->view('eco/_menu');
        $this->load->view('eco/pages/puntos-de-venta.php', $data);
        $this->load->view('eco/_footer');
    }


    // Yay! Estudio: Forma de Contacto
    function contacto()
    {
        header('Content-Type: application/json');

        $errors = [];

        $fields = $_POST;

        // Validaciones ###
        if (!isset($_POST["name"]) || empty($_POST["name"])) {
            $errors[] = "Es necesario indicar tu nombre.";
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Es necesario inidicar una cuenta de correo válida.";
        }

        if (!isset($_POST["branch"]) || empty($_POST["branch"])) {
            $errors[] = "Es necesario indicar la sucursal más cercana.";
        }

        if (!isset($_POST["phone"]) || empty($_POST["phone"])) {
            $errors[] = "Es necesario indicar número telefónico válido.";
        }

        if (!isset($_POST["message"]) || empty($_POST["message"])) {
            $errors[] = "Es necesario escribir un mensaje.";
        }


        // Google reCaptcha:
        $fields = array(
            'secret'            => '6LfApN0ZAAAAALMJUV7c5qqNxVWTh92GjIh6ybQ5',
            'response'            => $_POST['g-recaptcha-response']
        );
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $array = json_decode($result);

        // Catch the suspicious one:
        if (!$array->success || empty($array->success) || $array->score < 0.6) {
            $errors[] = $array->score . "Lo sentimos, la seguridad del sitio ha detectado esta interacción como insegura, pro favor intenta un poco más tarde.";
        }

        if (count($errors) == 0) {

            $data = [];
            $template = $this->load->view('correos/contacto', $_POST, true);

            $this->load->library('email');
            $this->email->from('ventas@plados.mx', 'plados.mx');
            $this->email->to('ventas@plados.mx');
            $this->email->bcc('julio@yayestudio.com', 'giovana@yayestudio.com', 'msalgado@kober.com.mx', 'vflores@kober.com.mx');
            $this->email->subject('CONTACTO PLADOS');
            $this->email->message($template);
            $this->email->set_mailtype('html');
            $this->email->send();

            // Send mail!
        } else {
            echo json_encode(array("errors" => $errors));
        }
    }


    // Yay! Estudio Oct, 2021 - Obtiene el contenido del carrito en formato JSON:
    public function loadCart()
    {
        $cart = [];
        $items = [];
        $total = 0;
        $cart['items'] = $_SESSION["cart"];
        foreach ($_SESSION["cart"] as $item) {
            $total += $item['cantidad'] * $item['precio'];
        }
        $cart['total'] = number_format($total, 2);
        $cart['ntotal'] = $total;
        echo json_encode($cart);
    }



    // Yay! Estudio
    // 21 de Mayo 2021: Funciones para la implementación de promociones temporales:

    // 0) Transfiere los precios actuales a la columna _precio,
    // Los cuales nos servirán para recuperarlos una vez que la promo termine:
    public function backupPrices()
    {
        die("Watch out!! This might overwritte original prices. (Protected by me from the past, you are welcome)");
        /*
        $products = $this->db->query("SELECT * FROM tb_cat_producto WHERE 1")->result();
        foreach($products as $product){
        # Update:
        $this->db->query("UPDATE tb_cat_producto SET `_precio` = ".$product->precio." WHERE id_catProducto = ".$product->id_catProducto."");
        }
        */
    }


    // 1) Aplica los precios con promoción.
    // Hash: 2a69eac9-b3fb-4cf9-a71c-04f5fdd84ed2
    public function applyPromo()
    {
        $discount = 10; // Porcentaje de Descuento;
        /*
        $products = $this->db->query("SELECT * FROM tb_cat_producto WHERE 1")->result();
        foreach($products as $product){
        $newprice = ($product->_precio - (($product->_precio * $discount) / 100));
        $this->db->query("UPDATE tb_cat_producto SET `precio` = ".$newprice." WHERE id_catProducto = ".$product->id_catProducto."");
        }

        $this->load->library('email');
        $this->email->from('ventas@plados.mx', 'plados.mx');
        $this->email->to('giovana@yayestudio.com');
        $this->email->bcc('anduryn@gmail.com');
        $this->email->subject('Plados.mx CronJob - Promo Activate');
        $this->email->message('<b>Promoción Activada en Plados-Redesign</b><p>Esto es una prueba de notificación automatizada informando que la promoción ha sido <b style="color:green;">ACTIVADA</b>.<hr/> Timestamp: <b>'.date("Y-m-d H:i:s").'</b></p>');
        $this->email->set_mailtype('html');
        $this->email->send();

        die("Promoción del <b>".$discount."%</b> de descuento  <b>APLICADA</b>");
        */
    }


    // 2) Resetea los precios de promoción a su valor normal.
    // Hash: 2a69eac9-b3fb-4cf9-a71c-04f5fdd84ed2
    public function removePromo()
    {
        $products = $this->db->query("SELECT * FROM tb_cat_producto WHERE 1")->result();
        foreach ($products as $product) {
            $this->db->query("UPDATE tb_cat_producto SET `precio` = " . $product->_precio . " WHERE id_catProducto = " . $product->id_catProducto . "");
        }

        $this->load->library('email');
        $this->email->from('ventas@plados.mx', 'plados.mx');
        $this->email->to('giovana@yayestudio.com');
        $this->email->bcc('anduryn@gmail.com');
        $this->email->subject('Plados.mx CronJob - Promo Deactivate');
        $this->email->message('<b>Promoción Removida en Plados-Redesign</b><p>Esto es una prueba de notificación automatizada informando que la promoción ha sido <b style="color:red;">DESACTIVADA</b>.<hr/> Timestamp: <b>' . date("Y-m-d H:i:s") . '</b></p>');
        $this->email->set_mailtype('html');
        $this->email->send();

        die("Promoción <b>REMOVIDA</b>");
    }



    // Yay! Estudio 09 de Nov, 2021 - Carga de producto (ya que no existe opción para hacerlo desde el admin)
    public function loadProducts()
    {
        $products = [
            [
                'titulo' => 'Tabla de picar de madera',
                'sku' => 'TT-TAGL44L',
                'modelo' => 'TT-TAGL44L',
                'precio' => 999,
            ],
            [
                'titulo' => 'Tabla de picar de HPL',
                'sku' => 'TT-COPHPLX1-ARDL',
                'modelo' => 'TT-COPHPLX1-ARDL',
                'precio' => 1407,
            ],
            [
                'titulo' => 'Canastilla Escurridor',
                'sku' => 'TT-SPCESINXL',
                'modelo' => 'TT-SPCESINXL',
                'precio' => 949,
            ],
            [
                'titulo' => 'Contra canasta de lujo',
                'sku' => 'LL-CC-COPPILT10L',
                'modelo' => 'LL-CC-COPPILT10L',
                'precio' => 215,
            ],
        ];


        foreach ($products as $product) {
            $exists =  $this->db->query("SELECT * FROM tb_cat_producto WHERE sku = '" . $product['sku'] . "'")->first();
            if ($exists) {
                $this->db->query("UPDATE tb_cat_producto SET `precio` = " . $product->_precio . ", `precio` = " . $product->_precio . ", `precio` = " . $product->_precio . " WHERE id_catProducto = " . $exists->id_catProducto . "");
            } else {
            }
        }
    }
}
