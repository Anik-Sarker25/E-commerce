	<!-- ================== BEGIN core-js ================== -->
	<script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>
	<script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
	<!-- ================== END core-js ================== -->

	<!-- ================== BEGIN page-js ================== -->
	<script src="{{ asset('backend/assets/plugins/jvectormap-next/jquery-jvectormap.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<script src="{{ asset('backend/assets/plugins/summernote/dist/summernote-lite.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/spectrum-colorpicker2/dist/spectrum.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
	<script src="{{ asset('backend/assets/plugins/jvectormap-content/world-mill.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
	<script src="{{ asset('backend/assets/js/demo/dashboard.demo.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/gh/itsjavi/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<!-- ================== END page-js ================== -->

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

    <script>
        $(document).ready(function () {
            $(".app-theme-panel").removeClass("active");

            $(".datepicker").datepicker({
                dateFormat: "dd-mm-yy", // You can change the format as needed
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:2050",
            });
            $(".datepicker").attr("placeholder", "Select a date");

            // sidebar menu focus
            let userMenu = $('.has-sub');
            let menuLink = $('.has-sub.expand>.menu-link');

            // Check if the menu is expanded on page load
            if (userMenu.hasClass('expand')) {
                menuLink.focus();
            }

            $('.select2').select2({
                placeholder: "Select Options",
                width: "100%",
                allowClear: true
            });

            $('.color-picker').each(function() {
                if (!$(this).hasClass('spectrum-applied')) {
                    $(this).spectrum({
                        type: "component",
                        showPalette: true,
                        showInput: true,
                        allowEmpty: true
                    });
                    $(this).addClass('spectrum-applied');
                }
            });

            // Apply Spectrum for newly added elements dynamically
            $(document).on('focus', '.color-picker', function() {
                if (!$(this).hasClass('spectrum-applied')) {
                    $(this).spectrum({
                        type: "component",
                        showPalette: true,
                        showInput: true,
                        allowEmpty: true
                    });
                    $(this).addClass('spectrum-applied');
                }
            });

        });

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

    </script>
