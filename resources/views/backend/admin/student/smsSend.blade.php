<form class="d-flex justify-content-center" id='create' action="" enctype="multipart/form-data" method="post"
      accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div>
        <div id="" class="col-md-12">
            <div class="form-group col-md-6 col-sm-12" style="min-width: 450px;">
                <label for="class">Class<span style="color: red;">*</span></label>
                <select id="class" class="js-example-basic-multiple" name="class_id"
                        multiselect-search="true" multiselet-select-all="true" required
                        style="outline: #96C8DA">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
                <div id="class_all_clear" style="display: inline; position: absolute; top: 35px; right: 20px;"><i
                            style="cursor: pointer;"
                            class="fa fa-times-circle" aria-hidden="true" style=""></i></div>
                <span class="has-error"></span>

            </div>
            <div class="clearfix"></div>

            <div class="form-group col-md-6 col-sm-12" style="min-width: 450px;">
                <label for="section">Section<span style="color: red;">*</span></label>
                <select id="section" style="height: 100%" class="js-example-basic-multiple" name="sections_id[]"
                        multiple="multiple"
                        multiselect-search="true" multiselet-select-all="true" 
                        style="outline: #96C8DA" required>
                </select>
                <div id="section_all_clear" style="display: inline; position: absolute; top: 35px; right: 20px;"><i
                            class="fa fa-times-circle" aria-hidden="true" style="cursor: pointer;"></i></div>
                <span class="has-error"></span>

            </div>
            <div class="clearfix"></div>

            <div class="form-group col-md-6 col-sm-12" style="min-width: 450px;">
                <label for="student_names">Student name</label>
                <select id="student_names" style="height: 100%" class="js-example-basic-multiple"
                        name="students_id[]"
                        multiple="multiple"
                        multiselect-search="true" multiselet-select-all="true"
                        style="outline: #96C8DA">
                </select>
                <div id="student_all_clear" style="display: inline; position: absolute; top: 35px; right: 20px;"><i
                            class="fa fa-times-circle" aria-hidden="true" style="cursor: pointer;"></i></div>
                <span class="has-error"></span>

            </div>
            <div class="clearfix"></div>

            <div class="form-group col-md-6 col-sm-12" style="min-width: 450px;">
                <label for="message">Message<span style="color: red;">*</span></label>
                <textarea type="text" class="form-control" id="message" name="message" value="" placeholder="" required></textarea>
                <span class="has-error"></span>
            </div>
            <div class="form-group col-md-12">
                <button id="sms-btn" type="submit" class="btn btn-success button-submit1"
                        data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Send
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        let classBox = $('#class');
        let sessionBox = $('#session');
        let sectionBox = $('#section');
        let student_namesBox = $('#student_names');
        let classButton = $('#class_all_clear');
        let sectionButton = $('#section_all_clear');
        let studentButton = $('#student_all_clear');

        selectSelectBox(classBox, classButton);
        selectSelectBox(sectionBox, sectionButton);
        selectSelectBox(student_namesBox, studentButton);

        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        //onchange of classBox
        classBox.change(function () {

            sectionBox.empty();

            let classId = classBox.val();

            if (classId) {
                $.ajax({
                    type: 'GET',
                    url: 'sections/classes/' + classId + '/getSectionsForSms',
                    success: function (data) {
                        $.each(data.data, function (i, val) {
                        sectionBox.append(new  Option(val.name, val.id))
                        } );
                    },
                    error: function (result) {
                        // $("#modal_data").html("Sorry Cannot Load Data");
                    }
                });
            }
        });

        //onChange of sectionBox
        sectionBox.change(function () {
            student_namesBox.empty();
            $.ajax({
                url: 'students/getStudents',
                type: "GET",
                data: {
                    'sections' : sectionBox.val()
                },
                dataType: 'json',

                success: function (data) {

                    $.each(data.data, function (i, val) {
                        student_namesBox.append(new Option(val.name, val.id))
                    });
                },
                error: function (result) {

                }
            })
        });

    });


    function selectSelectBox(selectBox, btn) {
        selectBox.focus(function (e) {
            selectBox.css('outline', '2px solid #96C8DA');
            selectBox.css('border', 'none');
        });

        selectBox.select2();
        btn.click(function (e) {
            selectBox.val('');
            selectBox.select2();
        })

    }

    ajax_submit_smsSend('students');
</script>
