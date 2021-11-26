<?
    $color = $this->m_plados->color($producto->idColor);
    $carrusel = sizeof($galeria);
    $titulo = $producto->titulo;
    if($producto->titulo == ''){
        $titulo =  $producto->producto .' '. $producto->linea .' MODELO '. $producto->modelo;
    }
?>

<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Editar Producto</h1>
    </div>
</section>
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="tabs tabs-bb clearfix" id="tab-9">

                <ul class="tab-nav clearfix">
                    <li><a href="#tabs-33"><i class="icon-home2 norightmargin"></i></a></li>
                    <li><a href="#tabs-34">Galeria del producto</a></li>
                    <!--<li><a href="#tabs-35">Proin dolor</a></li>
                    <li class="hidden-phone"><a href="#tabs-36">Aenean lacinia</a></li>-->
                </ul>

                <div class="tab-container">

                    <div class="tab-content clearfix" id="tabs-33">
                        <div class="single-product">

                            <div class="product">
                                <div class="col_three_fifth">
                                    <!-- Product Single - Gallery ============================================= -->
                                    <div class="product-image">
                                        <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                            <div class="flexslider">
                                                <div class="slider-wrap" data-lightbox="gallery">
                                                    <div class="slide" data-thumb="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>"><a href="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>" title="" data-lightbox="gallery-item"><img src="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>" alt=""></a></div>
                                                    <?foreach($galeria as $g) 
                                                     {
                                                        if($g->activa == 1){?>
                                                    <div class="slide" data-thumb="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>"><a href="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>" title="" data-lightbox="gallery-item"><img src="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>" alt=""></a></div>
                                                    <?}
                                                }?>

                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="sale-flash">Sale!</div>-->
                                    </div><!-- Product Single - Gallery End -->
                                </div>

                                <div class="col_two_fifth col_last product-desc">

                                    <h3><b> <input id="titulo" type="text" value="<?= $titulo ?>" class="form-control-lg col-md-12"> </b> </h3>
                                    <p>COLOR: <?= $producto->color ?> <b><?= $color ?></b></p>
                                    <div id="txtPrecio" class="product-price"><ins> <span id="cantidad">$<?= number_format($producto->precio, '2', ',', ' ') ?></span></ins></div>
                                    <a><span onclick="editar_cantidad();" class="badge "><i class="icon icon-pencil"></i> </span> </a>
                                    </h4>
                                    <div class="row" id="editaPrecio">
                                        <input type="number" id="precio" name="precio" class="form-control col-md-6" value="<?= $producto->precio ?>">
                                        <button class="btn btn-success" onclick="guardaPrecio();"><i class=""></i> Guardar </button>
                                        <button class="btn btn-danger " onclick="cancelarPrecio();"><i class=""></i> Cancelar </button>
                                    </div>

                                    <div class="clear"></div>
                                    <div class="line"></div>
                                    <div class="form-group">
                                        <form enctype="multipart/form-data" role="form" method="POST" action="<?= base_url() ?>index.php?/admin/subir_fotos">
                                            <div class="form-group mb-12 col-md-12 ">
                                                <label class="col-sm-12 col-form-label"><b>Imagen Principal:</b> </label>
                                                <div class="col-sm-12">
                                                    <input type="hidden" name="id" value="<?= $producto->id_catProducto ?>">
                                                    <input type="hidden" name="modelo" value="<?= $producto->modelo ?>">
                                                    <input type="hidden" name="idColor" value="<?= $producto->idColor ?>">

                                                    <input type="file" id="fprincipal" name="fprincipal">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group mb-12 col-md-12 ">
                                                <label class="col-sm-12 col-form-label"><b>Galeria / Carrusel:</b> </label>
                                                <div class="col-sm-12">
                                                    <input type="hidden" id="idProducto" name="id" value="<?= $producto->id_catProducto ?>">
                                                    <input type="file" id="galeria" name="galeria[]" multiple="multiple">
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <input type="submit" class="btn btn-success btn-block" value="Subir Fotos">
                                        </form>
                                    </div>

                                    <div class="clear"></div>
                                    <div class="line"></div>
                                    <div class="row" id="dvBullets">
                                        <label for="bullet" class="col-md-12">Bullets</label>
                                        <div class="col-md-6">
                                            <div id="optBullet"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <button data-toggle="tooltip" onclick="agregarBullet();" title="Añadir Bullet al producto" class="btn btn-sm btn-default"><i class="icon icon-checkmark" style="color: green;"></i> </button>
                                            <button data-toggle="tooltip" onclick="agregar_catBullets();" title="Agregar un nuevo Bullet a la lista" class="btn btn-sm btn-default"><i class="icon icon-plus " style="color: orange;"></i> </button>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="line"></div>

                                    <span id="bullet"></span>

                                    <div class="panel panel-default product-meta">
                                        <div class="panel-body">
                                            <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku"> <input type="text" value="<?= $producto->sku ?>" id="sku" class="form-control"> </span></span>
                                            <span class="posted_in">Categoría: <a href="#" rel="tag"><?= $producto->producto ?>S</a>.</span>
                                        </div>
                                    </div><!-- Product Single - Meta End -->

                                    <!-- Product Single - Share
============================================= -->

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="ibox">
                                    <div class="ibox-head">
                                        <div class="ibox-title">
                                            Descripción
                                        </div>
                                    </div>
                                    <div class="ibox-body"><span id="descrip"><?= $producto->descripcion ?></span></div>
                                    <div class="ibox-footer">
                                        <textarea required="true" id="summernote" placeholder="Escriba aquí todos los detalles del incidente" name="descripcion" data-plugin="summernote" data-air-mode="true"><?= $producto->descripcion ?></textarea>
                                        <br>
                                        <button id="description" onclick="guardarDescripcion();" name="description" class="btn btn-rounded btn-success"><i class="fa fa-save"></i> Guardar Descripción</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-content clearfix" id="tabs-34">
                        <h2>Galeria del producto</h2>
                        <div class="postcontent nobottommargin clearfix">
                            <div class="row">
                                <?foreach($galeria as $g) {
                                if($g->activa == 1){
                                    $activa = "VISIBLE";
                                }else {
                                    $activa = "NO VISIBLE";
                                }?>
                                <div id="img<?= $g->id ?>" class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" alt="300x200" src="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>" style="display: block;">
                                        <div class="caption">
                                            <h4><span id="lblEtiqueta<?=$g->id?>"><?=$activa?></span></h4>
                                            <button onclick="habilitar_foto(<?= $g->id ?>, <?= $g->activa ?>)" class="btn btn-primary" role="button">Visible / No </button>
                                            <button onclick="eliminar_foto(<?= $g->id ?>)" class="btn btn-danger" role="button">Eliminar Foto</a>
                                        </div>
                                    </div>
                                </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





</div>
</div>


<script>
    $(function() {

        id = $("#idProducto").val();

        obt_bullets();
        obt_catBullets();

        $("#editaPrecio").hide('fast');

        $('#summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            height: 100
        });
    });

    function obt_catBullets() {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/obt_catBullets',
        }).done(function(respuesta) {
            $("#optBullet").html(respuesta);
        })
    }

    function obt_bullets() {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/obt_bullets?q=' + id,
        }).done(function(respuesta) {
            $("#bullet").html(respuesta);
        })
    }

    function agregarBullet() {
        bullet = $("#sBullet").val();
        data = {
            id,
            bullet
        };

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/agregar_bullet',
            data,
        }).done(function(respuesta) {
            alertify.success(respuesta);
            obt_bullets();
        })
    }

    function eliminaBullet(id) {
        data = {
            id
        };

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/elimina_bullet',
            data,
        }).done(function(respuesta) {
            console.log(respuesta);
            alertify.error(respuesta);
            obt_bullets();
        })
    }

    function agregar_catBullets() {
        alertify.prompt("Nuevo Bullet", "Escribe el nuevo Bullet", "",
            function(evt, value) {
                data = {
                    value
                };

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '<?= base_url() ?>index.php/admin/agregar_catBullet',
                    data,
                }).done(function(respuesta) {
                    console.log(respuesta);
                    obt_catBullets();
                })
                alertify.success('Añadido correctamente: ' + value);
            },
            function() {
                alertify.error('Cancel');
            });
    }

    function guardarDescripcion() {
        texto = $("#summernote").val();
        id = <?= $producto->id_catProducto ?>;

        data = {
            id,
            texto
        };

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/editarDescripcion',
            data,
        }).done(function(respuesta) {
            $("#descrip").html(respuesta);
        })
    }

    function editar_cantidad() {
        $("#editaPrecio").show('fast');
        $("#txtPrecio").hide('fast');
    }

    function guardaPrecio() {
        precio = $("#precio").val();

        if (precio != <?= $producto->precio ?>) {
            id = <?= $producto->id_catProducto ?>;
            data = {
                id,
                precio
            };
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '<?= base_url() ?>index.php/admin/editarPrecio',
                data,
            }).done(function(respuesta) {
                $("#cantidad").html(respuesta);
                cancelarPrecio();
            });
        } else {
            cancelarPrecio();
        }
    }

    function habilitar_foto(id, estatus) {
        data = {
            id,
            estatus
        };
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/habilitar_galeria',
            data,
        }).done(function(respuesta) {
            alertify.success("imagen " + respuesta);
            $("#lblEtiqueta"+id).html(respuesta);
        });
    }

    function eliminar_foto(id) {
        data = {
            id
        };
        alertify.confirm("ATENCIÓN!", "¿Seguro que desea eliminar esta imagen de la galeria?",
            function() {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '<?= base_url() ?>index.php/admin/eliminar_galeria',
                    data,
                }).done(function(respuesta) {
                    $("#img" + id).hide('fast');
                    alertify.success('Imagen eliminada');
                });
            },
            function() {
                alertify.error('Cancelado');
            });
    }

    function cancelarPrecio() {
        $("#editaPrecio").hide('fast');
        $("#txtPrecio").show('fast');
    }

    $("#titulo").change(function() {
        titulo = $("#titulo").val();
        id = $("#idProducto").val();
        data = {
            id,
            titulo
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/modificar_titulo',
            data,
        }).done(function(respuesta) {
            alertify.success('Título Actualizado');
        });
    });

    $("#sku").change(function() {
        sku = $("#sku").val();
        id = $("#idProducto").val();
        data = {
            id,
            sku
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/modificar_sku',
            data,
        }).done(function(respuesta) {
            alertify.success('SKU Actualizado');
        });
    })
</script>