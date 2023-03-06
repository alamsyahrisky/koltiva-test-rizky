@extends('layouts.admin')

@section('title','Dashboard - User')

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


@if ($message = Session::get('error'))
<div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
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
            <h3 class="card-label">Tes Logic
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
        </div>
    </div>
    <div class="card-body">
        @if ($total > 0)
            
        <ul class="nav nav-tabs nav-tabs-line">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">Result</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">Reference</a>
            </li>
        </ul>
        <div class="tab-content mt-5" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered table-checkable" id="table-user">
                            <thead>
                                <tr>
                                    <th>Age</th>
                                    <th>Year</th>
                                    <th>Result</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $item)
                                    <tr>
                                        <td>Tahun ke {{$item->age}}</td>
                                        <td>{{$item->year}}</td>
                                        <td>{{$item->result}}</td>
                                        <td>
                                            <form action="{{route('logic-destroy',$item->id)}}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h2>Rata-rata : <span class="text-primary">{{$result ? $result->avg : '-'}}</span></h2>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                <table class="table table-bordered table-checkable" id="table-user">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Text</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($temporary as $item)
                            <tr>
                                <td>Tahun ke {{$item->year}}</td>
                                <td>{{$item->text}}</td>
                                <td>{{$item->result}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <form action="{{route('logic-store')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Masukkan Jumlah tahun</label>
                    <input type="number" min="1" step="1" required name="jumlah_tahun"  class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
            </form>
        @endif
    </div>
</div>

{{-- form --}}
<div class="modal fade" id="modal-create" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="{{route('logic-create')}}" method="POST" autocomplete="off" id="form-create" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Masukkan Usia Kematian</label>
                        <input type="number" name="age" class="form-control" required min="1" step="1" />
                    </div>
                    <div class="form-group">
                        <label>Masukkan Tahun Kematian</label>
                        <input type="number" name="year" class="form-control" required min="1" step="1" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-light-primary btn-reset font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection