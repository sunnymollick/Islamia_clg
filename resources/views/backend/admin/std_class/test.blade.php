<div class="row">


    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>

            <tr>
                    <td> Session Name</td>
                    <td> :</td>
                    <td> {{ $std_class->session->name }} </td>
            </tr>

            <tr>
                <td> Class Name</td>
                <td> :</td>
                <td> {{ $std_class->name }} </td>
            </tr>
            <table>
                <thead>
                    <th>new</th>
                    <th>new</th>
                    <th>new</th>
                    <th>new</th>
                </thead>
                <tbody>
                    <td>Lorem ipsum dolor sit.</td>
                    <td>Lorem ipsum dolor sit.</td>
                    <td>Lorem ipsum dolor sit.</td>
                    <td>Lorem ipsum dolor sit.</td>
                </tbody>
            </table>


            <tr>
                <td> Status </td>
                <td> :</td>
                <td> @php $status = $std_class->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
            </tr>

            </tbody>
        </table>
    </div>



</div>


