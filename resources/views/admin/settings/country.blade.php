@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-12 -->
            <div class="col-xl-12">
                <x-breadcrumbs :items="$breadcrumbs" />

                <div class="d-flex justify-content-between">
                    <h1 class="page-header text-capitalize mb-0">{{ $pageTitle }}</h1>
                    <div class="btn-group">
                        {{-- <button type="button" onclick="showcountryForm();" class="btn btn-outline-success">
                            Add New
                        </button> --}}
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="countryFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize">update country</h4>
                        </div>
                        <div class="card-body pb-2">
                            <form id="countryForm">
                                <div class="form-group mb-3">
                                    <input type="hidden" id="update_id" value="">
                                    <label class="form-label" for="country">Select Country</label>
                                    <select name="country"  class="form-control select2" id="country">
                                        <option value="" selected>Select Country</option>
                                    </select>
                                    <span class="text-danger" id="countryError"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="currency">Currency</label>
                                    <input type="text" id="currency" name="currency" class="form-control">
                                    <span class="text-danger" id="currencyError"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="symbol">Symbol</label>
                                    <input type="text" id="symbol" name="symbol" class="form-control">
                                    <span class="text-danger" id="symbolError"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="timezone">Time Zone</label>
                                    <input type="text" id="timezone" name="timezone" class="form-control">
                                    <span class="text-danger" id="timezoneError"></span>
                                </div>

                                <div class="mb-3">
                                    <button type="button" onclick="updateCountry();" class="btn btn-outline-success me-2" id="updateCountryBtn"><i class="fa fa-share me-2"></i>Update Country</button>
                                    <button type="button" onclick="resetCountry();" class="btn btn-outline-danger" id="canceCountryBtn"><i class="fa fa-times me-2"></i>Cencel</button>
                                </div>

                            </form>
                        </div>
                        <x-card-arrow />
                    </div>
                </div>
                <!-- END Notice Form -->


                <!-- Notice Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover DataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Country Name</th>
                                        <th>Currency</th>
                                        <th>Symbol</th>
                                        <th>TimeZone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <x-card-arrow />
                </div>

            </div>
            <!-- END col-12-->
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        const countryDropdown = $('#country');
        const currencyInput = $('#currency');
        const symbolInput = $('#symbol');
        const timezoneInput = $('#timezone');

        // Fetch all countries from REST Countries API
        fetch('https://restcountries.com/v3.1/all?fields=name,currencies,timezones')
            .then(response => response.json())
            .then(data => {
                // Sort countries alphabetically by name
                data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                data.forEach(country => {
                    try {
                        // Get currency code and symbol safely
                        const currencyCode = country.currencies ? Object.keys(country.currencies)[0] : 'N/A';
                        const currencySymbol = country.currencies && country.currencies[currencyCode]?.symbol
                            ? country.currencies[currencyCode].symbol
                            : 'N/A';

                        // Get timezone safely
                        const timezone = country.timezones && country.timezones.length
                            ? country.timezones[0]
                            : 'N/A';

                        // Create and append the option
                        const option = new Option(country.name.common, country.name.common);
                        $(option).data('info', {
                            currency: currencyCode,
                            symbol: currencySymbol,
                            timezone: timezone
                        });

                        countryDropdown.append(option);
                    } catch (err) {
                        console.warn('Failed to process country:', country.name?.common, err);
                    }
                });

            })
            .catch(error => console.error('Error fetching country data:', error));

        // Update fields based on selected country
        countryDropdown.on('change', function () {
            const selectedOption = $(this).find(':selected');
            const countryInfo = selectedOption.data('info');

            if (countryInfo) {
                currencyInput.val(countryInfo.currency);
                symbolInput.val(countryInfo.symbol);
                timezoneInput.val(countryInfo.timezone);
            } else {
                currencyInput.val('');
                symbolInput.val('');
                timezoneInput.val('');
            }
        });
    });

    $(function() {
        var dataTable;

        dataTable = $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: [
                // 'copy',
                'excel',
                'csv',
                'pdf',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(.print-disabled)'
                    }
                },
                'reset',
            ],
            ajax: {
                url: "{{ url()->current() }}",
                data: function(d) {
                    // Add any additional parameters if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the error, e.g., display a message or take appropriate action
                    console.error("Error: " + textStatus, errorThrown);
                    alert('Failed to load data. Please try again.'); // Notify user
                },
            },
            columns: [
                {
                    data: 'sl',
                    name: 'sl',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'currency',
                    name: 'currency',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'symbol',
                    name: 'symbol',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'timezone',
                    name: 'timezone',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center print-disabled',
                    orderable: false
                }
            ],
            responsive: true
        });

    });

    // Custom reset button extension
    $.fn.dataTable.ext.buttons.reset = {
        text: '<i class="fas fa-undo d-inline"></i> Reset',
        action: function (e, dt, node, config) {
            dt.search('').draw(); // Reset the search input
            dt.ajax.reload(); // Reload the data
        }
    };

    function edit(id) {
        var url = "{{ route('admin.settings.countries.edit', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#countryFormBox').addClass('show');
                $('#update_id').val(data.id);

                $('#country').val(data.name).trigger('change');
            },
            error: function(error) {
                console.error("Error fetching data:", error);
            }
        });
    }


    function updateCountry() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.settings.countries.update', ':id') }}";
        url = url.replace(':id', update_id);

        let country = $('#country').val();
        let currency = $('#currency').val();
        let symbol = $('#symbol').val();
        let timezone = $('#timezone').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('country', country);
        formData.append('currency', currency);
        formData.append('symbol', symbol);
        formData.append('timezone', timezone);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                resetCountry();
                show_success('Country Data Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.country) {
                    $('#countryError').text(errors.country);
                    $('#country').val('').trigger('change');
                }
                if(errors.currency) {
                    $('#currencyError').text(errors.currency);
                    $('#currency').val('');
                    $('#currency').addClass('is-invalid');
                }
                if(errors.symbol) {
                    $('#symbolError').text(errors.symbol);
                    $('#symbol').val('');
                    $('#symbol').addClass('is-invalid');
                }
                if(errors.timezone) {
                    $('#timezoneError').text(errors.timezone);
                    $('#timezone').val('');
                    $('#timezone').addClass('is-invalid');
                }
            }
        });
    }

    function resetCountry() {
        $('#update_id').val('');
        $('#countryError').text('');
        $('#country').val('').trigger('change');

        $('#currencyError').text('');
        $('#currency').val('');
        $('#currency').removeClass('is-invalid');

        $('#symbolError').text('');
        $('#symbol').val('');
        $('#symbol').removeClass('is-invalid');

        $('#timezoneError').text('');
        $('#timezone').val('');
        $('#timezone').removeClass('is-invalid');

        $('#countryFormBox').removeClass('show');
    }


</script>
@endpush
