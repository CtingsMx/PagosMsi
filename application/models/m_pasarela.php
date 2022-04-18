<?php

class m_pasarela extends CI_Model
{
    public function __construct()
    {
        $this->url = "http://148.244.194.93/PagosMsi/server/";

    }

    /**
     * Regresa el Url del server
     *
     * @param string $funcion posible funcion a anexar
     *
     * @return void
     */
    public function generaUrlServer($funcion)
    {
        return "{$this->url}";
    }

    /**
     * Envia una peticion al servidor de aplicacion solicitando
     * la validacion de una compra
     *
     * @param string $id identificador de la venta
     *
     * @return Json
     */
    public function validaID($id)
    {
        $data = file_get_contents("{$this->url}validaID?folio={$id}");
        return json_decode($data, true);
    }

    /**
     * Solicita al servidor informacion de un movid en especifico
     *
     * @param string $id movid de la venta
     *
     * @return object
     */
    public function obtVenta($id)
    {
        $data = file_get_contents("{$this->url}getVenta?movid={$id}");
        return json_decode($data, true);
    }

    /**
     * Genera un objeto valido para realizar la peticion a la api Openpay
     *
     * @param object $venta objeto con los datos de la venta
     *
     * @return array
     */
    public function generarCuenta($venta)
    {
        $total = $venta->ventaTotal;

        if ($total < 1000) {
            $total = 3000;
        }

        $pedido = array(
            'articulo' => 1,
            'cantidad' => 1,
            'precio' => $total,
            'descripcion' => 'KOBER PRODUCTO',
            'color' => 'NEGRO',
            'foto' => '123',
        );

        $_SESSION['cart'][0] = $pedido;

    }

    /**
     * Retorna los conceptos de la cuenta del usuario
     *
     * Revisa la variable de sesion del carrito y realiza los
     * calculos necesarios para obtener el total final de la cuenta
     *
     * @var int $cantProductos almacena la cantidad total de Productos
     * @var decimal $sub almacena el subtotal de todos los productos
     * @var decimal $almacena los descuentos
     * @var decimal $almacena el costo del envío
     * @var decimal $total almacena el total de la cuenta
     *
     * @return object Objeto con el desglose de la cuenta     *
     */
    public function obtCuenta()
    {
        $cantProductos = 0;
        $sub = 0;
        $puntos = 0;
        $envio = 0;
        $total = 0;

        foreach ($_SESSION['cart'] as $c) {
            $subtotal = $c['cantidad'] * $c['precio'];
            $cantProductos = $cantProductos + $c['cantidad'];
            $sub = $sub + $subtotal;
        }

        if (isset($_SESSION['descuento'])) {
            $puntos = $_SESSION['descuento'];
        }

        if (-$puntos >= $sub) {
            $puntos = -$sub;
        }

        if ((int) ($sub - (-$puntos)) < 999) {
            $envio = 150;
        }

        $total = $sub + $puntos + $envio;
        //  die(var_dump($puntos));

        $total = $sub + $puntos + $envio;

        $cuenta = array(
            'subtotal' => $sub,
            'puntos' => $puntos,
            'envio' => $envio,
            'total' => $total,
            'cantProductos' => $cantProductos,
        );

        return $cuenta;
    }

    /**
     * Envia al Servidor la venta para almacenarla en la
     *
     * @param string $id    id de pago de Openpay  
     * @param string $movid id de la venta
     * 
     * @return boolean
     */
    public function enviaPagoServer($id, $movid)
    {

        $data = file_get_contents("{$this->url}guardaPagoValidado?idOpen={$id}&idVenta=${$movid}");
        $data = json_decode($data);

        return $data->ok;
    }

    public function fecha_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        return $fecha;
    }

    public function hora_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $hora = date("H:i:s");
        return $hora;
    }

    public function fecha_text($datetime)
    {
        if ($datetime == "0000-00-00 00:00:00") {
            return "Fecha indefinida";
        } else {

            $dia = explode(" ", $datetime);
            $fecha = explode("-", $dia[0]);
            if ($fecha[1] == 1) {
                $mes = 'enero';
            } else if ($fecha[1] == 2) {
                $mes = 'febrero';
            } else if ($fecha[1] == 3) {
                $mes = 'marzo';
            } else if ($fecha[1] == 4) {
                $mes = 'abril';
            } else if ($fecha[1] == 5) {
                $mes = 'mayo';
            } else if ($fecha[1] == 6) {
                $mes = 'junio';
            } else if ($fecha[1] == 7) {
                $mes = 'julio';
            } else if ($fecha[1] == 8) {
                $mes = 'agosto';
            } else if ($fecha[1] == 9) {
                $mes = 'septiembre';
            } else if ($fecha[1] == 10) {
                $mes = 'octubre';
            } else if ($fecha[1] == 11) {
                $mes = 'noviembre';
            } else if ($fecha[1] == 12) {
                $mes = 'diciembre';
            }

            $hora = explode(":", $dia[1]);

            $time = $hora[0] . ":" . $hora[1] . " Hrs";

            $fecha2 = $fecha[2] . " " . $mes . " " . $fecha[0];
            return $fecha2 . " a las " . $time;
        }
    }
}
