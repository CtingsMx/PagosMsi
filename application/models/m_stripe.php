<?php

/**
 * Clase para realizar cambios en stripe
 * @category Pagos
 * @author   Daniel Mora <daniel.mora@ctings.com>
 */
class m_stripe extends CI_Model
{

    public function db()
    {
        $DB2 = $this->load->database('firma', true);

        return $DB2->get('KeySucursal')->result();

    }

    public function generarCuenta($venta)
    {

        $pedido = array(
            'articulo' => 1,
            'cantidad' => 1,
            'precio' => $venta->VentaTotal,
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
     * Valida y modifica un codigo de promocion
     * @param object $codigo
     *
     * @return int
     */
    public function aplicaCodigo($codigo)
    {
        if (!$codigo->active) {
            return false;
        }

        $_SESSION['promoCode'] = $codigo->id;

        $cuenta = $this->obtCuenta();

        if ($codigo->coupon->percent_off) {
            $porcentaje = $codigo->coupon->percent_off / 100;
            $descuento = $cuenta['subtotal'] * $porcentaje;
            $_SESSION['descuento'] = -$descuento;
        }

        return true;
    }

    public function formateaEnvio($usuario)
    {

        $colonia = $usuario->numInterno;
        if ($colonia != '') {
            $colonia .= ', ';
        }
        $colonia .= $usuario->colonia;

        $line1 = "{$usuario->calle} {$usuario->numExterno}";
        $line2 = $colonia;
        $ciudad = $usuario->ciudad;
        $estado = $usuario->estado;
        $cp = $usuario->cp;

        $data = array(
            'name' => $usuario->nombre,
            'address' => [
                'line1' => $line1,
                'line2' => $line2,
                'city' => $ciudad,
                'state' => $estado,
                'postal_code' => $cp,
            ],
        );

        return $data;
    }

    public function guardarRespuesta($pago)
    {
        $this->db->insert('respuestaPagoMSI', $pago);
    }
}
