	<!-- ================== BEGIN core-css ================== -->
	<link href="{{ asset('backend/assets/css/vendor.min.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
	<!-- ================== END core-css ================== -->

	<!-- ================== BEGIN page-css ================== -->
	<link href="{{ asset('backend/assets/plugins/jvectormap-next/jquery-jvectormap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Font Awesome Icon Picker -->
    <link href="https://cdn.jsdelivr.net/gh/itsjavi/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<!-- ================== END page-css ================== -->

	<!-- ================== Sweet Alert css ================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">

	<!-- ================== Summernote css ================== -->
	<link href="{{ asset('backend/assets/plugins/summernote/dist/summernote-lite.css') }}" rel="stylesheet">

	<!-- ================== BEGIN DataTables-css ================== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <style>
        /* select2  */
        .select2-selection {
            background: transparent !important;
            border: 1px solid #ffffff40 !important;
        }
        .select2-container--default .select2-selection--single {
            padding: 4px 0 0 4px; /* Adjust top/bottom and left/right padding as needed */
            height: auto;      /* Adjust height if padding causes overlap */
        }


        .select2-container--default .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: #ffffffbf;
        }
        .select2-container--default .select2-selection--multiple .select2-search__field {
            background: transparent !important;
            border: 1px solid transparent !important;
            color: #ffffffbf !important;
            outline: none;
        }
        .select2-container--default .select2-search__field {
            background: transparent !important;
            border: 1px solid #ffffff40 !important;
            color: #ffffffbf !important;
            outline: none;
        }
        .select2-container--default .select2-search__field::placeholder {
            color: #ffffffbf !important;  /* Set color */
        }
        .select2-selection__choice {
            background: transparent !important;
        }

        /* Dropdown Menu */
        .select2-dropdown {
            border-radius: 4px;
            border: 1px solid #ffffff40;
            background: rgba(29,40,53.98)!important;
            box-shadow: 0 .5rem 1rem rgba(var(--bs-inverse-rgb),.075);
        }

        /* Dropdown Options */
        .select2-results__option {
            padding: 6px 16px;
            color: #ffffffbf;
            text-transform: capitalize;
        }
        .select2-results__option:hover {
            background-color: rgba(255,255,255, .15) !important;
            color: #ffffffbf;
        }
        .select2-container--default .select2-results__option--selected {
            background-color: rgba(255,255,255, .15) !important;
            color: #ffffffbf;

        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: rgba(255,255,255, .15) !important;
            color: #ffffffbf;
        }

        /* Placeholder Styling */
        .select2-container .select2-selection--multiple .select2-selection__placeholder,
        .select2-container .select2-selection--single .select2-selection__placeholder {
            color: #ffffffbf !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 33px
        }

        select, .select2, select option {
            text-transform: capitalize !important;
        }

        .menu-link .menu-text {
            text-transform: capitalize;
        }
        .menu-link {
            outline: none;
        }

        div#DataTables_Table_0_length label select option {
            background: rgba(29,40,53.98)!important;
        }

        /* datepicker  */
        .ui-datepicker {
            background: rgb(29,40,53, 0.98);
            color: #ffffff80;
        }
        .ui-datepicker .ui-datepicker-header {
            background: transparent;
            color: #ffffff80;
        }
        .ui-datepicker-month,
        .ui-datepicker-year {
            background: rgb(29,40,53, 0.98);
            color: #ffffff80;
        }
        .ui-state-default, .ui-widget-content .ui-state-default {
            color: #ffffff;
            background: transparent;
        }
        .ui-state-default:hover, .ui-widget-content .ui-state-default:hover {
            background: #3cd2a5;
        }
        .ui-state-active, .ui-widget-content .ui-state-active {
            color: #ffffff;
            background: #3cd2a5;
        }

        /* data table  */
        label {
            color: #ffffffbf;
        }
        .dt-buttons button {
            color: #ffffffbf;
        }
        div#DataTables_Table_0_info {
            color: #ffffffbf;
        }
        a#DataTables_Table_0_previous,
        a#DataTables_Table_0_next {
            color: #ffffffbf !important;
        }
        table.dataTable tbody tr {
            background: transparent;
            border-color: #ffffffbf;
        }
        table.dataTable thead tr th {
            border-color: #ffffffbf;
        }

        .my-custom-popup {
            background: rgb(29,40,53, 0.98);
            color: #ffffff80;
            border-radius: 5px;
            padding: 20px;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .my-custom-confirm {
            background: transparent;
            color: #ffffff;
            padding: 5px 16px;
            border: 2px solid #1F8567;
        }
        .my-custom-confirm:hover {
            background: #1F8567 !important;
            color: #ffffff;
            border: 2px solid #1F8567;
        }
        .my-custom-cancel {
            background: transparent;
            color: #ffffff;
            padding: 5px 16px;
            border: 2px solid #be0000;
        }
        .my-custom-cancel:hover {
            background: #be0000 !important;
            color: #ffffff;
            border: 2px solid #be0000;
        }


    </style>
