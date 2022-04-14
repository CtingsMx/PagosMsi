<?php

use PHP_CodeSniffer\Reports\Json;

class m_pasarela extends CI_Model
{
    public function __construct()
    {
        $this->url = "http://148.244.194.93/PagosMsi/server/";
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

    public function obtVenta($id)
    {
        $data = file_get_contents("{$this->url}getVenta?movid={$id}");
        return json_decode($data, true);   
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
