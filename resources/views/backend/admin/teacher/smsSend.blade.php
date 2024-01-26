<style>
    .js-example-basic-multiple {
        border: 2px solid black;
        outline: #4CAF50 solid 10px !important;
        margin: auto;
        padding: 20px;
        text-align: center;
    }
</style>
<form class="d-flex justify-content-center" id='create' action="" enctype="multipart/form-data" method="post"
      accept-charset="utf-8" class="needs-validation"
      novalidate>

    <div id="status"></div>
    <div id="" class="col-md-12">


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Select Names<span style="color: red;">*</span></label>
            <select class="js-example-basic-multiple" name="teachers_numbers[]" multiple="multiple" multiselect-search="true"  multiselet-select-all="true" required
                    style="outline: #96C8DA">
                <option value="all">Select All</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->phone }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
            <div id="all_clear" style="display: inline; position: absolute; top: 35px; right: 20px;"><i
                        class="fa fa-times-circle" aria-hidden="true" style=""></i></div>

        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Message<span style="color: red;">*</span></label>
            <textarea type="text" class="form-control" id="message" name="message" value=""
                      placeholder="" required></textarea>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="form-group col-md-12">
            <button id="sms-btn" type="submit" class="btn btn-success button-submit1"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Send
            </button>
        </div>
    </div>
    <p id="sendSms"></p>
</form>

<script>
    $(document).ready(function () {
        let selectBox = $('.js-example-basic-multiple');
        selectBox.focus(function (e) {
            selectBox.css('outline', '2px solid #96C8DA');
            selectBox.css('border', 'none');
        });

        selectBox.select2();
        $('#all_clear').click(function (e) {
            selectBox.val('');
            selectBox.select2();
        })


    });

    ajax_submit_smsSend('teachers');
    // let selectBox = $('.js-example-basic-multiple');
    // selectBox.val('');
    // selectBox.select2();
    $('#doj').datepicker();
    $('#dob').datepicker();
</script>