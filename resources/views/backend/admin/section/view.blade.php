<div class="row">


    <div class="col-md-12 col-sm-12 table-responsive">
        <table id="view_details" class="table table-bordered table-hover">
            <tbody>



            <tr>
                <td> section Name</td>
                <td> :</td>
                <td> {{ $section->name }} </td>
            </tr>

{{--
            <tr>
                <td>Class</td>
                <td> :</td>
                <td> {{ $section->address }} </td>
            </tr> --}}



            <tr>
                <td> Status </td>
                <td> :</td>
                <td> @php $status = $section->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
            </tr>

            </tbody>
        </table>
    </div>



</div>


