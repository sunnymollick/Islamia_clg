<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">

        <div class="form-group col-md-4 col-sm-12"> 
            <label for="">Class</label>
            <select name="std_class_id" id="std_class_id" class="form-control" required onchange="getSection(this.value)">
                <option value=""  selected disabled>Select Class</option>
                @foreach ($std_classes as $std_class)
                    <option value="{{ $std_class->id }}">{{ $std_class->name }}</option>
                @endforeach
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Section</label>
            <select name="section_id[]" id="section_id" class="form-control select" required   multiple>
                {{-- <option value="" disabled>Select Section</option> --}}

            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Code <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Order <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="order" name="order" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="marks" name="marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="pass_marks" name="pass_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Theory Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="theory_marks" name="theory_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Theory Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="theory_pass_marks" name="theory_pass_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Mcq Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="mcq_marks" name="mcq_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Mcq Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="mcq_pass_marks" name="mcq_pass_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Practical Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="practical_marks" name="practical_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Practical Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="practical_pass_marks" name="practical_pass_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">CT Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="ct_marks" name="ct_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">CT Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="ct_pass_marks" name="ct_pass_marks" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</form>

<script>

    $(".select").select2();

    $('.button-submit').click(function () {
        // route name
        ajax_submit_store('subjects')
    });

    function getSection(std_class_id){
            $("#section_id").empty();
            $("#loader").show();
            $.ajax({
                type: 'GET',
                url: 'getSection/' + std_class_id,
                success: function (data) {
                    $("#loader").hide();
                    $("#section_id").html(data);
                },
                error: function (result) {
                    $("#section_id").html("Sorry Cannot Load Data");
                }
            });
    }


</script>
