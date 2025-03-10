<script>
    function getCountry() {
        url = "{{ route('ajax.get.country') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Country</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '"' + (value.id === 1 ? ' selected' : '') + '>' + value.name + '</option>';
                });

                $('#country').html(html);
            }
        });
    }

    function getDivision() {
        url = "{{ route('ajax.get.division') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Division</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#division').html(html);
            }
        });
    }

    function division() {
        $('#division').change(function(){
            let division = $(this).val();
            url = "{{ route('ajax.get.district', ':division') }}";
            url = url.replace(':division', division);
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    var html = '';
                    html += '<option value="">Select District</option>';
                    $.each(data, function(index, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#district').html(html);
                }
            });
        });
    }

    function district() {
        $('#district').change(function(){
            let district = $(this).val();
            url = "{{ route('ajax.get.upazila', ':district') }}";
            url = url.replace(':district', district);
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    var html = '';
                    html += '<option value="">Select Upazila</option>';
                    $.each(data, function(index, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#upazila').html(html);
                }
            });
        });
    }

    function upazila(){
        $('#upazila').change(function(){
            let upazila = $(this).val();
            url = "{{ route('ajax.get.union', ':upazila') }}";
            url = url.replace(':upazila', upazila);
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    var html = '';
                    html += '<option value="">Select Union</option>';
                    $.each(data, function(index, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#union').html(html);
                }
            });
        });
    }

    function getCategory() {
        url = "{{ route('ajax.get.category') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Category</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });

                $('#category_id').html(html);
            }
        });
        $("#category_id").select2({
            placeholder: "Select Category",
            width: '100%',
            allowClear: true,
        });
    }

    function getSubCategory(categoryId) {
        let url = "{{ route('ajax.get.subCategory', ':id') }}";
        url = url.replace(':id', categoryId);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Sub Category</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });

                $('#subcategory_id').html(html);
            }
        });
        $("#subcategory_id").select2({
            placeholder: "Select Sub Category",
            width: '100%',
            allowClear: true,
        });
    }

    function getChildCategory(subcategoryId) {
        let url = "{{ route('ajax.get.childCategory', ':id') }}";
        url = url.replace(':id', subcategoryId);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Child Category</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });

                $('#childcategory_id').html(html);
            }
        });
        $("#childcategory_id").select2({
            placeholder: "Select Child Category",
            width: '100%',
            allowClear: true,
        });
    }

    function getAllSubCategory() {
        url = "{{ route('ajax.get.allSubCategory') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Sub Category</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });

                $('#allSubcategory_id').html(html);
            }
        });
        $("#allSubcategory_id").select2({
            placeholder: "Select Subcategory",
            width: '100%',
            allowClear: true,
        });
    }

    function getBrand() {
        url = "{{ route('ajax.get.brand') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                html += '<option value="">Select Brand</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });

                $('#brand_id').html(html);
            }
        });
        $("#brand_id").select2({
            placeholder: "Select Brand",
            width: '100%',
            allowClear: true,
        });
    }

    function getDeliveryType() {
        url = "{{ route('ajax.get.delivery_type') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var html = '';
                // html += '<option value="">Select Type</option>';
                $.each(data, function(index, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });

                $('#delivery_type').html(html);
            }
        });
        $("#delivery_type").select2({
            placeholder: "Select Type",
            width: '100%',
            allowClear: true,
        });
    }


</script>
