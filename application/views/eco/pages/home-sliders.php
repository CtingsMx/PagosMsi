<?php $banners = $this->db->query("SELECT * FROM tb_banners WHERE seccion='home' AND status=1 order by id asc")->result(); ?>
<section id="slider" class="slider-parallax swiper_wrapper full-screen clearfix">
	<div class="slider-parallax-inner">

		<div class="swiper-container swiper-parent">
			<div class="swiper-wrapper">
				<?php foreach($banners as $banner) { ?>
					<div class="swiper-slide <?php echo $banner->fondo; ?>" style="background-image: url('/<?= $banner->banner; ?>">
						<?php if($banner->link != " " && $banner->boton != " ") { ?>
							<a class="cta" href="<?php echo $banner->link; ?>"><?php echo $banner->boton; ?></a>
						<?php } ?>
						<!--
						<div class="container">
							<div class="row">
								<div class="col-md-1 col-sm-0 col-xs-0"></div>
								<div class="col-md-8 col-xs-12">
									<div class="banner-titles">
										<?php echo $banner->titulos; ?>
									</div>
									<div class="banner-texts">
										<p>Diseño Italiano directo a tu cocina</p>
										<span>Compra tus tarjas Plados® a meses sin intereses</span>
										<img src="<?php echo base_url(); ?>src/images/visa.svg"/> <img src="<?php echo base_url(); ?>src/images/mastercard.svg"/>
										<a href="<?php echo $banner->link; ?>"><?php echo $banner->boton; ?></a>
									</div>
								</div>
							</div>
						</div>
						-->
					</div>
				<?php } ?>
			</div>
			<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
			<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
		</div>

		<a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

	</div>
</section>