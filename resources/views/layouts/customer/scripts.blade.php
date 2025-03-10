    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>

    <!-- jQuery UI -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery-ui.min.js') }}"></script>

    <!-- flasher -->
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>

    <!-- sticky -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.sticky.js') }}"></script>

    <!-- OWL CAROUSEL Slider -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>

    <!-- Boostrap -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>

    <!-- Countdown -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.countdown.min.js') }}"></script>

    <!--jquery Bxslider  -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.bxslider.min.js') }}"></script>

    <!-- actual -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.actual.min.js') }}"></script>

    <!-- Chosen jquery-->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/chosen.jquery.min.js') }}"></script>

    <!-- parallax jquery-->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.parallax-1.1.3.js') }}"></script>

    <!-- elevatezoom -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.elevateZoom.min.js') }}"></script>

    <!-- fancybox -->
    <script src="{{ asset('frontend/assets/js/fancybox/source/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/fancybox/source/helpers/jquery.fancybox-media.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}"></script>

    <!-- arcticmodal -->
    <script src="{{ asset('frontend/assets/js/arcticmodal/jquery.arcticmodal.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/js/all.min.js"></script>

    <!-- Main -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/main.js') }}"></script>


    <!-- ================== DataTable js ================== -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


	<!-- ================== Sweet Alert JS ================== -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>

    @include('layouts.customer.add_to_cart')

    <script>

        function show_error(msg) {
            flasher.error(msg);
        }
        function show_warning(msg) {
            flasher.warning(msg);
        }
        function show_success(msg) {
            flasher.success(msg);
        }
        function show_info(msg) {
            flasher.info(msg);
        }

        $('.close_error').on('click', function() {
            closeErrorMessage();
        });

        // error message heldler
        function showErrorMessage(message) {
            let errorMessageBox = $('.error-message');
            $('.message-text').html(message);

            errorMessageBox.css('display', 'block').css('opacity', '0');
            setTimeout(function () {
                errorMessageBox.css('opacity', '1');
            }, 5);

            setTimeout(function () {
                closeErrorMessage();
            }, 2000);
        }

        function closeErrorMessage() {
            let errorMessageBox = $('.error-message');
            errorMessageBox.css('opacity', '0');
            setTimeout(function () {
                errorMessageBox.css('display', 'none');
            }, 1000);
        }
        // error message heldler ends here

    </script>
