@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')
    @php
        use App\Helpers\Constant;
        $home_banner = Constant::BANNER_TYPE['home_banner'];
        $banner1 = Constant::BANNER_TYPE['ads_banner1'];
        $banner2 = Constant::BANNER_TYPE['ads_banner2'];
        $banner3 = Constant::BANNER_TYPE['ads_banner3'];
        $banner4 = Constant::BANNER_TYPE['ads_banner4'];
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

                </div>

                <hr class="mb-4">

                <!-- BEGIN Users Form -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-capitalize">adds & social media</h4>
                    </div>
                    <div class="card-body pb-2">
                        <form id="userForm">
                            <div class="row">

                                <div class="col-xl-4">
                                    <!-- home page banner -->
                                    <div class="form-group mb-3">

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="home_banner">Home Page Banner <span class="text-danger">*</span> ( <small>666 X 453</small> )</label>
                                            <input type="file" name="home_banner" class="form-control" id="home_banner">
                                            <span class="text-danger" id="homeBannerError"></span>
                                        </div>

                                        <div id="homeBannerListContainer" class="row">

                                            @foreach (adsBanner($home_banner) as $key => $banner)
                                                <div class="col-xl-3" id="banner_container{{ $banner->id }}">
                                                    <div class="d-flex">
                                                        <div class="img-box position-relative">
                                                            <button id="removeBanner{{ $banner->id }}" onclick="removeBanner({{ $banner->id }});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            <img id="homeBannerPreview{{ $banner->id }}"  src="{{ asset($banner->image ?? 'uploads/banner/banner.jpg') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-xl-12">
                                                <div class="text-end">
                                                    <button type="button" onclick="addHomeBanner();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- banner item 1 -->
                                    <div class="form-group mb-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="url_1">Banner Url ( <small>Show Under Category 1</small> )</label>
                                            <input type="hidden" value="" id="up_id1">
                                            <input type="link" name="url_1" class="form-control mb-3" id="url_1" placeholder="https://www.address.com/..." value="">
                                            <span class="text-danger" id="url1Error"></span>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="banner_1">Ads Banner One <span class="text-danger">*</span> ( <small>584 X 65</small> )</label>
                                            <input type="file" name="banner_1" class="form-control" id="banner_1">
                                            <span class="text-danger" id="banner1Error"></span>
                                        </div>

                                        <div id="bannerListContainer" class="row">

                                            @foreach (adsBanner($banner1) as $key => $banner)
                                                <div class="col-xl-9" id="banner_container{{ $banner->id }}">
                                                    <div class="d-flex">
                                                        <div class="img-box position-relative">
                                                            <button id="removeBanner{{ $banner->id }}" onclick="removeBanner({{ $banner->id }});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            <img id="banner1Preview{{ $banner->id }}" onclick="getLink({{ $banner->id }});" src="{{ asset($banner->image ?? 'uploads/banner/banner.jpg') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-xl-12">
                                                <div class="text-end">
                                                    <button type="button" onclick="addBanner1();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- banner item 2 -->
                                    <div class="form-group mb-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="url_2">Second Banner Url( <small>Show Under Category 2</small> )</label>
                                            <input type="hidden" value="" id="up_id2">
                                            <input type="link" name="url_2" class="form-control mb-3" id="url_2" placeholder="https://www.address.com/..." value="">
                                            <span class="text-danger" id="url2Error"></span>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label" for="banner_2">Ads Banner Two <span class="text-danger">*</span> ( <small>584 X 65</small> )</label>
                                            <input type="file" name="banner_2" class="form-control" id="banner_2">
                                        </div>

                                        <div id="bannerListContainer2" class="row">
                                            @foreach (adsBanner($banner2) as $key => $banner)
                                                <div class="col-xl-9" id="banner_container{{ $banner->id }}">
                                                    <div class="d-flex">
                                                        <div class="img-box position-relative">
                                                            <button id="removeBanner{{ $banner->id }}" onclick="removeBanner({{ $banner->id }});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            <img id="banner2Preview{{ $banner->id }} " onclick="getLink({{ $banner->id }});" src="{{ asset($banner->image ?? 'uploads/banner/banner.jpg') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-xl-12">
                                                <div class="text-end">
                                                    <button type="button" onclick="addBanner2();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="banner2Error"></span>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <!-- banner item 3 -->
                                    <div class="form-group mb-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="url_3">Third Banner Url( <small>Show Under Category 3</small> )</label>
                                            <input type="hidden" value="" id="up_id3">
                                            <input type="link" name="url_3" class="form-control mb-3" id="url_3" placeholder="https://www.address.com/..." value="">
                                            <span class="text-danger" id="url3Error"></span>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label" for="banner_3">Ads Banner Three <span class="text-danger">*</span> ( <small>584 X 65</small> )</label>
                                            <input type="file" name="banner_3" class="form-control" id="banner_3">
                                        </div>

                                        <div id="bannerListContainer3" class="row">
                                            @foreach (adsBanner($banner3) as $key => $banner)
                                                <div class="col-xl-9" id="banner_container{{ $banner->id }}">
                                                    <div class="d-flex">
                                                        <div class="img-box position-relative">
                                                            <button id="removeBanner{{ $banner->id }}" onclick="removeBanner({{ $banner->id }});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            <img id="banner3Preview{{ $banner->id }}" onclick="getLink({{ $banner->id }});" src="{{ asset($banner->image ?? 'uploads/banner/banner.jpg') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-xl-12">
                                                <div class="text-end">
                                                    <button type="button" onclick="addBanner3();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="banner3Error"></span>
                                    </div>

                                    <!-- banner item 2 -->
                                    <div class="form-group mb-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="url_4">Fourth Banner Url ( <small>Last two Ads Banner</small> )</label>
                                            <input type="hidden" value="" id="up_id4">
                                            <input type="link" name="url_4" class="form-control mb-3" id="url_4" placeholder="https://www.address.com/..." value="">
                                            <span class="text-danger" id="url4Error"></span>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label" for="banner_4">Ads Banner Four <span class="text-danger">*</span> ( <small>584 X 65</small> )</label>
                                            <input type="file" name="banner_4" class="form-control" id="banner_4">
                                        </div>

                                        <div id="bannerListContainer4" class="row">
                                            @foreach (adsBanner($banner4) as $key => $banner)
                                                <div class="col-xl-9" id="banner_container{{ $banner->id }}">
                                                    <div class="d-flex">
                                                        <div class="img-box position-relative">
                                                            <button id="removeBanner{{ $banner->id }}" onclick="removeBanner({{ $banner->id }});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                            <img id="banner3Preview{{ $banner->id }}" onclick="getLink({{ $banner->id }});" src="{{ asset($banner->image ?? 'uploads/banner/banner.jpg') }}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-xl-12">
                                                <div class="text-end">
                                                    <button type="button" onclick="addBanner4();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="banner4Error"></span>
                                    </div>
                                </div>

                                <!-- Social Links -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                            <input type="url" name="facebook" class="form-control" placeholder="https://www.facebook.com/yourId" value="{{ $social->facebook ?? '' }}" id="facebook">
                                        </div>
                                        <strong class="text-danger" id="facebookError"></strong>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="twitter" class="form-label">Twitter</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                            <input type="url" name="twitter" class="form-control" placeholder="https://twitter.com/yourId" value="{{ $social->twitter ?? '' }}" id="twitter">
                                        </div>
                                        <strong class="text-danger" id="twitterError"></strong>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="url" name="instagram" class="form-control" placeholder="https://www.instagram.com/yourId/" value="{{ $social->instagram ?? '' }}" id="instagram">
                                        </div>
                                        <strong class="text-danger" id="instagramError"></strong>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="linkedin" class="form-label">Linkedin</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            <input type="url" name="linkedin" class="form-control" placeholder="https://www.linkedin.com/in/yourId/" value="{{ $social->linkedin ?? '' }}" id="linkedin">
                                        </div>
                                        <strong class="text-danger" id="linkedinError"></strong>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="youtube" class="form-label">Youtube</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                            <input type="url" name="youtube" class="form-control" placeholder="https://www.youtube.com/channel/chanelId" value="{{ $social->youtube ?? '' }}" id="youtube">
                                        </div>
                                        <strong class="text-danger" id="youtubeError"></strong>
                                    </div>

                                    {{-- <div class="form-group mb-3">
                                        <label for="tumblr" class="form-label">Tumblr</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-tumblr"></i></span>
                                            <input type="url" name="tumblr" class="form-control" placeholder="https://yourBlog.tumblr.com" value="{{ $social->tumblr ?? '' }}" id="tumblr">
                                        </div>
                                        <strong class="text-danger" id="tumblrError"></strong>
                                    </div> --}}

                                    {{-- <div class="form-group mb-3">
                                        <label for="pinterest" class="form-label">Pinterest</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-pinterest"></i></span>
                                            <input type="url" name="pinterest" class="form-control" placeholder="https://www.pinterest.com/yourId/" value="{{ $social->pinterest ?? '' }}" id="pinterest">
                                        </div>
                                        <strong class="text-danger" id="pinterestError"></strong>
                                    </div> --}}

                                    {{-- <div class="form-group mb-3">
                                        <label for="discord" class="form-label">Discord</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-discord"></i></span>
                                            <input type="url" name="discord" class="form-control" placeholder="https://discord.gg/yourServerInvite" value="{{ $social->discord ?? '' }}" id="discord">
                                        </div>
                                        <strong class="text-danger" id="discordError"></strong>
                                    </div> --}}

                                    <div class="text-end">
                                        <button type="button" onclick="addSocialMedia();" class="btn btn-outline-success"><i class="fa fa-share me-2"></i>Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <x-card-arrow />
                </div>
                <!-- END Users Form -->

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

    function addHomeBanner() {
        let url = "{{ route('admin.settings.pages.store.homePageBanner') }}";

        let home_banner = $('#home_banner')[0].files[0];

        let formData = new FormData();
        formData.append('home_banner', home_banner);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data_id = response['1'];
                let imagepath = response['2'];

                $('#homeBannerError').html('');
                $('#home_banner').val('');
                $('#home_banner').removeClass('is-invalid');

                let baseUrl = "{{ asset('') }}";
                let fullImageUrl = baseUrl + imagepath;

                // Create the new banner HTML
                let newBannerHTML = `
                    <div class="col-xl-3" id="banner_container${data_id}">
                        <div class="d-flex">
                            <div class="img-box position-relative">
                                <button id="removeBanner${data_id}" onclick="removeBanner(${data_id});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img id="homeBannerPreview${data_id}" src="${fullImageUrl}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                            </div>
                        </div>
                    </div>
                `;

                // Append the new banner before the col-xl-12 element
                $('#homeBannerListContainer .col-xl-12').before(newBannerHTML);
                show_success('Banner Added Successfully');
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.banner_1) {
                    $('#homeBannerError').html(errors.banner_1);
                    $('#home_banner').val('');
                    $('#home_banner').addClass('is-invalid');
                }
            }
        });
    }

    function addBanner1() {
        let url = "{{ route('admin.settings.pages.store.banner1') }}";

        let up_id = $('#up_id1').val();
        let url_1 = $('#url_1').val();
        let banner_1 = $('#banner_1')[0].files[0];

        let formData = new FormData();
        formData.append('up_id', up_id);
        formData.append('url_1', url_1);
        formData.append('banner_1', banner_1);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data_id = response['1'];
                let imagepath = response['2'];
                let status = response['3'];
                let image_status = response['4'];

                $('#up_id1').val('');
                $('#url1Error').html('');
                $('#url_1').val('');
                $('#url_1').removeClass('is-invalid');

                $('#banner1Error').html('');
                $('#banner_1').val('');
                $('#banner_1').removeClass('is-invalid');

                let baseUrl = "{{ asset('') }}";
                let fullImageUrl = baseUrl + imagepath;

                // Create the new banner HTML
                let newBannerHTML = `
                    <div class="col-xl-9" id="banner_container${data_id}">
                        <div class="d-flex">
                            <div class="img-box position-relative">
                                <button id="removeBanner${data_id}" onclick="removeBanner(${data_id});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img id="banner1Preview${data_id}" onclick="getLink(${data_id});" src="${fullImageUrl}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                            </div>
                        </div>
                    </div>
                `;

                if (status === 'updated')  {
                    show_success('Banner updated Successfully');
                    if(image_status === 'created')  {
                        $('#banner_container' + data_id).html('');
                        $('#bannerListContainer .col-xl-12').before(newBannerHTML);
                    }
                } else {
                    // Append the new banner before the col-xl-12 element
                    $('#bannerListContainer .col-xl-12').before(newBannerHTML);
                    show_success('Banner Added Successfully');
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.url_1) {
                    $('#url1Error').html(errors.url_1);
                    $('#url_1').val('');
                    $('#url_1').addClass('is-invalid');
                }
                if (errors.banner_1) {
                    $('#banner1Error').html(errors.banner_1);
                    $('#banner_1').val('');
                    $('#banner_1').addClass('is-invalid');
                }
            }
        });
    }
    function addBanner2() {
        let url = "{{ route('admin.settings.pages.store.banner2') }}";

        let up_id2 = $('#up_id2').val();
        let url_2 = $('#url_2').val();
        let banner_2 = $('#banner_2')[0].files[0];

        let formData = new FormData();
        formData.append('up_id', up_id2);
        formData.append('url_2', url_2);
        formData.append('banner_2', banner_2);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data_id = response['1'];
                let imagepath = response['2'];
                let status = response['3'];
                let image_status = response['4'];

                $('#up_id2').val('');
                $('#url2Error').html('');
                $('#url_2').val('');
                $('#url_2').removeClass('is-invalid');

                $('#banner2Error').html('');
                $('#banner_2').val('');
                $('#banner_2').removeClass('is-invalid');

                let baseUrl = "{{ asset('') }}";
                let fullImageUrl = baseUrl + imagepath;

                // Create the new banner HTML
                let newBannerHTML = `
                    <div class="col-xl-9" id="banner_container${data_id}">
                        <div class="d-flex">
                            <div class="img-box position-relative">
                                <button id="removeBanner${data_id}" onclick="removeBanner(${data_id});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img id="banner2Preview${data_id}" onclick="getLink(${data_id});"  src="${fullImageUrl}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                            </div>
                        </div>
                    </div>
                `;

                if (status === 'updated')  {
                    show_success('Banner updated Successfully');
                    if(image_status === 'created')  {
                        $('#banner_container' + data_id).html('');
                        $('#bannerListContainer2 .col-xl-12').before(newBannerHTML);
                    }
                } else {
                    // Append the new banner before the col-xl-12 element
                    $('#bannerListContainer2 .col-xl-12').before(newBannerHTML);
                    show_success('Banner Added Successfully');
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.url_2) {
                    $('#url1Error').html(errors.url_2);
                    $('#url_2').val('');
                    $('#url_2').addClass('is-invalid');
                }
                if (errors.banner_2) {
                    $('#banner2Error').html(errors.banner_2);
                    $('#banner_2').val('');
                    $('#banner_2').addClass('is-invalid');
                }
            }
        });
    }
    function addBanner3() {
        let url = "{{ route('admin.settings.pages.store.banner3') }}";

        let up_id3 = $('#up_id3').val();
        let url_3 = $('#url_3').val();
        let banner_3 = $('#banner_3')[0].files[0];

        let formData = new FormData();
        formData.append('up_id', up_id3);
        formData.append('url_3', url_3);
        formData.append('banner_3', banner_3);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data_id = response['1'];
                let imagepath = response['2'];
                let status = response['3'];
                let image_status = response['4'];

                $('#up_id3').val('');
                $('#url3Error').html('');
                $('#url_3').val('');
                $('#url_3').removeClass('is-invalid');

                $('#banner3Error').html('');
                $('#banner_3').val('');
                $('#banner_3').removeClass('is-invalid');

                let baseUrl = "{{ asset('') }}";
                let fullImageUrl = baseUrl + imagepath;

                // Create the new banner HTML
                let newBannerHTML = `
                    <div class="col-xl-9" id="banner_container${data_id}">
                        <div class="d-flex">
                            <div class="img-box position-relative">
                                <button id="removeBanner${data_id}" onclick="removeBanner(${data_id});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img id="banner3Preview${data_id}" onclick="getLink(${data_id});"  src="${fullImageUrl}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                            </div>
                        </div>
                    </div>
                `;

                if (status === 'updated')  {
                    show_success('Banner updated Successfully');
                    if(image_status === 'created')  {
                        $('#banner_container' + data_id).html('');
                        $('#bannerListContainer3 .col-xl-12').before(newBannerHTML);
                    }
                } else {
                    // Append the new banner before the col-xl-12 element
                    $('#bannerListContainer3 .col-xl-12').before(newBannerHTML);
                    show_success('Banner Added Successfully');
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.url_3) {
                    $('#url3Error').html(errors.url_3);
                    $('#url_3').val('');
                    $('#url_3').addClass('is-invalid');
                }
                if (errors.banner_3) {
                    $('#banner3Error').html(errors.banner_3);
                    $('#banner_3').val('');
                    $('#banner_3').addClass('is-invalid');
                }
            }
        });
    }
    function addBanner4() {
        let url = "{{ route('admin.settings.pages.store.banner4') }}";

        let up_id4 = $('#up_id4').val();
        let url_4 = $('#url_4').val();
        let banner_4 = $('#banner_4')[0].files[0];

        let formData = new FormData();
        formData.append('up_id', up_id4);
        formData.append('url_4', url_4);
        formData.append('banner_4', banner_4);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data_id = response['1'];
                let imagepath = response['2'];
                let status = response['3'];
                let image_status = response['4'];

                $('#up_id4').val('');
                $('#url3Error').html('');
                $('#url_4').val('');
                $('#url_4').removeClass('is-invalid');

                $('#banner4Error').html('');
                $('#banner_4').val('');
                $('#banner_4').removeClass('is-invalid');

                let baseUrl = "{{ asset('') }}";
                let fullImageUrl = baseUrl + imagepath;

                // Create the new banner HTML
                let newBannerHTML = `
                    <div class="col-xl-9" id="banner_container${data_id}">
                        <div class="d-flex">
                            <div class="img-box position-relative">
                                <button id="removeBanner${data_id}" onclick="removeBanner(${data_id});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove Banner" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img id="banner3Preview${data_id}" onclick="getLink(${data_id});"  src="${fullImageUrl}" alt="image-Preview" class="w-100 d-block rounded mt-3">
                            </div>
                        </div>
                    </div>
                `;

                if (status === 'updated')  {
                    show_success('Banner updated Successfully');
                    if(image_status === 'created')  {
                        $('#banner_container' + data_id).html('');
                        $('#bannerListContainer4 .col-xl-12').before(newBannerHTML);
                    }
                } else {
                    // Append the new banner before the col-xl-12 element
                    $('#bannerListContainer4 .col-xl-12').before(newBannerHTML);
                    show_success('Banner Added Successfully');
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors.url_4) {
                    $('#url4Error').html(errors.url_4);
                    $('#url_4').val('');
                    $('#url_4').addClass('is-invalid');
                }
                if (errors.banner_4) {
                    $('#banner4Error').html(errors.banner_4);
                    $('#banner_4').val('');
                    $('#banner_4').addClass('is-invalid');
                }
            }
        });
    }

    const bannerType1 = {{ $banner1 }};
    const bannerType2 = {{ $banner2 }};
    const bannerType3 = {{ $banner3 }};
    const bannerType4 = {{ $banner4 }};
    function getLink(id){
        url = "{{ route('ajax.get.banners', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                 switch (data.banner_type) {
                    case bannerType1:
                        $('#url_1').val(data.url);
                        $('#up_id1').val(data.id);
                        break;
                    case bannerType2:
                        $('#url_2').val(data.url);
                        $('#up_id2').val(data.id);
                        break;
                    case bannerType3:
                        $('#url_3').val(data.url);
                        $('#up_id3').val(data.id);
                        break;
                    case bannerType4:
                        $('#url_4').val(data.url);
                        $('#up_id4').val(data.id);
                        break;
                    default:
                        console.error('Unknown banner type:', data.banner_type);
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                show_error('Failed to load data');
            }
        });
    }

    function addSocialMedia() {
        // Set up the URL for info update route
        let url = "{{ route('admin.settings.pages.storeOrUpdate') }}";

        let facebook = $('#facebook').val();
        let twitter = $('#twitter').val();
        let instagram = $('#instagram').val();
        let linkedin = $('#linkedin').val();
        let youtube = $('#youtube').val();
        let tumblr = $('#tumblr').val();
        let pinterest = $('#pinterest').val();
        let discord = $('#discord').val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                facebook: facebook,
                twitter: twitter,
                instagram: instagram,
                linkedin: linkedin,
                youtube: youtube,
                tumblr: tumblr,
                pinterest: pinterest,
                discord: discord,
            },
            success: function(data) {
                resetError();
                show_success('Save Changes Successfully');
            },
            error: function(error) {
                resetError();
                let errors = error.responseJSON.errors;
                if(errors.facebook) {
                    $('#facebookError').html(errors.facebook);
                }
                if(errors.twitter) {
                    $('#twitterError').html(errors.twitter);
                }
                if(errors.instagram) {
                    $('#instagramError').html(errors.instagram);
                }
                if(errors.linkedin) {
                    $('#linkedinError').html(errors.linkedin);
                }
                if(errors.youtube) {
                    $('#youtubeError').html(errors.youtube);
                }
                if(errors.tumblr) {
                    $('#tumblrError').html(errors.tumblr);
                }
                if(errors.pinterest) {
                    $('#pinterestError').html(errors.pinterest);
                }
                if(errors.discord) {
                    $('#discordError').html(errors.discord);
                }

            }
        });
    }
    // SocialMedia Reset
    function resetError() {
        $('#facebookError').html('');
        $('#twitterError').html('');
        $('#instagramError').html('');
        $('#linkedinError').html('');
        $('#youtubeError').html('');
        $('#tumblrError').html('');
        $('#pinterestError').html('');
        $('#discordError').html('');
    }

    // Remove Image
    function removeBanner(id) {
        let url = "{{ route('admin.settings.pages.removeBanner', ':id') }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: `Are you sure you want to remove this banner?`,
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
                    type: 'Delete',
                    dataType: 'JSON',
                    success: function(data) {
                        $('#banner_container' + id).remove();
                        show_success('Banner removed successfully.');
                    },
                    error: function(error) {
                        let message = error.responseJSON.message || 'An error occurred';
                        show_error(message);
                    }
                });
            }
        });
    }


</script>
@endpush
