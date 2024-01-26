@extends('backend.layouts.master')
@section('title', 'Student')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Student Information</div>
            </div>
        </div>
    </div>

    <div class="row">

    <div class="col-md-3 col-sm-12 table-responsive">


        <a href="{{ asset($student->file_path) }}" target="_blank"><img src="{{ asset($student->file_path) }}" class="img-responsive img-thumbnail" width="240px"></a>
    </div>


    <div class="col-md-9 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td> Name </td>
                <td> :</td>
                <td> {{ $student->name }} </td>
            </tr>

            <tr>
                <td> Code </td>
                <td> :</td>
                <td> {{ $student->code }} </td>
            </tr>



            <tr>
                <td> Marital Status </td>
                <td> :</td>
                <td> {{ $student->marital_status }} </td>
            </tr>

            <tr>
                <td> Date Of Birth </td>
                <td> :</td>
                <td> {{ $student->dob }} </td>
            </tr>




            <tr>
                <td> Gender </td>
                <td> :</td>
                <td> {{ $student->gender }} </td>
            </tr>


            <tr>
                <td>Religion</td>
                <td> :</td>
                <td> {{ $student->religion }} </td>
            </tr>


            <tr>
                <td> Address </td>
                <td> :</td>
                <td> {{ $student->address }} </td>
            </tr>


            <tr>
                <td> Phone </td>
                <td> :</td>
                <td> {{ $student->phone }} </td>
            </tr>


            <tr>
                <td> Email </td>
                <td> :</td>
                <td> {{ $student->email }} </td>
            </tr>



            <tr>
                <td> Status </td>
                <td> :</td>
                <td> @php $status = $student->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
            </tr>

            </tbody>
        </table>
    </div>


</div>



@stop


