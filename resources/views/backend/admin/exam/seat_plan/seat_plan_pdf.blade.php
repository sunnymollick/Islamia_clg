<head>
    <title>Seat Plan</title>
</head>

<style type="text/css">

    #invoice {
        width: 50%;
        height: 90px;
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
        text-align: center;
        line-height: 3px;
    }

    #instruction {
        clear: both;
        width: 100%;
        line-height: 25px;
    }

    .col-md-12{
        width: 100%;
        /* display: block; */
        /* padding: 5px; */
    }

    .col-md-10 {
        width: 100%;
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

    <div id="invoice" style="float: left;height:130px;">
        <p id="heading"><b><u>{{ $app_settings->name }}</u></b></p>
        <p id="para">Seat Plan</p>
        <div class="col-md-10">
            {{-- <p><b>Class :</b> <?php  echo $std->class_name ; ?> <b>Section :</b> <?php  echo $std->section_name ; ?></p>
            <p><b>Applicant's Roll :</b> <?php  echo $std->roll ; ?></p> --}}
            <table>
                <tr>
                    <td><b>Name: </b><?php  echo $std->student_name ; ?></td>
                    <td></td>
                    <td><b>Class : </b> <?php  echo $std->class_name ; ?></td>
                    {{-- <td></td>
                    <td><b>Section : </b> <?php  echo $std->section_name ; ?></td> --}}
                </tr>
                <tr>
                    <td><b>Section : </b> <?php  echo $std->section_name ; ?></td>
                    <td></td>
                    <td><b>Roll : </b><?php  echo $std->roll ; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div style="<?PHP echo ($i%2 == 0)? 'clear:left': ''; ?>"></div>

    <div class="<?PHP echo ($i%4 == 0)? 'pagebreak' : ''; ?>"> </div>

    <?php } ?>



</div>

</body>



