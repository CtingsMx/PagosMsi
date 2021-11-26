<section id="page-title">
  <div class="container clearfix" align="center">
    <h1>Lista de Productos PLADOS MX</h1>
  </div>
</section>

<section id="content">
  <div class="content-wrap">
    <div class="container clearfix">
      <div class="table-responsive">
        <table id="datatable1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
          <thead>
            <tr role="row">
              <th>Presentación</th>
              <th>#id</th>
              <th>Categoria</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Color</th>
              <th>Precio</th>
              <th>Estatus</th>
              <th>Destacar</th>
              <th>Editar</th>
            </tr>
          </thead>
          <tbody>
            <?
            $estatus = ''; 
            foreach ($productos as $p) {
              if($p->activo == 1)
              {
                $estatus = "ACTIVO";
              }else {
                $estatus = "INACTIVO";
              }
              ?>
            <tr width="10px" align="center" class="">
              <td><img src="<?= base_url() ?>src/images/shop/<?= $p->foto ?>" width="100px" alt="Foto Principal"></td>
              <td><?= $p->id_catProducto ?></td>
              <td><?= $p->producto ?></td>
              <td><?= $p->linea ?></td>
              <td><?= $p->modelo ?></td>
              <td><?= $p->color ?></td>
              <td>$ <?= number_format($p->precio, '2', ',', ' ') ?></td>
              <td><a href="javascript:cambiarStatus(<?=$p->id_catProducto?>);"><span id="lblEstatus<?=$p->id_catProducto?>"><?= $estatus?></span></a></td>
              <td>
                <label>
                  <?php $checked = ($p->destacado == 1) ? "checked"  : ""; ?>
                  <input <?php echo $checked; ?> onchange="inCarrousel(<?=$p->id_catProducto?>, this)" type="checkbox"/> <span style="font-weight:normal;">Aparece en carrusel del home.</span>
                </label>
              </td>
              <td> <a class="btn btn-warning" href="<?= base_url() ?>index.php?/admin/editar_producto/<?= $p->id_catProducto ?>">
                  <i class="icon icon-pencil"></i> </a> </td>
            </tr>
            <?}?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<script>
  function cambiarStatus(id)
  {
    data = {id}
    $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?= base_url() ?>index.php?/admin/modificar_estatusProducto",
            data,
        }).done(function(respuesta) {
         $("#lblEstatus"+id).html(respuesta);
            
        });
  }

  function inCarrousel(id, inp){
    var checked = $(inp).prop("checked");
    checked = (checked) ? 1 : 0;
    var data = {id, checked};
    $.ajax({
          type: "POST",
          dataType: 'json',
          url: "<?= base_url() ?>index.php?/admin/isfeatured",
          data,
    }).done(function(res) {
      console.log(res);
    });
  }
</script>