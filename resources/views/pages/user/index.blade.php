@extends('layouts.admin')

@section('title','User')

@push('new-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')

    @if ($message = Session::get('success'))
    <div class="alert alert-custom alert-light-success fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon2-quotation-mark"></i></div>
        <div class="alert-text">
            <p>{{$message}}</p>
        </div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
    @endif
    
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">Data @yield('title')
            </div>
            <div class="card-toolbar">
                <a href="javascript:;" data-toggle="modal" data-target="#modal-create" class="btn btn-primary font-weight-bolder mx-1">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>Add</a>

                <a href="javascript:;" onclick="onRefresh()" class="btn btn-success font-weight-bolder mx-1">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Refresh</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-checkable" id="table-user">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
    
    @push('new-script')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(function () {
            window.table = $('#table-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'  
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'name', 
                        name: 'name'
                    },
                    {
                        data: 'email', 
                        name: 'email',
                    },
                    {
                        data: 'image', 
                        name: 'image',
                        render: function (data, type) {
                          return `
                          <div class="symbol symbol-50 symbol-lg-100">
                            <img src="${(data != null ? '../storage/'+data : '../backend/dist/assets/media/error/no-image.png')}" class="w-100" alt="">
                        </div>
                          `;  
                        },
                    },
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ],
                initComplete: function(settings, json) {
                    
                }
            });

            window.table.on('draw', function () {
                $('.show_confirm').click(function(event) {
                    var form =  $(this).closest("form");
                    event.preventDefault();
                    swal({
                        title: `Confirm`,
                        text: "Are you sure you want to delete this record?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                                $.ajax({
                                url: $(form).attr('action'),
                                data: $(form).serialize(),
                                type: "POST",
                                dataType: 'json',
                                success: function (data) {
                                    if (data.status) {
                                        Swal.fire({
                                            text: "Successfully deleted data",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Oke",
                                            customClass: {
                                                confirmButton: "btn font-weight-bold btn-light-primary"
                                            }
                                        }).then(function() {
                                            window.table.ajax.reload();
                                        });
                                    }else{
                                        let errorList = [];
                                        $.each(data.errors, function (key, val) {
                                            errorList.push(val)
                                        });
                                        Swal.fire({
                                            text: errorList.join(),
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn font-weight-bold btn-light-primary"
                                            }
                                        });
                                    }
                                
                                }
                            });
                        }
                    });
                })

                $('.btn_update').click(function(event) {
                    event.preventDefault();

                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let email = $(this).data('email');
        
                    
                    $('#form-edit').attr('action','{{url("admin/user")}}'+'/'+id);
                    
                    $('#modal-edit').modal('show')
                    
                    $('#form-edit #email').val(email)
                    $('#form-edit #name').val(name)
                    
                })
            });
        });

        onRefresh = () => {
            window.table.ajax.reload();
        }
    </script>
@endpush

@include('pages.user.create')
@include('pages.user.edit')