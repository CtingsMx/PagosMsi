<?php

class m_correos extends CI_Model
{
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
		$this->email->bcc('vflores@kober.com.mx', 'julio@yayestudio.com', 'giovana@yayestudio.com', 'msalgado@kober.com.mx', 'anduryn@gmail.com', 'daniel.mora@ctings.com');
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
}
