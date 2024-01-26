<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Class</label>
            <select name="std_class_id" id="std_class_id" class="form-control">
                <option value="" disabled>Select Class</option>
                @foreach ($std_classes as $std_class)
                <option value="{{ $std_class->id }}" {{$subject->std_class_id==$std_class->id? 'selected':''}}>{{ $std_class->name }}</option>
                @endforeach
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Section</label>
            <select name="section_id[]" id="section_id" class="form-control select" required   multiple>
                {{-- <option value="" disabled>Select Section</option> --}}
                @foreach ($sections as $section)

                    @php
                        $flag=0;
                        foreach($section_ids as $section_id){
                            if($section_id==$section->id){
                                $flag=1;
                            }
                        }

                    @endphp

                    @if ($flag)
                        <option value="{{ $section->id }}" selected>{{ $section->name }}</option>
                    @else
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endif

                @endforeach

            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $subject->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <input type="hidden" class="form-control" id="subject_id" name="subject_id" value="{{ $subject->id }}" placeholder="" required>


        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Code <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $subject->code }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Order <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="order" name="order" value="{{ $subject->order }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Subject Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="marks" name="marks" value="{{ $subject->marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="pass_marks" name="pass_marks" value="{{ $subject->pass_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Theory Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="theory_marks" name="theory_marks" value="{{ $subject->theory_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Theory Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="theory_pass_marks" name="theory_pass_marks" value="{{ $subject->theory_pass_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Mcq Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="mcq_marks" name="mcq_marks" value="{{ $subject->mcq_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Mcq Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="mcq_pass_marks" name="mcq_pass_marks" value="{{ $subject->mcq_pass_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Practical Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="practical_marks" name="practical_marks" value="{{ $subject->practical_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Practical Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="practical_pass_marks" name="practical_pass_marks" value="{{ $subject->practical_pass_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">CT Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="ct_marks" name="ct_marks" value="{{ $subject->ct_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">CT Pass Marks <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="ct_pass_marks" name="ct_pass_marks" value="{{ $subject->ct_pass_marks }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>



        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $subject->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $subject->status == 0 ) ? 'checked' : '' }}/> In Active
        </div>


        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>



</form>

<script>
    var subject_id = $("#subject_id").val();
    console.log(subject_id);
    var old_section_arr = $("#section_id").val();
    $("#section_id").change(function(){
        var new_section_arr = $(this).val();
        var difference = $(old_section_arr).not(new_section_arr).get();
        console.log(old_section_arr);
        console.log(new_section_arr);
        console.log(difference);
        if (difference != '') {
                $.ajax({
                type: 'GET',
                url: 'deleteSections/' + difference + '/' + subject_id,
                success: function (data) {
                    old_section_arr = new_section_arr;
                    console.log(data);
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        }

    });
</script>

<script>



    $(".select").select2();

    $('#table_field').on('click', '#remove', function(){
        $(this).closest('tr').remove();

    });

    $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });
    $('.button-submit').click(function () {
        // route name and record id
        ajax_submit_update('subjects', "{{ $subject->id }}")
    });




</script>
