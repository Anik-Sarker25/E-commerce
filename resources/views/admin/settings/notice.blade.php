@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')
    @php
        $activeStatus = App\Helpers\Constant::STATUS;
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
                        <button type="button" onclick="showCollapse();" class="btn btn-outline-success">
                            Add Notice
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="noticeFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize">add notice</h4>
                        </div>
                        <div class="card-body pb-2">
                            <form id="noticeForm">
                                <div class="form-group mb-3">
                                    <input type="hidden" id="update_id" value="">
                                    <label class="form-label" for="notice_video">Notice Video ( <small>Aim to keep files under 5MB for quick loading</small> )</label>
                                    <input type="file" name="notice_video" class="form-control" id="notice_video">
                                    <div id="videoBox">
                                    </div>
                                    <span class="text-danger" id="noticeVideoError"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">Notice Content</label>
                                    <div class="card">
                                        <textarea name="description" id="description"  placeholder="Design Your Desirable Content..." class="form-control summernote" rows="5">{{ $data->address ?? '' }}</textarea>
                                        <x-card-arrow />
                                    </div>

                                    <span class="text-danger" id="descriptionError"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="status">Status (default active)</label>
                                    <select class="form-select" name="status" id="status">
                                        @foreach ($activeStatus as $status => $key)
                                            <option value="{{$key }}">{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="statusError"></span>
                                </div>

                                <div class="mb-3">
                                    <button type="button" onclick="addNotice();" class="btn btn-outline-success"id="addBtn"><i class="fa fa-plus me-2"></i>Add Notice</button>
                                    <button type="button" onclick="updateNotice();" class="btn btn-outline-success d-none me-2" id="updateBtn"><i class="fa fa-share me-2"></i>Update Notice</button>
                                    <button type="button" onclick="resetNotice();" class="btn btn-outline-danger d-none" id="cancelBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th style="width: 15%;">Video</th>
                                        <th style="width: 50%;">Content</th>
                                        <th>Status</th>
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
    $(document).ready(function () {
        $('.summernote').summernote({minHeight: 250});
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        var dataTable;

        dataTable = $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 5,
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
                    data: 'notice_video',
                    name: 'notice_video',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'content',
                    name: 'content',
                    className: 'text-left',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                    orderable: false
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

    function showCollapse() {
        $('#noticeFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#videoBox').html('');
        $('#noticeVideoError').text('');
        $('#notice_video').removeClass('is-invalid');
        $('#description').summernote('code', '');
        $('#descriptionError').text('');
        $('#description').removeClass('is-invalid');

        $('#statusError').text('');

        $('#addBtn').removeClass('d-none');
        $('#updateBtn').addClass('d-none');
        $('#cancelBtn').addClass('d-none');
    }

    function addNotice() {
        let url = "{{ route('admin.settings.notices.store') }}";

        let notice_video = $('#notice_video')[0].files[0];
        let description = $('#description').summernote('code').trim();
        let status = $('#status').val();

        if (!notice_video && (!description || description === '<p><br></p>' || description === '<br>')) {
            $('#noticeVideoError').text('Please provide either a video or content.');
            return;
        }
        // Prepare form data
        let formData = new FormData();
        formData.append('notice_video', notice_video);
        formData.append('description', description);
        formData.append('status', status);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetNotice();
                show_success('Notice Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.notice_video) {
                    $('#noticeVideoError').text(errors.notice_video);
                    $('#notice_video').val('');
                    $('#notice_video').addClass('is-invalid');
                }
                if (errors.content) {
                    $('#descriptionError').text(errors.content);
                    $('#description').summernote('code', '');
                    $('#description').addClass('is-invalid');
                }
                if(errors.status) {
                    $('#statusError').text(errors.status);
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.settings.notices.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#update_id').val('');
                $('#videoBox').html('');
                $('#description').summernote('code', '');

                $('#noticeFormBox').addClass('show');
                $('#update_id').val(data.id);

                if(data.notice_video) {
                    let assetBaseUrl = "{{ asset('') }}";
                    let videoHTML = `
                        <div class="d-flex">
                            <div class="img-box position-relative">
                                <button onclick="removeVideo(${data.id});" class="btn position-absolute top-0 start-100 p-0 text-danger" title="Remove-video" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <video class="rounded mt-2" controls style="width: 200px;">
                                    <source src="${assetBaseUrl}${data.notice_video}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    `;
                    $('#videoBox').html(videoHTML);
                }

                $('#description').summernote('code', data.content);
                $('#status').val(data.status).trigger('change');

                $('#addBtn').addClass('d-none');
                $('#updateBtn').removeClass('d-none');
                $('#cancelBtn').removeClass('d-none');
            }

        });
    }

    function updateNotice() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.settings.notices.update', ':id') }}";
        url = url.replace(':id', update_id);

        let notice_video = $('#notice_video')[0].files[0];
        let description = $('#description').summernote('code').trim();
        let status = $('#status').val();

        if (!description || description === '<p><br></p>' || description === '<br>') {
            $('#descriptionError').text('Content is required!.');
            return;
        }
        // Prepare form data
        let formData = new FormData();
        formData.append('notice_video', notice_video);
        formData.append('description', description);
        formData.append('status', status);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetNotice();
                show_success('Notice Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.notice_video) {
                    $('#noticeVideoError').text(errors.notice_video);
                    $('#notice_video').val('');
                    $('#notice_video').addClass('is-invalid');
                }
                if (errors.content) {
                    $('#descriptionError').text(errors.content);
                    $('#description').summernote('code', '');
                    $('#description').addClass('is-invalid');
                }
                if(errors.status) {
                    $('#statusError').text(errors.status);
                }
            }
        });
    }

    function removeVideo(id) {
        let url = "{{ route('admin.settings.notices.removeVideo', ':id') }}";
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
                        resetNotice();
                        show_success('Video deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the video. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function destroy(id) {
        let url = "{{ route('admin.settings.notices.destroy', ':id') }}";
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
                        show_success('Notice deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the notice. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetNotice() {
        $('#noticeVideoError').text('');
        $('#notice_video').val('');
        $('#notice_video').removeClass('is-invalid');

        $('#videoBox').html('');

        $('#descriptionError').text('');
        $('#description').summernote('code', '');
        $('#description').removeClass('is-invalid');

        $('#statusError').text('');

        $('#noticeFormBox').removeClass('show');

        $('#addBtn').removeClass('d-none');
        $('#updateBtn').addClass('d-none');
        $('#cancelBtn').addClass('d-none');
    }


</script>
@endpush
