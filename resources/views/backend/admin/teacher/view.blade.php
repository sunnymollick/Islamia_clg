<div class="row">

    <div class="col-md-3 col-sm-12 table-responsive">


        <a href="{{ asset($teacher->file_path) }}" target="_blank"><img src="{{ asset($teacher->file_path) }}" class="img-responsive img-thumbnail" width="240px"></a>
    </div>


    <div class="col-md-9 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td> Name </td>
                <td> :</td>
                <td> {{ $teacher->name }} </td>
            </tr>

            <tr>
                <td> Code </td>
                <td> :</td>
                <td> {{ $teacher->code }} </td>
            </tr>

            <tr>
                <td> Qualification </td>
                <td> :</td>
                <td> {{ $teacher->qualification }} </td>
            </tr>

            <tr>
                <td> Marital Status </td>
                <td> :</td>
                <td> {{ $teacher->marital_status }} </td>
            </tr>

            <tr>
                <td> Date Of Birth </td>
                <td> :</td>
                <td> {{ $teacher->dob }} </td>
            </tr>


            <tr>
                <td> Date Of Joining </td>
                <td> :</td>
                <td> {{ $teacher->doj }} </td>
            </tr>

            <tr>
                <td> Gender </td>
                <td> :</td>
                <td> {{ $teacher->gender }} </td>
            </tr>


            <tr>
                <td>Religion</td>
                <td> :</td>
                <td> {{ $teacher->religion }} </td>
            </tr>


            <tr>
                <td> Address </td>
                <td> :</td>
                <td> {{ $teacher->address }} </td>
            </tr>


            <tr>
                <td> Phone </td>
                <td> :</td>
                <td> {{ $teacher->phone }} </td>
            </tr>


            <tr>
                <td> Email </td>
                <td> :</td>
                <td> {{ $teacher->email }} </td>
            </tr>

            <tr>
                <td> Designation </td>
                <td> :</td>
                <td> {{ $teacher->designation }} </td>
            </tr>

            
            <tr>
                <td> Status </td>
                <td> :</td>
                <td> @php $status = $teacher->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
            </tr>

            </tbody>
        </table>
    </div>


</div>



