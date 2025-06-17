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
                        <button type="button" onclick="storeOrUpdate();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save Changes</button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Settings Form -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-capitalize">company information & SEO settings</h4>
                    </div>
                    <div class="card-body pb-2">
                        <form id="userForm">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="company_name">Company Name</label>
                                        <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter Company Name..." value="{{ $data->company_name ?? '' }}">
                                        <span class="text-danger" id="companyNameError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="company_motto">Company Motto</label>
                                        <input type="text" name="company_motto" class="form-control" id="company_motto" placeholder="Enter Company Motto..." value="{{ $data->company_motto ?? '' }}">
                                        <span class="text-danger" id="companyMottoError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="phone_number">Phone Number ( <small>Use comma ' , ' for Multiple Numbers</small> )</label>
                                        <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="01XXXXXXXXX" value="{{ $data->phone ?? '' }}">
                                        <span class="text-danger" id="phoneError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="example@example.com" value="{{ $data->email ?? '' }}">
                                        <span class="text-danger" id="emailError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="address">Address</label>
                                        <textarea name="address" id="address"  placeholder="Enter Address..." class="form-control" rows="2">{{ $data->address ?? '' }}</textarea>
                                        <span class="text-danger" id="addressError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="delivery_partner">Delivery Partner</label>
                                        <input name="delivery_partner" id="delivery_partner"  placeholder="Enter Partner Name...." class="form-control" value="{{ $data->delivery_partner ?? '' }}">
                                        <span class="text-danger" id="delivery_partnerError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="map">Google Map Embed link</label>
                                        <input type="link" name="map" class="form-control" id="map" placeholder="https://www.google.com/maps/embed?.." value="{{ $data->map ?? '' }}">
                                        <span class="text-danger" id="mapError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="timezone">System Timezone</label>
                                        <select name="timezone" class="form-select" id="timezone"></select>
                                        <span class="text-danger" id="timeZoneError"></span>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="system_name">System Name</label>
                                        <input type="text" name="system_name" class="form-control" id="system_name" placeholder="Enter System Name..." value="{{ $data->system_name ?? '' }}">
                                        <span class="text-danger" id="systemNameError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="logo">Site Logo ( <small>193 X 44</small> )</label>
                                        <input type="file" name="logo" class="form-control" id="logo">

                                        <div class="d-flex">
                                            <div class="img-box position-relative" style="width: 193px;">
                                                <button id="removeLogo" onclick="removeImage('site_logo');" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Site logo" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <img id="logoPreview" src="{{ asset($data->site_logo ??'uploads/settings/image.png') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                            </div>
                                        </div>
                                        <span class="text-danger" id="logoError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="favicon">Favicon ( <small>64 X 64</small> )</label>
                                        <input type="file" name="favicon" class="form-control" id="favicon">

                                        <div class="d-flex">
                                            <div class="img-box position-relative" style="width: 36px;">
                                                <button id="removeFavicon" onclick="removeImage('favicon');" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Favicon" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <img id="faviconPreview" src="{{ asset($data->favicon ??'uploads/settings/favicon.png') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                            </div>
                                        </div>
                                        <span class="text-danger" id="faviconError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="admin_logo">Admin Logo ( <small>200 X 200</small> )</label>
                                        <input type="file" name="admin_logo" class="form-control" id="admin_logo">

                                        <div class="d-flex">
                                            <div class="img-box position-relative" style="width: 48px;">
                                                <button id="removeAdminLogo" onclick="removeImage('admin_logo');" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Admin Logo" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <img id="adminLogoPreview" src="{{ asset($data->admin_logo ??'uploads/settings/admin-logo.png') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                            </div>
                                        </div>
                                        <span class="text-danger" id="adminLogoError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="copyright">Copyrights</label>
                                        <input type="text" name="copyright" class="form-control" id="copyright" placeholder="Copyright © 2016 All Rights Reserved." value="{{ $data->copyright ?? '' }}">
                                        <span class="text-danger" id="copyrightError"></span>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="site_title">meta Title</label>
                                        <input type="text" name="site_title" class="form-control" id="site_title" placeholder="Enter Title..." value="{{ $data->site_title ?? '' }}">
                                        <span class="text-danger" id="titleError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="meta_description">meta Description ( <small>Max 255 words</small> )</label>
                                        <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Enter Company Motto..." value="{{ $data->meta_description ?? '' }}">
                                        <span class="text-danger" id="metaDescriptionError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="meta_keywords">meta Keywords ( <small>Use ' , ' for Seperate Keywords</small> )</label>
                                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="2">{{ $data->meta_keywords ?? '' }}</textarea>
                                        <span class="text-danger" id="metaKeywordsError"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="about_company">About Company ( <small>Max 255 words</small> )</label>
                                        <textarea name="about_company" id="about_company" class="form-control" rows="2" placeholder="Write a Short Description...">{{ $data->about_company ?? '' }}</textarea>
                                        <span class="text-danger" id="aboutCompanyError"></span>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="meta_image">meta Image</label>
                                        <input type="file" name="meta_image" class="form-control" id="meta_image">

                                        <div class="d-flex">
                                            <div class="img-box position-relative" style="width: 36px;">
                                                <button id="metaImage" onclick="removeImage('meta_image');" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Admin Logo" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <img id="metaImagePreview" src="{{ asset($data->meta_image ??'uploads/settings/admin-logo.png') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                            </div>
                                        </div>
                                        <span class="text-danger" id="metaImageError"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <x-card-arrow />
                </div>
                <!-- END Settings Form -->

            </div>
            <!-- END col-12-->
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection

@push('js')
{{-- @include('layouts.admin.all_select2') --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function timezoneSelect() {
        let databaseTimezone = "{{ $data->timezone }}";
        let timezones = Intl.supportedValuesOf('timeZone');
        let timezoneSelect = $('#timezone');

        timezones.forEach(zone => {
            let option = $('<option></option>').val(zone).text(zone);
            timezoneSelect.append(option);
        });
        if (timezones.includes(databaseTimezone)) {
            timezoneSelect.val(databaseTimezone);
        } else {
            timezoneSelect.val(Intl.DateTimeFormat().resolvedOptions().timeZone);
        }
    }
    timezoneSelect();

    function storeOrUpdate() {

        let url = "{{ route('admin.settings.storeOrUpdate') }}";

        let company_name = $('#company_name').val();
        let company_motto = $('#company_motto').val();
        let phone_number = $('#phone_number').val();
        let email = $('#email').val();
        let address = $('#address').val();
        let delivery_partner = $('#delivery_partner').val();
        let map = $('#map').val();
        let timezone = $('#timezone').val();
        let system_name = $('#system_name').val();
        let logo = $('#logo')[0]?.files[0];
        let favicon = $('#favicon')[0]?.files[0];
        let admin_logo = $('#admin_logo')[0]?.files[0];
        let copyright = $('#copyright').val();
        let site_title = $('#site_title').val();
        let meta_description = $('#meta_description').val();
        let meta_keywords = $('#meta_keywords').val();
        let about_company = $('#about_company').val();
        let meta_image = $('#meta_image')[0]?.files[0];

        let formData = new FormData();
        formData.append('company_name', company_name);
        formData.append('company_motto', company_motto);
        formData.append('phone_number', phone_number);
        formData.append('email', email);
        formData.append('address', address);
        formData.append('delivery_partner', delivery_partner);
        formData.append('map', map);
        formData.append('timezone', timezone);
        formData.append('system_name', system_name);
        formData.append('logo', logo);
        formData.append('favicon', favicon);
        formData.append('admin_logo', admin_logo);
        formData.append('copyright', copyright);
        formData.append('site_title', site_title);
        formData.append('meta_description', meta_description);
        formData.append('meta_keywords', meta_keywords);
        formData.append('about_company', about_company);
        formData.append('meta_image', meta_image);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data = response[0];
                let status = response[1];

                let baseUrl = "{{ asset('') }}";

                if (status === 'logo') {
                    $('#logo').val('');
                    let fullImageUrl = baseUrl + data.site_logo;
                    $('#logoPreview').attr('src', fullImageUrl);
                }
                if (status === 'favicon') {
                    $('#favicon').val('');
                    let fullImageUrl = baseUrl + data.favicon;
                    $('#faviconPreview').attr('src', fullImageUrl);
                }
                if (status === 'admin_logo') {
                    $('#admin_logo').val('');
                    let fullImageUrl = baseUrl + data.admin_logo;
                    $('#adminLogoPreview').attr('src', fullImageUrl);
                }
                if (status === 'meta_image') {
                    $('#meta_image').val('');
                    let fullImageUrl = baseUrl + data.meta_image;
                    $('#metaImagePreview').attr('src', fullImageUrl);
                }
                resetErrors();
                show_success('Save Changes Successfully');
            },
            error: function(error) {
                let errors = error.responseJSON.errors;

                if (errors.company_name) {
                    $('#companyNameError').html(errors.company_name);
                    $('#company_name').val('');
                    $('#company_name').addClass('is-invalid');
                }
                if (errors.company_motto) {
                    $('#companyMottoError').html(errors.company_motto);
                    $('#company_motto').val('');
                    $('#company_motto').addClass('is-invalid');
                }
                if (errors.phone_number) {
                    $('#phoneError').html(errors.phone_number);
                    $('#phone_number').val('');
                    $('#phone_number').addClass('is-invalid');
                }
                if (errors.email) {
                    $('#emailError').html(errors.email);
                    $('#email').val('');
                    $('#email').addClass('is-invalid');
                }
                if (errors.address) {
                    $('#addressError').html(errors.address);
                    $('#address').val('');
                    $('#address').addClass('is-invalid');
                }
                if (errors.map) {
                    $('#mapError').html(errors.map);
                    $('#map').val('');
                    $('#map').addClass('is-invalid');
                }
                if (errors.timezone) {
                    $('#timeZoneError').html(errors.timezone);
                    $('#timezone').val('').trigger('change');
                }
                if (errors.system_name) {
                    $('#systemNameError').html(errors.system_name);
                    $('#system_name').val('');
                    $('#system_name').addClass('is-invalid');
                }
                if (errors.logo) {
                    $('#logoError').html(errors.logo);
                    $('#logo').addClass('is-invalid');
                }
                if (errors.favicon) {
                    $('#faviconError').html(errors.favicon);
                    $('#favicon').addClass('is-invalid');
                }
                if (errors.admin_logo) {
                    $('#adminLogoError').html(errors.admin_logo);
                    $('#admin_logo').addClass('is-invalid');
                }
                if (errors.copyright) {
                    $('#copyrightError').html(errors.copyright);
                    $('#copyright').val('');
                    $('#copyright').addClass('is-invalid');
                }
                if (errors.site_title) {
                    $('#siteTitleError').html(errors.site_title);
                    $('#site_title').val('');
                    $('#site_title').addClass('is-invalid');
                }
                if (errors.meta_description) {
                    $('#metaDescriptionError').html(errors.meta_description);
                    $('#meta_description').val('');
                    $('#meta_description').addClass('is-invalid');
                }
                if (errors.meta_keywords) {
                    $('#metaKeywordsError').html(errors.meta_keywords);
                    $('#meta_keywords').val('');
                    $('#meta_keywords').addClass('is-invalid');
                }
                if (errors.about_company) {
                    $('#aboutCompanyError').html(errors.about_company);
                    $('#about_company').val('');
                    $('#about_company').addClass('is-invalid');
                }
                if (errors.meta_image) {
                    $('#metaImageError').html(errors.meta_image);
                    $('#meta_image').addClass('is-invalid');
                }
            }
        });
    }

    // Remove Image
    function removeImage(imageType) {
        let url = "{{ route('admin.settings.removeImage') }}";

        Swal.fire({
            title: `Are you sure you want to remove the ${imageType}?`,
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
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        image_type: imageType,
                    },
                    success: function(data) {
                        show_success(data.message);
                        if (imageType === 'site_logo') {
                            $('#logoPreview').attr('src', '{{ asset('uploads/settings/image.png') }}');
                        }
                        if (imageType === 'favicon') {
                            $('#faviconPreview').attr('src', '{{ asset('uploads/settings/favicon.png') }}');
                        }
                        if (imageType === 'admin_logo') {
                            $('#adminLogoPreview').attr('src', '{{ asset('uploads/settings/admin-logo.png') }}');
                        }
                        if (imageType === 'meta_image') {
                            $('#metaImagePreview').attr('src', '{{ asset('uploads/settings/image.png') }}');
                        }
                    },
                    error: function(error) {
                        let message = error.responseJSON.message || 'An error occurred';
                        show_error(message);
                    }
                });
            }
        });
    }

    function resetErrors() {
        // Reset error messages
        $('#companyNameError').html('');
        $('#companyMottoError').html('');
        $('#phoneError').html('');
        $('#emailError').html('');
        $('#addressError').html('');
        $('#mapError').html('');
        $('#timezoneError').html('');
        $('#systemNameError').html('');
        $('#logoError').html('');
        $('#faviconError').html('');
        $('#adminLogoError').html('');
        $('#copyrightError').html('');
        $('#siteTitleError').html('');
        $('#metaDescriptionError').html('');
        $('#metaKeywordsError').html('');
        $('#aboutCompanyError').html('');
        $('#metaImageError').html('');

        // Reset input classes
        $('#company_name').removeClass('is-invalid');
        $('#company_motto').removeClass('is-invalid');
        $('#phone_number').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#address').removeClass('is-invalid');
        $('#map').removeClass('is-invalid');
        $('#system_name').removeClass('is-invalid');
        $('#logo').removeClass('is-invalid');
        $('#favicon').removeClass('is-invalid');
        $('#admin_logo').removeClass('is-invalid');
        $('#copyright').removeClass('is-invalid');
        $('#site_title').removeClass('is-invalid');
        $('#meta_description').removeClass('is-invalid');
        $('#meta_keywords').removeClass('is-invalid');
        $('#about_company').removeClass('is-invalid');
        $('#meta_image').removeClass('is-invalid');
    }
</script>
@endpush
