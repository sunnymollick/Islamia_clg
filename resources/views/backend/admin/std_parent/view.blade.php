<div class="row">

    <div class="col-md-3 col-sm-12 table-responsive">


        <a href="{{ asset($std_parent->file_path) }}" target="_blank"><img src="{{ asset($std_parent->file_path) }}" class="img-responsive img-thumbnail" width="240px"></a>
    </div>


    <div class="col-md-9 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td> Name </td>
                <td> :</td>
                <td> {{ $std_parent->name }} </td>
            </tr>


            <tr>
                <td> Date Of Birth </td>
                <td> :</td>
                <td> {{ $std_parent->dob }} </td>
            </tr>



            <tr>
                <td> Gender </td>
                <td> :</td>
                <td> {{ $std_parent->gender }} </td>
            </tr>


            <tr>
                <td>Religion</td>
                <td> :</td>
                <td> {{ $std_parent->religion }} </td>
            </tr>


            <tr>
                <td> Address </td>
                <td> :</td>
                <td> {{ $std_parent->address }} </td>
            </tr>


            <tr>
                <td> Phone </td>
                <td> :</td>
                <td> {{ $std_parent->phone }} </td>
            </tr>


            <tr>
                <td> Email </td>
                <td> :</td>
                <td> {{ $std_parent->email }} </td>
            </tr>



            <tr>
                <td> Status </td>
                <td> :</td>
                <td> @php $status = $std_parent->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
            </tr>

            </tbody>
        </table>
    </div>


</div>



