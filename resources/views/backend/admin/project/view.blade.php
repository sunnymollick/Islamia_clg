<div class="row">


    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>

            <tr>
                <td> Company Name</td>
                <td> :</td>
                <td> {{ $project->client->name }} </td>
            </tr>

            <tr>
                <td> Project Name</td>
                <td> :</td>
                <td> {{ $project->name }} </td>
            </tr>


            <tr>
                <td>Address</td>
                <td> :</td>
                <td> {{ $project->address }} </td>
            </tr>



            <tr>
                <td> Status </td>
                <td> :</td>
                <td> @php $status = $project->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
            </tr>

            </tbody>
        </table>
    </div>



</div>


