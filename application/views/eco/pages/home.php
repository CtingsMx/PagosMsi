<?php $this->load->view("eco/pages/home-sliders"); ?>

<section id="content" style="margin-bottom: 0px;">
	<div class="fonde">

		<!-- Slick Products -->
		<div id="product-slider">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="home-products-slider">
							<?php foreach($products as $product) { ?>
								<a class="item" href="/detalle_articulo/<?php echo $product->id_catProducto; ?>">
									<?php if($product->producto == 1 && $product->linea != 1) { ?><div class="sale-flash">*Accesorio de regalo</div><?php } ?>
									<div class="img-holder" style="background-image:url('/src/images/shop/<?php echo $product->foto; ?>')"></div>
									<h2><?php echo $product->modelo; ?></h2>
									<!-- Yay! Estudio: Se muestra cuando hay promo activa -->
									<?php if ($product->precio < $product->_precio){ ?>
										<sup class="promo-price">$<?php echo number_format($product->_precio,2); ?></sup>
									<?php } ?>
									<b>$<?php echo number_format($product->precio,2); ?></b>
								</a>
							<?php } ?>
						</div>
						<a href="/productos" class="btn-products">VER TODOS LOS PRODUCTOS</a>
					</div>
				</div>
			</div>
		</div>

		<div class="section nomargin noborder bgcolor dark" style="padding: 80px 0; ">

			<div class="container center clearfix">

				<div class="heading-block">
					<h2>LA TARJA ITALIANA DE CUARZO QUE PURIFICA EL AIRE DE TU COCINA</h2>
				</div>

				<div class="col_one_third topmargin-sm nobottommargin">
					<div class="feature-box fbox-center fbox-light nobottomborder" style="color: white !important;"> <!--  fbox-effect: Return this class to hover effect -->
						<div class="fbox-icon">
							<i class="i-alt noborder icon54-v1-leaf-1"></i>
						</div>
						<h3 style="color: white;">PURIFICANTE
							<span class="subtitle" style="color: white;">Sus partículas de dióxido de titanio en el 100% de su masa purifican 80m3 de aire en tan solo
								una hora con un proceso llamado fotocatálisis. </span>
						</h3>
					</div>
				</div>

				<div class="col_one_third topmargin-sm nobottommargin">
					<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect: Return this class to hover effect -->
						<div class="fbox-icon">
							<i class="i-alt noborder imind-security-bug"></i>
						</div>
						<h3 style="color: white;">ANTIBACTERIAL
							<span class="subtitle" style="color: white;">Sus iones de plata inhiben la reprodución de virus y bacterias como la influenza y el coronavirus. </span>
						</h3>
					</div>
				</div>

				<div class="col_one_third topmargin-sm nobottommargin col_last">
					<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect: Return this class to hover effect -->
						<div class="fbox-icon">
							<i class="i-alt noborder icon54-v1-recycle-water"></i>
						</div>
						<h3 style="color: white;">AUTOLIMPIEZA
							<span class="subtitle" style="color: white;">Su tecnología Ultraclean crea una película delgada e invisible en toda la superficie que hace que
								las gotas de agua resbalen eliminando residuos de suciedad.</span>
						</h3>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="heading-block" align="center">
				<h1>¿Por qué elegir Plados?</h1>
				<span class="subtitle">Las tarjas Plados están hechas de 80% cuarzo y 20% acrílico, este último permite crear una superficie libre de poros y muy resistente
					a cambios bruscos de temperatura. ¡Dile adiós a la era industrial y descubre el alto diseño en tu cocina!</span>
			</div>
			<div class="col_one_fifth nobottommargin">
				<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect :: return this class to hover effect -->
					<div class="fbox-icon">
						<i class="i-alt noborder icon-tint"></i>
					</div>
					<h3>NO SE MANCHAN
						<span class="subtitle">La aliación del cuarzo con el acrílico crea una superficie sin poros resistente a manchas de comida. </span>
					</h3>
				</div>
			</div>

			<div class="col_one_fifth nobottommargin">
				<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect :: return this class to hover effect -->
					<div class="fbox-icon">
						<i class="i-alt noborder icon-line2-shield "></i>
					</div>
					<h3>RESISTEN RAYONES<span class="subtitle">La dureza del cuarzo vuelve a las tarjas resistentes a rayones, roturas y golpes de alto impacto.</span></h3>
				</div>
			</div>

			<div class="col_one_fifth nobottommargin">
				<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect :: return this class to hover effect -->
					<div class="fbox-icon">
						<i class="i-alt noborder icon-line2-fire "></i>
					</div>
					<h3>RESISTEN CALOR<span class="subtitle">Soportan choque térmico y temperaturas de hasta 280°C. Garantía por escrito por 10 años.</span></h3>
				</div>
			</div>

			<div class="col_one_fifth nobottommargin">
				<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect :: return this class to hover effect -->
					<div class="fbox-icon">
						<i class="i-alt noborder icon-random"></i>
					</div>
					<h3>MEZCLADORAS<span class="subtitle">Combina tu tarja con una mezcladora Plados del mismo color.</span></h3>
				</div>
			</div>
			<div class="col_one_fifth nobottommargin col_last">
				<div class="feature-box fbox-center fbox-light nobottomborder"> <!--  fbox-effect :: return this class to hover effect -->
					<div class="fbox-icon">
						<i class="i-alt noborder icon-sun2"></i>
					</div>
					<h3>NO PIERDEN COLOR<span class="subtitle">Tendrás un color intenso sin importar el paso del tiempo o una exposición prolongada a la luz solar.</span></h3>
				</div>
			</div>
		</div>
	</div>

	<!-- Warranty Logos -->
	<section style="background-color: #f5f5f5;">
		<div class="container">
			<?php $this->load->view("eco/warranty-logos"); ?>
		</div>
	</section>

	<!-- Beneficios -->
	<div class="content-wrap home-benefits">
		<div class="container clearfix">
			<h2>Beneficios</h2>
			<div class="row">
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-estetica.png?cache=false"/>
						</div>
						<label>ESTÉTICA</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-pura.png?cache=false"/>
						</div>
						<label>ARIAPURA purifican 80m3 de aire en 1 hora</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-tiempo.png?cache=false"/>
						</div>
						<label>MENOS TIEMPO DE LIMPIEZA</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-cambio.png?cache=false"/>
						</div>
						<label>60% de cambio favorable en la vista de tu cocina al remodelar</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-tecnologia.png?cache=false"/>
						</div>
						<label>TECNOLOGÍA</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-diseno.png?cache=false"/>
						</div>
						<label>ALTO DISEÑO</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-personalizacion.png?cache=false"/>
						</div>
						<label>PERSONALIZACIÓN</label>
					</section>
				</div>
				<div class="col-benefit col-md-3 col-sm-4 col-xs-6">
					<section>
						<div class="img-holder">
							<img src="/src/images/benefits/icon-benefit-higiene.png?cache=false"/>
						</div>
						<label>HIGIENE</label>
					</section>
				</div>
			</div>


		</div>
	</div>


	<!-- Yay! Estudio: Banner de Promociones
	<div class="section nomargin noborder home-promos">
		<?php foreach($promos as $promo) { ?>
			<div class="item" style="background-image:url('/<?php echo $promo->banner; ?>')">
				<div class="container">
					<div class="row">
						<div class="col-md-1 col-sm-0 col-xs-0"></div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="text-holder <?php echo $promo->fondo; ?>">
								<?php echo $promo->titulos; ?>
								<a href="<?php echo $promo->link; ?>"><?php echo $promo->boton; ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	-->


	<!-- PortFolio -->
	<div id="portfolio" class="portfolio grid-container portfolio-2 portfolio-nomargin portfolio-notitle clearfix"></div>


	<!-- Yay! Estudio: Testimoniales -->
    <div class="section nomargin noborder" id="testimonials">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2>TESTIMONIALES</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="testimonials-slider">
						<?php foreach($testimonials as $t) { ?>
							<div class="item">
								<div class="item-wrap">
									<div class="img-holder" style="background-image:url('/<?php echo $t->photo; ?>')"></div>
									<b><?php echo $t->name; ?></b>
									<p>"<?php echo $t->testimonial; ?>"</p>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="clear"></div>

	<!--
	<a href="<?=base_url()?>/productos" class="button button-full button-dark center tright bottommargin-lg">
			<div class="container clearfix">
				Navega por nuestra galería de productos para<strong> descubrir tu favorita </strong> <i class="icon-caret-right" style="top:4px;"></i>
			</div>
		</a>
	-->
</section>


<!-- Modal para sugerir la visita a la sección productos -->
<div id="modal-visit-products" onclick="$('#modal-visit-products').css('visibility', 'hidden');">
	<a class="mvp-content-holder" href="/productos">
		<img src="<?= base_url() ?>src/images/modal-visit-products.svg"/>
		<?php $this->load->view("eco/warranty-logos"); ?>
	</a>
</div>

<!-- #content end -->