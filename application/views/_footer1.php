<!-- Footer
		============================================= -->
        <footer id="footer" class="dark">

<!-- Copyrights
    ============================================= -->
<div id="copyrights">

    <div class="container clearfix">

        <div class="col_half">
            Derechos Reservados &copy; 2020 Plados <br>
            <div class="copyright-links"> <a href="#">Anuncio de Privacidad</a></div>
        </div>

        <div class="col_half col_last tright">
            <div class="fright clearfix">
                <a href="#" class="social-icon si-small si-borderless si-facebook">
                    <i class="icon-facebook"></i>
                    <i class="icon-facebook"></i>
                </a>

                <a href="#" class="social-icon si-small si-borderless si-pinterest">
                    <i class="icon-pinterest"></i>
                    <i class="icon-pinterest"></i>
                </a>

                <a href="#" class="social-icon si-small si-borderless si-instagram">
                    <i class="icon-instagram"></i>
                    <i class="icon-instagram"></i>
                </a>
            </div>

            <div class="clear"></div>

            <!--  <i class="icon-envelope2"></i> info@canvas.com <span class="middot">&middot;</span> <i class="icon-headphones"></i> +91-11-6541-6369 <span class="middot">&middot;</span> <i class="icon-skype2"></i> CanvasOnSkype-->
        </div>

    </div>

</div><!-- #copyrights end -->

</footer><!-- #footer end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>




<!-- External JavaScripts
============================================= -->

<script type="text/javascript" src="<?= base_url() ?>src/js/plugins.js"></script>
<script type="text/javascript" src="<?= base_url() ?>src/js/components/bs-datatable.js"></script>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="<?= base_url() ?>src/js/functions.js"></script>



<script>
jQuery(document).ready(function($) {
    $('#shop').isotope({
        transitionDuration: '0.65s',
        getSortData: {
            name: '.product-title',
            price_lh: function(itemElem) {
                if ($(itemElem).find('.product-price').find('ins').length > 0) {
                    var price = $(itemElem).find('.product-price ins').text();
                } else {
                    var price = $(itemElem).find('.product-price').text();
                }

                priceNum = price.split("$");

                return parseFloat(priceNum[1]);
            },
            price_hl: function(itemElem) {
                if ($(itemElem).find('.product-price').find('ins').length > 0) {
                    var price = $(itemElem).find('.product-price ins').text();
                } else {
                    var price = $(itemElem).find('.product-price').text();
                }

                priceNum = price.split("$");

                return parseFloat(priceNum[1]);
            }
        },
        sortAscending: {
            name: true,
            price_lh: true,
            price_hl: false
        }
    });

    $('.custom-filter:not(.no-count)').children('li:not(.widget-filter-reset)').each(function() {
        var element = $(this),
            elementFilter = element.children('a').attr('data-filter'),
            elementFilterContainer = element.parents('.custom-filter').attr('data-container');

        elementFilterCount = Number(jQuery(elementFilterContainer).find(elementFilter).length);

        element.append('<span>' + elementFilterCount + '</span>');

    });

    $('.shop-sorting li').click(function() {
        $('.shop-sorting').find('li').removeClass('active-filter');
        $(this).addClass('active-filter');
        var sortByValue = $(this).find('a').attr('data-sort-by');
        $('#shop').isotope({
            sortBy: sortByValue
        });
        return false;
    });
});
</script>


<script>

$(document).ready(function() {
    $('#datatable1').DataTable();
});

</script>

<script>
        function carrito() {
            window.location.href = "<?= base_url() ?>index.php/plados/carrito";
        }
    </script>

</body>

</html>