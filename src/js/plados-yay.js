const urlCarrito = `${window.location.origin}/pladosportal/`

// Close side cart panel
function closeSideCart() {
    $('#cart-side-holder').addClass('hidden');

    // Debido a que el scroll del body se desactiva cuando el resumen de carrito está activo, al cerrarlo, volvemos a activar el scroll:
    $('body').removeAttr('style');
}

// Delete cart item:
function deleteCartItem(url) {
    $.get(url, function() {
        loadCart();
    });
}

/* Start Cart Redesign */
function loadCart() {
    $('#cart-side-holder .items-holder').html('');
    $.getJSON(`${urlCarrito}plados/loadCart`, function(cart) {
        $('#cart-count').html(Object.keys(cart.items).length);
        $.each(cart.items, function(pid, item) {
            $('#cart-side-holder .items-holder').append(`
                <section>
                    <div class="row">
                        <div class="col-sm-4 col-xs-4">
                            <a class="img-holder" style="background-image: url('./src/images/shop/${item.foto}')"></a>
                        </div>
                        <div class="col-sm-8 col-xs-8">
                            <b>${item.descripcion}</b>
                            <label>Color:</label><span>${item.color}</span>
                            <div class="qty-and-subtotal">${item.cantidad} x $${item.precio}</div>
                            <a href="${urlCarrito}plados/eliminar_art/?articulo=${pid}" class="delete-item"><img src="./src/images/cart-redesign/item-delete.png"/></a>
                        </div>
                    </div>
                </section>
            `);
        });
        $('#cart-side-holder .cart-side-subtotal').text(`$${cart.total}Mxn`);
    });
}


$(function() {

    loadCart();
    $('.close-side-cart').click(() => {
        closeSideCart();
    });

    // Lanza paanel de resumen de carrito
    $('.cart-helper').click((e) => {
        e.preventDefault();
        $('#cart-side-holder').removeClass('hidden');
        $('body').css('overflow', 'hidden');
    });


    // Agregar al carrito en ajax:
    /*
    $('.add-to-cart').click((e) => {
        e.preventDefault();
        var a = e.currentTarget;
        var url = $(a).attr('href').replace(/\'/, '');
        $.get(url, function(){
            loadCart();
            $('#cart-side-holder').removeClass('hidden');
        });
    });
    */
    /* End Cart Redesign */


    function isOnScreen(element) {
        var curPos = element.offset();
        var curTop = curPos.top;
        var screenHeight = $(window).scrollTop();
        return (curTop > screenHeight) ? false : true;
    }

    // Carga el portafolio de productos cuando el dom está listo para reducir tiempo de carga inicial:
    document.loadedPortfolio = false;
    setTimeout(() => {
        if ($('#portfolio').length > 0) {
            document.loadedPortfolio = true;
            var products = [{
                    "id": 68,
                    "model": "LX8620"
                },
                {
                    "id": 80,
                    "model": "ON7610"
                },
                {
                    "id": 75,
                    "model": "ON8420"
                },
                {
                    "id": 89,
                    "model": "PL08620"
                },
            ];
            $.each(products, function(idx, item) {
                var a = `<a href="/detalle_articulo/${item.id}" class="portfolio-item pf-media pf-icons">
                    <div class="portfolio-image">
                        <img src="/src/images/${item.model}.png" alt="Tarjas Plados Modelo ${item.model}">
                    </div>
                    <div class="portfolio-desc">
                        <h3>MODELO:: ${item.model}</h3>
                    </div>
                </a>`;
                $('#portfolio').append(a);
            });
            $('#portfolio').css('height', 'auto');
        }
    }, 2000);


    // Carrusel de productos:
    $('.home-products-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: '<button type="button" class="slick-prev">⟨</button>',
        nextArrow: '<button type="button" class="slick-next">⟩</button>',
        responsive: [{
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });



    // Banners Promocionales
    $('.home-promos').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '',
        nextArrow: '',
        responsive: [
            /*
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            */
        ]
    });


    // Testimoniales:
    $('.testimonials-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        centerMode: true,
        prevArrow: '<button type="button" class="slick-prev">⟨</button>',
        nextArrow: '<button type="button" class="slick-next">⟩</button>',
        responsive: [{
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });



    // Forma de Contacto:
    $('#contactForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $('#contactForm .alert').attr("class", "alert hidden");

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).complete(function(r) {
            var res = r.responseJSON;
            if (res && res.errors && res.errors.length > 0) {
                $('#contactForm .alert').attr('class', "alert alert-danger").text(res.errors[0]);
            } else {
                document.getElementById('contactForm').reset();
                $('#contactForm .alert').attr('class', "alert alert-success").text("!Gracias! Hemos reicibido tu mensaje, en breve nos pondremos en contacto.");
            }
        });
    });


    // Muestra/Oculta Menú mobile
    $('#plados-header .mobile-menu').click(function() {
        $('.toggle-menu').css('visibility') === 'hidden' ? $('.toggle-menu').css('visibility', 'visible') : $('.toggle-menu').css('visibility', 'hidden');
    })

});