@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')
@php
    $variantType = App\Helpers\Constant::VARIANT_TYPES;
@endphp
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
                        <button type="button" onclick="showVariantsForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="variantsFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addVariantsTitle">add variants & stocks</h4>
                            <h4 class="text-capitalize d-none" id="updateVariantsTitle">Update variants & stocks</h4>
                        </div>
                        <div class="card-body pb-2">
                            <form id="variantsForm">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="product_id">Select Product</label>
                                            <input type="hidden" id="update_id" value="">
                                            <select name="product_id"  class="form-control select2" id="product_id">
                                            </select>
                                            <span class="text-danger" id="product_idError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="color_family">Color Family</label>
                                            <select name="color_family"  class="form-control select2" id="color_family">
                                            </select>
                                            <span class="text-danger" id="color_familyError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="variant_type">Variant Type</label>
                                            <select name="variant_type"  class="form-control select2" id="variant_type">
                                                @foreach ($variantType as $value => $key)
                                                <option value="{{ $key }}">{{ ucfirst(str_replace('_', ' ', $value)) }}</option>
                                                @endforeach

                                            </select>
                                            <span class="text-danger" id="variant_typeError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="variant_value" id="variant_value_label">Variant size</label>
                                            <input type="text" name="variant_value" class="form-control" id="variant_value">
                                            <span class="text-danger" id="variant_valueError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="buy_price">Buy Price <span class="text-danger">*</span></label>
                                            <input type="number" name="buy_price" class="form-control" id="buy_price" placeholder="Enter Buy Price...">
                                            <span class="text-danger" id="buy_priceError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mrp_price">MRP Price <span class="text-danger">*</span></label>
                                            <input type="number" name="mrp_price" class="form-control" id="mrp_price" placeholder="Enter MRP Price...">
                                            <span class="text-danger" id="mrp_priceError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="discount_price">Discount Price <span class="text-danger">(%) *</span></label>
                                            <input type="number" name="discount_price" class="form-control" id="discount_price" placeholder="Enter Discount Price...">
                                            <span class="text-danger" id="discount_priceError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="sell_price">Sell Price <span class="text-danger">*</span></label>
                                            <input type="number" name="sell_price" class="form-control" id="sell_price" placeholder="Enter Sell Price..." readonly>
                                            <span class="text-danger" id="sell_priceError"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="stock">Stock Quantity<span class="text-danger">*</span></label>
                                            <input type="number" name="stock" class="form-control" id="stock" value="1">
                                            <span class="text-danger" id="stockError"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <button type="button" onclick="addVariant();" class="btn btn-outline-success" id="addVariantBtn"><i class="fa fa-plus me-2"></i>Add Variant</button>
                                    <button type="button" onclick="updateVariant();" class="btn btn-outline-success d-none me-2" id="updateVariantBtn"><i class="fa fa-share me-2"></i>Update Variant</button>
                                    <button type="button" onclick="resetVariant();" class="btn btn-outline-danger" id="cancelVariantBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th style="width: 20%;">Product Name</th>
                                        <th>Variant Value</th>
                                        <th>Color Family</th>
                                        <th>Variant Type</th>
                                        <th>Buy Price</th>
                                        <th>MRP Price</th>
                                        <th>Discount Price</th>
                                        <th>Sell Price</th>
                                        <th>Stock Quantity</th>
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
    @php
        $variantTypes = App\Helpers\Constant::VARIANT_TYPES;
        $labelMap = [];
        foreach ($variantTypes as $key => $val) {
            $labelMap[$val] = ucwords(str_replace('_', ' ', $key));
        }
    @endphp
@endsection

@push('js')
    @include('layouts.admin.all_select2')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        getProducts();

        $('#product_id').on('change', function () {
            const productId = $(this).val();

            if (productId) {
                getProductColor(productId);
                getProductPrice(productId);

            } else {
                $('#buy_price').val('');
                $('#mrp_price').val('');
                $('#discount_price').val('');
                $('#sell_price').val('');
                $('#color_family').empty();
            }
        });

        // Variants Type Label Selection
        const labelMap = @json($labelMap);

        $('#variant_type').on('change', function () {
            const selectedVal = $(this).val();
            const labelText = labelMap[selectedVal] || 'Variant';
            $('#variant_value_label').text(labelText + ' Value');
        });

        $('#variant_type').trigger('change');

        // Product price Calculations
        $('#buy_price, #mrp_price, #discount_price').on('input', function() {
            calculateSellPrice();
        });

        // Stock Quantity Validation
        $('#stock').on('input', function() {
            const stockQuantity = parseInt($('#stock').val()) || 0;
            if (stockQuantity < 0) {
                $('#stock').val(0); // Reset to 0 if negative
                $('#stockError').text("Stock quantity cannot be negative.");
            } else {
                $('#stockError').text('');
            }
        });


    });

    // function to calculate product prices
    function calculateSellPrice() {
        const buyPrice = parseFloat($('#buy_price').val()) || 0;
        const mrpPrice = parseFloat($('#mrp_price').val()) || 0;
        const discountPercentage = parseFloat($('#discount_price').val()) || 0;

        let discountAmount = (mrpPrice * (discountPercentage / 100));

        let sellPrice = mrpPrice - discountAmount;

        // Ensure sell price isn’t below buy price
        if (sellPrice < buyPrice) {
            $('#sell_priceError').text("Sell Price cannot be less then buy Price");
            $('#sell_price').val(buyPrice.toFixed(2));

        }else {
            $('#sell_priceError').text("");
            $('#sell_price').val(sellPrice.toFixed(2));
        }

    }



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
                    data: 'product_id',
                    name: 'product_id',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'variant_value',
                    name: 'variant_value',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'color_family',
                    name: 'color_family',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'variant_type',
                    name: 'variant_type',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'buy_price',
                    name: 'buy_price',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'mrp_price',
                    name: 'mrp_price',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'discount_price',
                    name: 'discount_price',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'sell_price',
                    name: 'sell_price',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'stock',
                    name: 'stock',
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

    function showVariantsForm() {
        $('#variantsFormBox').collapse('toggle');

        resetVariant();

        $('#addVariantsTitle').removeClass('d-none');
        $('#updateVariantsTitle').addClass('d-none');

        $('#addVariantBtn').removeClass('d-none');
        $('#updateVariantBtn').addClass('d-none');
    }

    function addVariant() {
        let url = "{{ route('admin.products.variants.store') }}";

        let product_id = $('#product_id').val();
        let color_family = $('#color_family').val();
        let variant_type = $('#variant_type').val();
        let variant_value = $('#variant_value').val();
        let buy_price = $('#buy_price').val();
        let mrp_price = $('#mrp_price').val();
        let discount_price = $('#discount_price').val();
        let sell_price = $('#sell_price').val();
        let stock = $('#stock').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('product_id', product_id);
        formData.append('color_family', color_family);
        formData.append('variant_type', variant_type);
        formData.append('variant_value', variant_value);
        formData.append('buy_price', buy_price);
        formData.append('mrp_price', mrp_price);
        formData.append('discount_price', discount_price);
        formData.append('sell_price', sell_price);
        formData.append('stock', stock);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetVariant();

                if(response === 'updated') {
                    show_success('Variants Updated Successfully!');
                }else if(response === 'created') {
                    show_success('Variants Added Successfully!');
                }else if(response === 'duplicated') {
                    show_error('Variants Already Exits');
                }
                
                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {

                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

                let errors = error.responseJSON.errors;
                for (let key in errors) {
                    // Check if the field is a select element
                    if ($(`#${key}`).is('select')) {
                        $(`#${key}Error`).html(errors[key]);
                    } else {
                        $(`#${key}Error`).html(errors[key]);
                        $(`#${key}`).val('');
                        $(`#${key}`).addClass('is-invalid');
                    }
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.products.variants.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                $('#variantsFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#product_id').val(data.product_id).trigger('change');
                setTimeout(() => {
                    $('#color_family').val(data.color_family).trigger('change');
                }, 500);
                $('#variant_type').val(data.variant_type).trigger('change');
                $('#variant_value').val(data.variant_value);
                $('#stock').val(data.stock);

                $('#addVariantsTitle').addClass('d-none');
                $('#updateVariantsTitle').removeClass('d-none');

                $('#addVariantBtn').addClass('d-none');
                $('#updateVariantBtn').removeClass('d-none');
                $('#cancelVariantBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateVariant() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.products.variants.update', ':id') }}";
        url = url.replace(':id', update_id);

        let product_id = $('#product_id').val();
        let color_family = $('#color_family').val();
        let variant_type = $('#variant_type').val();
        let variant_value = $('#variant_value').val();
        let buy_price = $('#buy_price').val();
        let mrp_price = $('#mrp_price').val();
        let discount_price = $('#discount_price').val();
        let sell_price = $('#sell_price').val();
        let stock = $('#stock').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('product_id', product_id);
        formData.append('color_family', color_family);
        formData.append('variant_type', variant_type);
        formData.append('variant_value', variant_value);
        formData.append('buy_price', buy_price);
        formData.append('mrp_price', mrp_price);
        formData.append('discount_price', discount_price);
        formData.append('sell_price', sell_price);
        formData.append('stock', stock);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetVariant();
                show_success('Variants Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {

                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

                let errors = error.responseJSON.errors;
                for (let key in errors) {
                    // Check if the field is a select element
                    if ($(`#${key}`).is('select')) {
                        $(`#${key}Error`).html(errors[key]);
                    } else {
                        $(`#${key}Error`).html(errors[key]);
                        $(`#${key}`).val('');
                        $(`#${key}`).addClass('is-invalid');
                    }
                }
            }
        });
    }

    function destroy(id) {
        let url = "{{ route('admin.products.variants.destroy', ':id') }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: 'transparent',
            cancelButtonColor: 'transparent',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'my-custom-popup',
                confirmButton: 'my-custom-confirm',
                cancelButton: 'my-custom-cancel',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'JSON',
                    success: function(data) {
                        show_success('Variant Deleted Successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the variant. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetVariant() {
        $('#update_id').val('');
        $('#product_idError').text('');
        $('#product_id').val('').trigger('change');

        $('#color_familyError').text('');
        $('#color_family').val('').trigger('change');

        $('#variant_typeError').text('');
        $('#variant_type').val('').trigger('change');

        $('#variant_valueError').text('');
        $('#variant_value').val('');
        $('#variant_value').removeClass('is-invalid');

        $('#buy_priceError').html('');
        $('#buy_price').val('');
        $('#buy_price').removeClass('is-invalid');

        $('#mrp_priceError').html('');
        $('#mrp_price').val('');
        $('#mrp_price').removeClass('is-invalid');

        $('#discount_priceError').html('');
        $('#discount_price').val('');
        $('#discount_price').removeClass('is-invalid');

        $('#sell_priceError').html('');
        $('#sell_price').val('');
        $('#sell_price').removeClass('is-invalid');

        $('#stockError').html('');
        $('#stock').val('');
        $('#stock').removeClass('is-invalid');

        $('#variantsFormBox').collapse('toggle');

        $('#addVariantsTitle').removeClass('d-none');
        $('#updateVariantsTitle').addClass('d-none');

        $('#addVariantBtn').removeClass('d-none');
        $('#updateVariantBtn').addClass('d-none');
    }


</script>
@endpush
