@extends('backend.layouts.master')
@section('title', ' All Exam')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Qr Code
                    </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="not_found">
                                {{-- <img src="{{asset('assets/images/empty_box.png')}}" width="200px"> --}}
                                {!! QrCode::size(300)->generate('http://127.0.0.1:8000/admin/student-info/'.$id) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 80%;
                border-radius: 5px;
            }
        }

        #not_found {
            margin-top: 30px;
            z-index: 0;
        }
    </style>

@stop
