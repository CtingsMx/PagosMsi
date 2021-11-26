<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('m_seguridad', "", TRUE);
		$this->load->model('m_usuario', "", TRUE);
		$this->load->model('m_admin', "", TRUE);
		$this->load->model('m_correos', "", TRUE);
		$this->load->model('m_plados', "", TRUE);

		$ci = get_instance();
		$this->ftp_ruta = $ci->config->item("f_ruta");
		$this->dir = $ci->config->item("oficios");
	}

	public function index()
	{
		redirect('acceso');
	}

	function editarDescripcion()
	{
		$texto 	= $this->input->post('texto');
		$id 			= $this->input->post('id');
		$this->m_admin->editar_descripcion($id, $texto);

		echo json_encode($texto);
	}

	function editarPrecio()
	{
		$precio = $this->input->post('precio');
		$id = $this->input->post('id');

		$this->m_admin->editar_precio($id, $precio);

		echo json_encode($precio);
	}

	function subir_fotos()
	{
		$id = $this->input->post('id');
		$modelo = $this->input->post('modelo');
		$idColor = $this->input->post('idColor');
		if ($_FILES['fprincipal']['name'] != "") {
			$this->subir_foto($id, $modelo, $idColor);
		}

		if ($_FILES['galeria']['name'] != "") {
			$this->subir_adjuntos($id, $modelo, $idColor);
		}

		redirect('admin/editar_producto/' . $id);
	}



	function subir_adjuntos($id, $modelo, $idColor)
	{

		for ($i = 0; $i < count($_FILES["galeria"]["name"]); $i++) {
			if ($_FILES['galeria']['name'][$i] != "") {


				$x = $i + 1;
				$origen = $_FILES["galeria"]["tmp_name"][$i];
				$ext = explode('.', $_FILES['galeria']['name'][$i]);
				$ext = $ext[count($ext) - 1];
				$ruta = $modelo . '_' . $idColor . '_' . $x . '.' . $ext;
				move_uploaded_file($origen, $this->ftp_ruta . 'src/images/shop/productos/' . $ruta);

				$attach = array(
					'id_producto' 	=> $id,
					'ruta'			=> $ruta,
					'x'				=> $x,
					'ext'			=> $ext
				);

				$this->m_admin->subir_galeria($attach);
			}
		}
	}

	function subir_foto($id, $modelo, $idColor)
	{

		########## SCRIPT PARA SUBIR LA PORTADA ###########################
		if ($_FILES['fprincipal']['name'] != "") {
			$this->load->library('image_lib');
			$ext = explode('.', $_FILES['fprincipal']['name']);
			$ext = $ext[count($ext) - 1];
			$img = $modelo . "_" . $idColor;
			move_uploaded_file($_FILES['fprincipal']['tmp_name'], $this->ftp_ruta . 'src/images/shop/' . $img . '.' . $ext);
			$config_image['image_library'] = 'gd2';
			$config_image['source_image'] = $this->ftp_ruta . 'src/oficios/in/doc_' . $img . '.' . $ext;
			$config_image['maintain_ratio'] = true;
			$config_image['quality'] = 98;
			$this->image_lib->initialize($config_image);
			$this->image_lib->resize();
			$portada = $img . '.' . $ext;
			######### FIN DEL SCRIPT#####################################	

			$this->m_admin->subir_portada($portada, $id);
		}
	}

	function update_contactoUsr($ticket)
	{
		$reportante = $ticket['usr_reportante'];
		$update = array(
			'extension' => $ticket['ext'],
			'correo'	=> $ticket['correo']
		);
		if ($reportante != 0) {
			$this->m_usuario->editar_usuario($reportante, $update);
		}
	}

	function habilitar_galeria()
	{
		$etiqueta = '';
		$id = $this->input->post('id');
		$estatus = $this->m_admin->obt_imgGaleria($id);
		if ($estatus->activa == 1) {
			$estatus->activa = 0;
			$etiqueta = "NO VISIBLE";
		} else {
			$estatus->activa = 1;
			$etiqueta = "VISIBLE";
		}

		$this->m_admin->habilitar_galeria($id, $estatus->activa);
		echo json_encode($etiqueta);
	}

	function eliminar_galeria()
	{
		$id = $this->input->post('id');
		$this->m_admin->eliminar_galeria($id);

		echo json_encode("eliminada");
	}

	function editar_producto()
	{
		$producto = $this->uri->segment(3);
		$datos['producto'] = $this->m_admin->obt_producto($producto);
		$datos['galeria']  = $this->m_admin->obt_galeria($producto);
		$head['title'] = "Editar producto";
		$this->load->view('_encabezado', $head);
		$this->load->view('_menuLateral1');
		$this->load->view('v_editar_producto', $datos);
		$this->load->view('_footer1');
	}

	function obt_catBullets()
	{
		$bullets = $this->m_admin->obt_catBullets();
		$respuesta = '<select class="form-control" name="sBullet" id="sBullet">';

		foreach ($bullets as $b) {
			$respuesta .= '<option value="' . $b->id . '">' . $b->bullet . ' </option>';
		}
		$respuesta .= '</select>';
		echo json_encode($respuesta);
	}

	function obt_bullets()
	{
		$producto = $this->input->get('q');
		$datos  = $this->m_admin->obt_bullets($producto);
		$respuesta = '<ul class="iconlist">';

		foreach ($datos as $d) {
			$respuesta .= ' <li><a href="#dvBullets" onclick="eliminaBullet(' . $d->id . ');"><i data-toggle="tooltip" title="Eliminar Bullet" class="icon icon-line2-close" style="color:red;"></i></a> ' . $d->bullet . ' </li>';
		}

		$respuesta .= '</u>';

		echo json_encode($respuesta);
	}

	function agregar_bullet()
	{
		$etiqueta = array(
			'id_producto'	=> $this->input->post('id'),
			'id_bullet' 	=> $this->input->post('bullet')
		);

		$this->m_admin->agregar_bullet($etiqueta);

		echo json_encode("agregado");
	}

	function agregar_catBullet()
	{
		$bullet = array(
			'bullet' => $this->input->post('value')
		);

		$this->m_admin->agregar_catBullet($bullet);
		echo json_encode($this->input->post('value'));
	}

	function elimina_bullet()
	{
		$id = $this->input->post('id');
		$this->m_admin->elimina_bullet($id);
		echo json_encode("eliminado");
	}

	function modificar_titulo()
	{
		$id = $this->input->post('id');
		$titulo = $this->input->post('titulo');
		$this->m_admin->editar_titulo($id, $titulo);
		echo json_encode($titulo);
	}

	function modificar_sku()
	{
		$id = $this->input->post('id');
		$sku = $this->input->post('sku');
		$this->m_admin->editar_sku($id, $sku);
		echo json_encode($sku);
	}

	function modificar_estatusProducto()
	{
		$id = $this->input->post('id');
		$estatus = $this->input->post('estatus');
		$etiqueta = '';

		$estatus = $this->m_admin->obt_producto($id);
		if ($estatus->activo == 1) {
			$estatus->activo = 0;
			$etiqueta = "INACTIVO";
		} else {
			$estatus->activo = 1;
			$etiqueta = "ACTIVO";
		}

		$this->m_admin->modificar_estatusProducto($id, $estatus->activo);
		echo json_encode($etiqueta);
	}


	// Yay! Estudio: Maneja el status destacado true/false de los productos, 
	// esto hace que se muestren o no en el carrusel del home
	function isfeatured()
	{
		$id = $this->input->post("id");
		$checked = $this->input->post("checked");
		//$checked = ($checked == true) ? 1 : 0;
		$this->db->where('id_catProducto', $id);
		$this->db->update('tb_cat_producto', array("destacado" => $checked));

		json_encode(array("checked" => $checked));
	}






	function lista_productos()
	{
		$head['title'] = "Lista de Productos PLADOS";
		$datos['productos'] = $this->m_admin->lista_productos();
		$this->load->view('_encabezado', $head);
		$this->load->view('_menuLateral1');
		$this->load->view('listas/l_productos', $datos);
		$this->load->view('_footer1');
	}

	function seguimiento()
	{
		$folio = $this->uri->segment(3);
		$datos['folio'] 		= $folio;
		$datos['pedido'] 		= $this->m_plados->obt_pedido($folio);


		if (isset($datos["pedido"]) && is_object($datos["pedido"])) {
			$datos['carrito']		= $this->m_plados->obt_productosPedidos($folio);
			$datos['estatus']		= $this->m_admin->obt_estatus();

			$head['title'] = "Seguimiento del pedido " . $folio;

			$datos["factura"] = $this->db->query("SELECT * FROM tb_datos_factura WHERE pedido = " . $datos['pedido']->id_pedido . "")->row();

			$this->load->view('_encabezado', $head);
			$this->load->view('_menuLateral1');
			$this->load->view('seguimientoPedido', $datos);
			$this->load->view('_footer1');
		} else {
			redirect("/inicio");
		}
	}

	function cambiar_estatus()
	{
		$estatus = $this->input->post('estado');
		$pedido = $this->input->post('pedido');

		$respuesta = $this->m_admin->cambiar_estatus($estatus, $pedido);

		echo json_encode($respuesta);
	}

	function asignar_usuario()
	{
		if ($_POST['antAsignado'] == $_POST['ingeniero']) {
			$msg = '<div class="alert alert-danger"><p><i class="fa fa-close"></i>El usuario seleccionado ya esta asignado e este ticket de servicio </p></div>';
		} else {

			if ($_POST['antAsignado'] == '' or $_POST['antAsignado'] == '0') {
				$estatus = 2;
			} else {
				$estatus = 7;
			}

			$antCanal = $_POST['antCanal'];
			$notificacion = 2;
			$codigo = $this->session->userdata("codigo");
			$ingeniero = $_POST['ingeniero'];
			$folio = $_POST['folio'];
			$fecha = $this->m_ticket->fecha_actual();
			$hora = $this->m_ticket->hora_actual();
			$tg = $this->m_usuario->obt_telegramID($ingeniero);
			$usr = $this->m_usuario->obt_usuario($ingeniero);
			$canal = $usr->id_puesto;

			$this->m_ticket->asignar_usuario($folio, $ingeniero, $fecha, $hora, $estatus, $canal);
			$this->m_ticket->h_asignar_usuario($folio, $ingeniero, $fecha, $hora, $estatus, $canal);
			if ($tg != null) {
				$this->m_ticket->sendTelegram_asignado($tg, $folio);
			}

			$msg = '<div class="alert alert-success"><p><i class="fa fa-check"></i>Se ha Asignado con Exito</p></div>';
		}

		echo json_encode($msg);
	}

	function cambiar_categoria()
	{
		$categoria = $_POST['categoria'];
		$folio = $_POST['folio'];
		$antCategoria = $_POST['antCategoria'];
		$fecha = $this->m_ticket->fecha_actual();
		$hora = $this->m_ticket->hora_actual();

		$msg = new \stdClass();

		if ($categoria != $antCategoria) {
			$this->m_ticket->cambiar_categoria($folio, $categoria);
			$this->m_ticket->h_cambiar_categoria($folio, $categoria, $fecha, $hora);

			$msg->id = 1;
			$msg->mensaje = '<div class="alert alert-success"><p><i class="fa fa-check"></i> Se cambio la categoría</p></div>';
		} else {

			$msg->id = 2;
			$msg->mensaje = '<div class="alert alert-danger"><p><i class="fa fa-close"></i> Seleccionaste la categoría actual</p></div>';
		}

		echo json_encode($msg);
	}




	function insertarCat()
	{
		$titulo = $_POST['busqueda'];
		$categoria = $this->m_ticket->insertarCat_x_titulo($titulo);
		echo json_encode($categoria);
	}


	function mensaje()
	{
		$folio = $_POST['folio'];
		$mensaje = $_POST['chat'];
		$fecha = $this->m_ticket->fecha_actual();
		$hora = $this->m_ticket->hora_actual();
		$x = $this->m_ticket->obt_imagenesChat($folio);

		if ($_FILES['imgComentario']['name'] != "") {
			$ext = explode('.', $_FILES['imgComentario']['name']);
			$ext = $ext[count($ext) - 1];
			$x = $x + 1;
			$pdf = 'c' . $folio . '_' . $x;
			move_uploaded_file($_FILES['imgComentario']['tmp_name'], $this->ftp_ruta . 'src/oficios/att/' . $pdf . '.' . $ext);
			$nImg = $pdf . '.' . $ext;
			$this->resize($nImg);
		} else {
			$nImg = null;
		}

		$this->m_ticket->mensaje($folio, $mensaje, $fecha, $hora, $nImg);
		//$this->m_ticket->sendTelegram_chat($folio, $mensaje);

		redirect(base_url() . 'index.php?/ticket/seguimiento/' . $folio);
	}

	function resize($nImg)
	{
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'src/oficios/att/' . $nImg;
		$config['new_image'] = 'src/oficios/att/' . $nImg;
		$config['maintain_ratio'] = TRUE;
		$config['create_thumb'] = FALSE;
		$config['width'] = 800;
		$config['height'] = 800;

		$this->image_lib->initialize($config);

		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors('', '');
		}
	}

	function mandar_telegram()
	{
		$this->m_ticket->SendTelegram1();
	}



	# Yay! Estudio: Listado de banners: home y promociones
	function banners()
	{
		$head['title'] = "Administración de Banners :: PLADOS";
		$datos['banners'] = $this->db->query("SELECT * FROM tb_banners WHERE 1")->result();

		$this->load->view('_encabezado', $head);
		$this->load->view('_menuLateral1');
		$this->load->view('listas/l_banners', $datos);
		$this->load->view('_footer1');
	}


	function banner($id)
	{
		header('Content-Type: application/json');
		$banner = $this->db->query("SELECT * FROM tb_banners WHERE id = ?", $id)->row();
		echo json_encode($banner);
	}


	function bannerDelete($id)
	{
		$banner = $this->db->query("SELECT * FROM tb_banners WHERE id = ?", $id)->row();
		@unlink($this->ftp_ruta . $banner->banner);
		$this->db->where("id", $id)->delete("tb_banners");
		header("Location: /admin/banners");
	}

	function submitBanner()
	{
		header('Content-Type: application/json');

		$id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : false;
		unset($_POST["id"]);

		$errors = [];

		$fields = $_POST;

		### Validaciones ###
		# Valida el archivo si se ha seleccionado alguno:
		$file = $_FILES["banner"];
		$upload = false;
		if ($file && $file["size"] > 0) {
			$file = $_FILES["banner"];
			$ftypes = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
			$ext = pathinfo($file["name"], PATHINFO_EXTENSION);

			if (!in_array($ext, $ftypes))
				$errors[] = "El archivo seleccionado no parece ser una imagen";

			else if ($file["size"] > 3000000)
				$errors[] = "El archivo es demasiado pesadao, los archivos óptimos no deben pesar más de 1MB";

			else
				$upload = true;
		}

		if (!isset($_POST["titulos"]) || empty($_POST["titulos"]))
			$errors[] = "Es necesario indicar los títulos del banner.";

		if ((!isset($_POST["seccion"]) || empty($_POST["seccion"])))
			$errors[] = "Es necesario indicar la sección donde se muestra el banner.";

		if ((!isset($_POST["fondo"]) || empty($_POST["fondo"])))
			$errors[] = "Es necesario indicar el fondo predominante de la imagen.";

		if ((!isset($_POST["boton"]) || empty($_POST["boton"])))
			$errors[] = "Es necesario indicar el texto del botón.";

		if ((!isset($_POST["link"]) || empty($_POST["link"])))
			$errors[] = "Es necesario indicar el link del botón.";

		function UUID()
		{
			return sprintf(
				'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0x0fff) | 0x4000,
				mt_rand(0, 0x3fff) | 0x8000,
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff)
			);
		}


		if (count($errors) == 0) {
			if ($upload) {
				$uuid = UUID();
				$banner = 'src/images/banners/' . $uuid . "." . $ext;
				@move_uploaded_file($file['tmp_name'], $this->ftp_ruta . $banner);
				$fields["banner"] = $banner;
			}

			if (!$id) {
				// Insert:
				$this->db->insert('tb_banners', $fields);
			} else {
				// Update:
				$this->db->where('id', $id)->update('tb_banners', $fields);
			}
		} else {
			echo json_encode(array("errors" => $errors));
		}
	}

	# Yay! Estudio: Testimoniales:
	function testimoniales()
	{
		$head['title'] = "Administración de Testimoniales :: PLADOS";

		$datos['testimonials'] = $this->db->query("SELECT * FROM tb_testimonials WHERE 1")->result();

		$this->load->view('_encabezado', $head);
		$this->load->view('_menuLateral1');
		$this->load->view('listas/l_testimonials', $datos);
		$this->load->view('_footer1');
	}

	function testimonial($id)
	{
		header('Content-Type: application/json');
		$item = $this->db->query("SELECT * FROM tb_testimonials WHERE id = ?", $id)->row();
		echo json_encode($item);
	}


	function testimonialDelete($id)
	{
		$item = $this->db->query("SELECT * FROM tb_testimonials WHERE id = ?", $id)->row();
		@unlink($this->ftp_ruta . $item->photo);
		$this->db->where("id", $id)->delete("tb_testimonials");
		header("Location: /admin/testimonials");
	}

	function submitTestimonial()
	{
		header('Content-Type: application/json');

		$id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : false;
		unset($_POST["id"]);

		$errors = [];

		$fields = $_POST;

		### Validaciones ###
		# Valida el archivo si se ha seleccionado alguno:
		$file = $_FILES["photo"];
		$upload = false;
		if ($file && $file["size"] > 0) {
			$file = $_FILES["photo"];
			$ftypes = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
			$ext = pathinfo($file["name"], PATHINFO_EXTENSION);

			if (!in_array($ext, $ftypes))
				$errors[] = "El archivo seleccionado no parece ser una imagen";

			else if ($file["size"] > 1000000)
				$errors[] = "El archivo es demasiado pesadao, los archivos óptimos no deben pesar más de 2MB";

			else
				$upload = true;
		}

		if (!isset($_POST["name"]) || empty($_POST["name"]))
			$errors[] = "Es necesario indicar el nombre.";

		if ((!isset($_POST["testimonial"]) || empty($_POST["testimonial"])))
			$errors[] = "Es necesario indicar el texto testimonial.";

		function UUID()
		{
			return sprintf(
				'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0x0fff) | 0x4000,
				mt_rand(0, 0x3fff) | 0x8000,
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0xffff)
			);
		}


		if (count($errors) == 0) {
			if ($upload) {
				$uuid = UUID();
				$photo = 'src/images/testimonials/' . $uuid . "." . $ext;
				@move_uploaded_file($file['tmp_name'], $this->ftp_ruta . $photo);
				$fields["photo"] = $photo;
			}

			if (!$id) {
				// Insert:
				$this->db->insert('tb_testimonials', $fields);
			} else {
				// Update:
				$this->db->where('id', $id)->update('tb_testimonials', $fields);
			}
		} else {
			echo json_encode(array("errors" => $errors));
		}
	}





	# Modal para envío de factura:
	function modalFactura($id)
	{
		$factura = $this->db->query("SELECT * FROM tb_datos_factura WHERE id = " . $id . "")->row();
		echo json_encode($factura);
	}



	# Enviar Factura:
	function enviarFactura($id)
	{
		header('Content-Type: application/json');
		$errors = false;
		$files = $_FILES["archivos"];

		if (count($files["tmp_name"]) < 2)
			$errors = "Es necesario adjuntar exactamente 2 archivos (pdf y xml).";

		//echo $files["name"][0];
		//echo json_encode($files);

		if ($errors) {
			echo json_encode(["errors" => $errors]);
		} else {
			$factura = $this->db->query("SELECT * FROM tb_datos_factura WHERE id = " . $id . "")->row();
			$msg = $this->load->view('correos/factura', ["factura" => $factura], true);

			$this->db->where('id', $id)->update('tb_datos_factura', array("enviada" => 1));

			$this->load->library('email');
			$this->email->from('ventas@plados.mx', 'Plados');
			$this->email->to($factura->correo);
			//$this->email->bcc('julio@yayestudio.com','giovana@yayestudio.com','msalgado@kober.com.mx','vflores@kober.com.mx');
			$this->email->subject('Plados :: Factura de Pedido ' . str_pad($factura->pedido, 6, "0", STR_PAD_LEFT));
			$this->email->message($msg);
			$this->email->set_mailtype('html');
			$this->email->attach($files["tmp_name"][0], 'attachment', $files["name"][0], $files["type"][0]);
			$this->email->attach($files["tmp_name"][1], 'attachment', $files["name"][1], $files["type"][1]);
			$this->email->send();

			echo json_encode(array("success" => "La ha factura ha sido enviada correctamente."));
		}
	}
}
