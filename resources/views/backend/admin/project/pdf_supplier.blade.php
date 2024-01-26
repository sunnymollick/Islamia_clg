<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body style="page-break-after: auto">







    <div class="row">
        <div class="col_1"><img src="{{ asset('assets\images\favicon.png') }}" width="100px" hight="100px" alt=""></div>

        <div class="col_2">
            <p style="font-size: 13px;">বিসমিল্লাহির রাহমানির রাহিম</p>
            <h1 style="font-size: 30px;margin-top: 25px;">নিউ আমিন অ্যান্ড সন্স</h1>
            <p style="line-height: 13px;">প্রো মোঃ বাদশা মিয়া ও আব্দুল হক</p>
            <p style="line-height: 13px;">আমদানি ও রপ্তানিকারক এন্ড কমিশন এজেন্ট  কাঁচা  ও পাকা মালের দোকান ।</p>
            <p style="line-height: 13px;">হাটখোলা রোড, আড়ৎপট্টি, যশোর। </p>
        </div>

        <div class="col_3">
            <p style="font-size: 13px;">বাদশা মিয়া</p>
            <p style="font-size: 15px;">০১৯১৭-০৯২৮০৪</p>
            <p style="font-size: 15px;">০১৮৩৬-৬৪৭১৭৮</p>
            <p style="font-size: 13px;">আব্দুল হক</p>
            <p style="font-size: 15px;">০১৯১২৪১০৪৪৭৩</p>
        </div>

    </div>


    <div class="row">
        <table class="tg-1" style="width: 100%;">

            <caption style="text-decoration: underline;">বেপারীর তথ্য</caption>
            <tbody>
              <tr>
                <td class="bd_font" style="font-size: 13px; width: 110px; max-width: 110px;">বেপারীর আইডি নং :</td>
                <td class="bd_font" colspan="3" style="font-size: 13px; max-width: 110px;">{{ $supplier->id }}</td>
                <td class="bd_font" rowspan="4"><img width="100px" max-width="100px" hight="100px" max-hight="100px" src="{{ $supplier->file_path }}" alt=""></td>
              </tr>
              <tr>
                <td class="bd_font" style="font-size: 13px; width: 110px; max-width: 110px;">বেপারীর নাম:</td>
                <td class="bd_font" style="font-size: 13px; width: 210px; max-width: 210px;">{{ $supplier->name? $supplier->name:''}}</td>
                <td class="bd_font" style="font-size: 13px; width: 80px; max-width: 80px;">জন্ম তারিখ :</td>
                <td class="bd_font" style="font-size: 13px; width: 200px; max-width: 200px;">{{ $supplier->birth_date? $supplier->birth_date:''}}</td>
              </tr>
              <tr>
                <td class="bd_font" style="font-size: 13px; width: 110px; max-width: 110px;">পিতার নাম :</td>
                <td class="bd_font" colspan="3" style="font-size: 13px;">{{ $supplier->father_name? $supplier->father_name:''}}</td>
              </tr>
              <tr>
                <td class="bd_font" style="font-size: 13px; width: 110px; max-width: 110px;">রক্তের গ্রুপ :</td>
                <td class="bd_font" style="font-size: 13px; width: 210px; max-width: 210px;">{{ $supplier->blood_group? $supplier->blood_group:''}}</td>
                <td class="bd_font" style="font-size: 13px;width: 80px; max-width: 80px;">লিঙ্গ :</td>
                @php
                    if($supplier->gender==1){
                        $gender="পুরুষ";
                    }
                    else if($supplier->gender==2){
                        $gender="নারী";
                    }
                    else if($supplier->gender==3){
                        $gender="অন্যান্য";
                    }
                    else{
                        $gender="";
                    }
                @endphp
                <td class="bd_font" style="font-size: 13px;width: 200px; max-width: 200px;">{{ $gender }}<br></td>
              </tr>
            </tbody>
            </table>
    </div>

    <div>

    </div>

    <div class="row">

        <table class="tg-2" style="width: 100%">
                <tbody>
                    <tr>
                        <td class="bd_font" style="font-size: 13px; width: 110px; width: 110px; max-width: 110px;">দোকানের নাম :</td>
                        <td class="bd_font" colspan="3" style="font-size: 13px; width: 470px; max-width: 470px;">{{ $supplier->shop_name? $supplier->shop_name:''}}<br></td>
                        <td class="bd_font" rowspan="3"><img style="width:100px;max-width:100px;hight:50px;max-hight:50px" src="{{ $supplier->signature }}" alt=""></td>
                    </tr>
                    <tr>
                        <td class="bd_font" style="font-size: 13px; width: 110px; max-width: 110px;">মার্কেটের নাম :</td>
                        <td class="bd_font" colspan="3" style="font-size: 13px;">{{ $supplier->market_name? $supplier->market_name:''}}</td>

                    </tr>
                    <tr>
                        <td class="bd_font" style="font-size: 13px; width: 110px; width: 110px; max-width: 110px;">রুটের নাম :</td>
                        <td class="bd_font" colspan="3" style="font-size: 13px;">{{ $supplier->road_id? $supplier->road->name:''}}</td>

                    </tr>


                    <tr>
                        <td class="bd_font" style="font-size: 13px; width: 110px; max-width: 110px;">এরিয়া :</td>
                        <td class="bd_font" colspan="3" style="font-size: 13px;">{{ $supplier->area_id? $supplier->area->name:''}}</td>

                        <td class="bd_font" style="text-align:center;"><span style="border-top: 1px solid black; padding: 100px; ">বেপারীর স্বাক্ষর</span></td>
                    </tr>
                </tbody>
        </table>

    </div>


    <div class="row">
        <table class="tg-3" style="width: 100%; margin-top: 15px;">
            <tbody>
                <tr>
                    <td class="bd_font" style="font-size:17px; width: 148px; max-width: 148px;"> <h4>ঠিকানার বিবরণ :- </h4></td>
                    <td class="bd_font" colspan="5"></td>
                </tr>

                <tr>
                    <td class="bd_font" style="font-size: 17px; width: 110px; max-width: 110px;">গ্রাম/রাস্তা  নাম :</td>
                    <td class="bd_font" style="font-size: 17px; width: 290px; max-width: 290px;">{{ $supplier->village_road_name? $supplier->village_road_name:''}}</td>
                    <td class="bd_font" style="font-size: 17px; width: 110px; max-width: 110px;">পোস্ট অফিস :</td>
                    <td class="bd_font" style="font-size: 17px; width: 210px; max-width: 210px;">{{ $supplier->post_office? $supplier->post_office:''}}</td>
                    <td class="bd_font" style="font-size: 17px; width: 110px; max-width: 110px;">পোস্ট কোড :</td>
                    <td class="bd_font" style="font-size: 17px;">{{ $supplier->post_code }}</td>
                </tr>
                <tr>
                    <td class="bd_font" style="font-size: 17px; width: 110px; max-width: 110px;">থানা :</td>
                    <td class="bd_font" style="font-size: 17px;" >{{ $supplier->police_station? $supplier->police_station:''}}</td>
                    <td class="bd_font" style="font-size: 17px; width: 110px; max-width: 110px;">জেলা :</td>
                    <td class="bd_font" style="font-size: 17px; ">{{ $supplier->district_id? $supplier->district->name:''}}</td>
                    <td class="bd_font" style="font-size: 17px; width: 110px; max-width: 110px;">বিভাগ :</td>
                    <td class="bd_font" style="font-size: 17px;">{{ $supplier->division_id? $supplier->division->name:''}}</td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="row">
        <table class="tg-4" style="width: 100%">

            <tbody>
            <tr>
                <td class="bd_font" style="font-size:13px; width: 110px; max-width: 110px;">ফোন নং :</td>
                <td class="bd_font" style="font-size:13px; width: 214px; max-width: 214px;">{{ $supplier->phone_number? $supplier->phone_number:'' }}</td>
                <td class="bd_font"></td>
                <td class="bd_font" colspan="2"></td>
            </tr>


            <tr>
                <td class="bd_font" style="font-size:13px; width: 110px; max-width: 110px;">মোবাইল নং(১):</td>
                <td class="bd_font" style="font-size:13px; width: 214px; max-width: 214px;">{{ $supplier->mobile_number? $supplier->mobile_number:'' }}</td>
                <td class="bd_font" style="font-size:13px; width: 90px; max-width: 90px;">মোবাইল নং(২):</td>
                <td class="bd_font" colspan="2" style="font-size:13px;">{{ $supplier->alternative_mobile_number? $supplier->alternative_mobile_number:'' }}</td>
            </tr>
            <tr>
                <td class="bd_font" style="font-size:13px; width: 110px; max-width: 110px;">ই-মেইল আইডি:</td>
                <td class="bd_font" style="font-size:13px; width: 214px; max-width: 214px;">{{ $supplier->email? $supplier->email:'' }}</td>
                <td class="bd_font" style="font-size:13px;">জাতীয় পরিচয় পত্র নম্বর:</td>
                <td class="bd_font" style="font-size:13px;">{{ $supplier->nid_number? $supplier->nid_number:'' }}</td>
                <td class="bd_font" colspan="1"></td>
            </tr>
            </tbody>
        </table>

    </div>

    <div class="row" style="margin-top:10px">
        <table class="tg-4" style="width: 100% ">

            <tbody>
            <tr>
                <td class="bd_font" style="font-size:13px; width: 110px; max-width: 110px;">জাতীয় পরিচয় পত্র :</td>
                <td class="bd_font" style="font-size:13px; width: 214px; max-width: 214px;"></td>
                <td class="bd_font"></td>
                <td class="bd_font" colspan="2"></td>
            </tr>


            <tr>
                <td class="bd_font" style="font-size:13px;">সামনে ছবি:</td>
                <td class="bd_font"><img width="200px" height="120px" src="{{ $supplier->nid_front }}" alt=""></td>
                <td class="bd_font" style="font-size:13px;">পিছনে ছবি:</td>
                <td class="bd_font" ><img width="200px" height="120px" src="{{ $supplier->nid_back }}" alt=""></td>
            </tr>

            </tbody>
        </table>

    </div>

    <div class="row" style="margin-top: 10px;">
        <span class="bd_font" style="font-size:13px; width: 108px; max-width: 108px;">ব্যাংকার তথ্য :-</span>

    </div>

    {{-- @if (count($supplier->bankDetail)) --}}
        <div class="row">
            <table class="tg-5" style="width: 100%">
                <tbody>
                {{-- <tr>
                    <td class="bd_font" style="font-size:13px; width: 108px; max-width: 108px;">ব্যাংকার তথ্য :-</td>
                    <td class="bd_font" colspan="4"></td>
                </tr> --}}

                <tr>
                    <td class="bd_font" style="font-size:13px; text-align:center;">ব্যাংকের নাম</td>
                    <td class="bd_font" style="font-size:13px; text-align:center;">হিসাবধারীর নাম</td>
                    <td class="bd_font" style="font-size:13px; text-align:center;">হিসাব নং</td>
                    <td class="bd_font" style="font-size:13px; text-align:center;">শাখার নাম</td>
                    <td class="bd_font" style="font-size:13px; text-align:center;">মোবাইল নং</td>
                </tr>

            @foreach ($supplier->bankDetail as $bd)
                <tr>
                    <td class="bd_font" style="font-size:13px;text-align:center;">{{ $bd->bank? $bd->bank:'' }}</td>
                    <td class="bd_font" style="font-size:13px;text-align:center;">{{ $bd->account_name? $bd->account_name:'' }}</td>
                    <td class="bd_font" style="font-size:13px;text-align:center;">{{ $bd->account_number? $bd->account_number:'' }}</td>
                    <td class="bd_font" style="font-size:13px;text-align:center;">{{ $bd->branch_name? $bd->branch_name:'' }}</td>
                    <td class="bd_font" style="font-size:13px;text-align:center;">{{ $bd->contact? $bd->contact:'' }}</td>
                </tr>
            @endforeach
                </tbody>
            </table>



        </div>

    {{-- @endif --}}



    <footer>
        <div class="row" style="text-align: center; margin-left:450px;margin-top:70px">

            <span class="bd_font" style="font-size: 12px; font-weight:bold; border-top: 2px solid black; padding: 100px;">নিউ আমিন অ্যান্ড সন্স</span><br>
            <span class="bd_font" style="font-size: 12px;">হাটখোলা রোড, আড়ৎপট্টি</span><br>
            <span class="bd_font" style="font-size: 12px;"> যশোর।</span>

        </div>

    </footer>






        <style>
            /* #tg-1,#tg-2,#tg-3,#tg-4{

                border: none;

            } */

            .tg-1,.tg-1 tr,.tg-2,.tg-2 tr,.tg-3, .tg-3 tr,.tg-4,.tg-4 tr{
                border:none;

            }

            .tg-1 td,.tg-2 td, .tg-3 td,.tg-4 td{
                border:none;

            }

            .tg-5, .tg-5 tr, .tg-5 td{
                border: 1px solid black;
            }

            .row{
                width:100%;
            }
            .col_1{
                width:25%;
                float: left;

            }
            .col_3{
                width:25%;
                float:right;
                text-align: right;
                margin-top:-150px;
                line-height: 5px;
            }
            .col_2{
                width:48%;
                text-align: center;
                line-height: 5px;
            }
        </style>













<htmlpagefooter name="page-footer">
    {{-- <p style="font-size: 10px">©{{ \App\Helper\CRMS::digitConvert(date('Y'))}} সিএমপি বন্ধন</p> --}}
</htmlpagefooter>
<link href="{{ asset('/assets/css/print.css') }}" rel="stylesheet" media="print" type="text/css"/>
<link href="{{ asset('/assets/css/print_table_rules.css') }}" rel="stylesheet" media="print" type="text/css"/>
</body>
</html>



