<section>
	<div class="container clearfix">
		<div class="row">
			<div class="col-12">
				<div class="cart-steps-redesign">
					<div class="step-holder">
						<span class="<?php echo ($step >= 1) ? "current" : ""; ?>">Paso 1</span>
						<div class="step <?php echo ($step >= 1) ? "current" : ""; ?>">
							<i class="far fa-clipboard"></i>
							<label>MI ORDEN</label>
						</div>
					</div>
					<div class="step-holder">
						<span class="<?php echo ($step >= 2) ? "current" : ""; ?>">Paso 2</span>
						<div class="step <?php echo ($step >= 2) ? "current" : ""; ?>">
							<i class="fas fa-truck"></i>
							<label>ENVÍO</label>
						</div>
					</div>
					<div class="step-holder">
						<span class="<?php echo ($step >= 3) ? "current" : ""; ?>">Paso 3</span>
						<div class="step <?php echo ($step >= 3) ? "current" : ""; ?>">
							<i class="far fa-credit-card"></i>
							<label>PAGO (MSI)</label>
						</div>
					</div>
					<div class="step-holder">
						<span class="<?php echo ($step >= 4) ? "current" : ""; ?>">Paso 4</span>
						<div class="step <?php echo ($step >= 4) ? "current" : ""; ?>">
							<i class="fas fa-clipboard-check"></i>
							<label>CONFIRMACIÓN</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>