<head>
    <title>Admin Card</title>
</head>

<style type="text/css">

    #invoice {

        width: 50%;
        height: 235px;
        display: block;
        padding: 5px;
        font-family: sans-serif, Arial, Verdana, "Trebuchet MS";
        border: 2px dotted #808991;
    }

    #heading {
        text-align: center;
        margin-top: 0%
    }

    #para {
        line-height: 5px;
        font-size: 15px;
    }

    #instruction {
        clear: both;
        width: 100%;
        line-height: 25px;
    }

    .col-md-12{
        width: 100%;
        margin: 0px;
        /* display: block; */
        /* padding: 5px; */
    }

    .col-md-10 {
        width: 100%;
        float: left;
        position: relative;
        line-height: 30px;
    }

    .col-md-2 {
        width: 20%;
        float: left;
        margin-right: 20px;
        position: relative;
    }

    .text-bold {
        width: 200px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 15px;
    }
    table{
        width: 100%;
        border-collapse: collapse;

    }
    @media print {
    .pagebreak { page-break-brfore: always; } /* page-break-after works, as well */
    }
</style>

<body style="page-break-after: auto">

<div id="col-md-12">
    <?php
    $i=0;
    foreach ($students as $std) {
        $i++;
    ?>

    <div id="invoice" style="float: left;">
        <p id="heading"><b><u>{{ $app_settings->name }}</u></b></p>
        <p id="heading">Admit Card</p>
        {{-- <div id="heading">
            <h3>{{ $app_settings->name }}</h3>
            <hr/>
        </div> --}}
        {{-- <div id="para">
            <h2>Admit Card</h2>
        </div> --}}
        <div class="col-md-10">

            <p style="margin-top:0%;" id="para"><b>Applicant's Name :</b> <?php  echo $std->student_name ; ?></p>
            <p id="para"><b>Class :</b> <?php  echo $std->class_name ; ?></p>
            <p id="para"><b>Section :</b> <?php  echo $std->section_name ; ?></p>
            <p id="para"><b>Applicant's Roll :</b> <?php  echo $std->roll ; ?></p>
            <p id="para"><b>Exam Name :</b> <?php  echo $std->exam_name ; ?></p>

            <p style="float: right;border-top:1px solid black;">Principal's Signature</p>
            {{-- <table>
                <tr>
                    <td class="text-bold">Applicant's Name</td>
                    <td>:</td>
                    <td><?php  echo $std->student_name ; ?></td>
                </tr>
                <tr>
                    <td class="text-bold">Class</td>
                    <td>:</td>
                    <td><?php  echo $std->class_name ; ?></td>
                </tr>
                <tr>
                    <td class="text-bold">Section</td>
                    <td>:</td>
                    <td><?php  echo $std->section_name ; ?></td>
                </tr>
                <tr>
                    <td class="text-bold">Applicant's Roll</td>
                    <td>:</td>
                    <td><?php  echo $std->roll ; ?></td>
                </tr>
                <tr>
                    <td class="text-bold">Exam Name</td>
                    <td>:</td>
                    <td><?php  echo $std->exam_name ; ?></td>
                </tr>
            </table> --}}
        </div>
        <div id="instruction">
            {{-- <h4>General Instructions</h4>
            <ul>
                <li>Each candidate must bring the printed copy of this admit card in the exam hall</li>
                <li>Candidate should be present in the exam center 30 minutes before the exam starts</li>
                <li>Carrying any kind of electronic devices like phone is strongly prohibited</li>
            </ul> --}}

        </div>
    </div>

    <div style="<?PHP echo ($i%2 == 0)? 'clear:left': ''; ?>"></div>

    <div class="<?PHP echo ($i%4 == 0)? 'pagebreak' : ''; ?>"> </div>

    <?php } ?>



</div>

</body>



