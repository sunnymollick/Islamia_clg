<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                        data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button"
                    class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li>
                    <a href="{{ URL :: to('/admin/dashboard') }}">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>
                <li class="treeview">
                <a href="#">
                    <i class="metismenu-icon  fa fa-address-card"></i>
                    <span>Academic </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL :: to('/admin/std_classes') }}">
                            <i class="fa fa-building"></i> <span>Classes</span></a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/sections') }}">
                            <i class="fa fa-building"></i> <span>Sections</span></a>
                    </li>
                    <li>
                        <a href="{{ URL :: to('/admin/sessions') }}">
                            <i class="fa fa-building"></i> 
                            Sessions
                        </a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/classrooms') }}">
                            <i class="fa fa-building"></i> <span>Class Rooms</span></a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/classroutines') }}">
                            <i class="fa fa-address-card"></i> <span>Class Routines</span></a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/subjects') }}">
                            <i class="fa fa-book"></i> <span>Subjects</span></a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/syllabus') }}">
                            <i class="fa fa-book"></i> <span>Syllabus</span></a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/academiccalenders') }}">
                            <i class="fa fa-calendar"></i> <span>Academic Calender</span></a>
                    </li>
                    <li><a href="{{ URL :: to('/admin/events') }}">
                            <i class="fa fa-calendar"></i> <span>Event Calender</span></a>
                    </li>
                        </ul>
                    </li>
                <li class="treeview">
                        <a href="#">
                            <i class="metismenu-icon fa fa-users"></i>
                            <span>Academic Users </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ URL :: to('/admin/students') }}">
                                    <i class="mdi fa fa-male"></i> <span>Students</span></a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/importPromotions') }}">
                                    <i class="mdi fa fa-user-plus"></i> <span>Students Promotion</span></a>
                            </li>
                            <li>
                                <a href="{{ URL :: to('/admin/std_parents') }}">
                                    <i class="mdi  fa fa-users"></i> <span>Parents</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL :: to('/admin/teachers') }}">
                                    <i class="mdi fa fa-user-circle"></i> <span>Teachers</span>
                                </a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/staffs') }}">
                                    <i class="mdi fa fa-user"></i> <span>Staff</span></a>
                            </li>
                        </ul>
                    </li>

                <li class="treeview">
                        <a href="#">
                            <i class="metismenu-icon fa fa-envelope-open"></i>
                            <span>Online Admission </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ URL :: to('/admin/admissionApplication') }}">
                                    <i class="mdi fa fa-user"></i> <span>Online Applications</span></a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/importPromotions') }}">
                                <i class="mdi fa fa-user-circle"></i>
                                <span>Admission Result</span></a>
                            </li>
                        <li><a href="{{ URL :: to('/admin/cancelledAdmissionApplication') }}">
                            <i class="fa fa-user-times" aria-hidden="true"></i>
                                <span>Cancelled Applicants</span></a>
                        </li>

                        </ul>
                    </li>

                <li class="treeview">
                        <a href="#">
                            <i class="metismenu-icon fa fa-book"></i>
                            <span>Exam & Marks </span>
                        </a>
                        <ul class="treeview-menu">

                            <li>
                                <a href="{{ URL :: to('/admin/exams') }}">
                                    <i class="fa fa-certificate"></i>
                                    Exams
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL :: to('/admin/marks') }}">
                                    <i class="fa fa-clone"></i>
                                    Marks
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL :: to('/admin/admitCard') }}">
                                    <i class="fa fa-address-card"></i> <span>
                                        Admit Card
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL :: to('/admin/seatPlan') }}">
                                    <i class="fa fa-address-card"></i> <span>
                                        Seat Plan
                                    </span>
                                </a>
                            </li>
                            {{-- <li>
                                <a href="{{ URL :: to('/admin/tabulations') }}">
                                    <i class="fa fa-check-square"></i> <span>Marks Sheet</span>
                                </a>
                            </li> --}}
                        {{-- <li>
                            <a href="{{ URL :: to('/admin/jrhalfYearlyExam') }}">
                                <i class="metismenu-icon pe-7s-bookmarks"></i>
                                Junior half yearly Result
                            </a>
                        </li>

                        <li>
                            <a href="{{ URL :: to('/admin/jrfullMarksheet') }}">
                                <i class="metismenu-icon pe-7s-bookmarks"></i>
                                Junior Final Result
                            </a>
                        </li> --}}

                        <li>
                            <a href="{{ URL :: to('/admin/srResult') }}">
                                <i class="fa fa-clipboard" aria-hidden="true"></i>
                                Exam Result
                            </a>
                        </li>

                    <li>
                        <a href="{{ URL :: to('/admin/srResultPublish') }}">
                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                            Publish Result
                        </a>
                    </li>

                        {{-- <li>
                            <a href="{{ URL :: to('/admin/testResult') }}">
                                <i class="fa fa-clipboard" aria-hidden="true"></i>
                                Test Result
                            </a>
                        </li> --}}

                        {{-- <li>
                            <a href="{{ URL :: to('/admin/srfullMarksheet') }}">
                                <i class="metismenu-icon pe-7s-bookmarks"></i>
                                Senior yearly Result
                            </a>
                        </li> --}}



                        </ul>
                    </li>

            <li class="treeview">
                <a href="#">
                    <i class="metismenu-icon fa fa-bars"></i>
                <span>Attendance </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i>
                            <span>Student Attendance <i class="pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ URL :: to('/admin/attendancestudents') }}">
                                    <i class="fa fa-bullseye"></i> <span>Manually Daily Attendance</span></a>
                        </li>
                        <li><a href="{{ URL :: to('/admin/importStdAttendance') }}">
                                <i class="fa fa-bullseye"></i><span> Import Attendance</span></a>
                        </li>
                        {{-- <li><a href="{{ URL :: to('/admin/importStdAttendanceMonthly') }}">
                                <i class="fa fa-bullseye"></i><span> Import Monthly Attendance</span></a>
                        </li> --}}
                        <li>
                            <a href="{{ URL :: to('/admin/studentDailyAttendanceReport') }}">
                                <i class="fa fa-bullseye"></i><span> Daily Report</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ URL :: to('/admin/studentMonthlyAttendanceReport') }}">
                                <i class="fa fa-bullseye"></i><span> Monthly Report</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i>
                        <span>Teacher Attendance </span> <i class="pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL :: to('/admin/importTeacherattendances') }}">
                                <i class="fa fa-circle"></i><span> Import Daily Attendance</span></a>
                        </li>
                        {{-- <li><a href="{{ URL :: to('/admin/importTeacherAttendanceMonthly') }}">
                                <i class="fa fa-circle"></i><span> Import Monthly Attendance</span></a>
                        </li> --}}
                        <li>
                            <a href="{{ URL :: to('/admin/teacherDailyAttendanceReport') }}">
                                <i class="fa fa-circle"></i><span> Daily Report</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ URL :: to('/admin/teacherMonthlyAttendanceReport') }}">
                                <i class="fa fa-circle"></i><span> Monthly Report</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i>
                        <span>Staff Attendance </span> <i class="pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL :: to('/admin/importStaffattendances') }}">
                                <i class="fa fa-check-square"></i><span> Import Daily Attendance</span></a>
                            </li>
                        <li><a href="{{ URL :: to('/admin/importStaffAttendanceMonthly') }}">
                                <i class="fa fa-check-square"></i><span> Import Monthly Attendance</span></a>
                        </li>
                        <li><a href="{{ URL :: to('/admin/staffDailyAttendanceReport') }}">
                                <i class="fa fa-check-square"></i><span> Daily Report</span></a>
                        </li>
                        <li><a href="{{ URL :: to('/admin/staffMonthlyAttendanceReport') }}">
                                <i class="fa fa-check-square"></i><span> Monthly Report</span></a>
                        </li>
                    </ul>
                </li>
                </ul>
            </li>

                <li class="treeview">
                        <a href="#">
                            <i class="metismenu-icon fas fa-medal"></i>
                            <span>Certificates</span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ URL :: to('/admin/certificates') }}">
                                    <i class="mdi fa fa-user"></i> <span>Allow For Certificates</span></a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/importPromotions') }}">
                                    <i class="mdi fa fa-certificate"></i> <span>Issue Certificate</span></a>
                            </li>

                        </ul>
                    </li>

                <li class="treeview">
                    <a href="#">
                        <i class="metismenu-icon fa fa-users"></i>
                        <span>Finance  </span>
                    </a>
                    <ul class="treeview-menu">
                            <li><a href="{{ URL :: to('/admin/income-heads') }}">
                                    <i class="mdi fa fa-male"></i> <span>Income Head</span></a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/expenses-heads') }}">
                                    <i class="mdi fa fa-user-plus"></i> <span>Expenses Head</span></a>
                            </li>
                            <li>
                                <a href="{{ URL :: to('/admin/educational-fees') }}">
                                    <i class="mdi  fa fa-users"></i> <span>Assign Fees</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ URL :: to('/admin/massBills/index') }}">
                                    <i class="mdi  fa fa-users"></i><span>Bill</span>
                                </a>
                            </li>
                          <!--  <li>
                                <a href="{{ URL :: to('/admin/teachers') }}">
                                    <i class="mdi fa fa-user-circle"></i> <span>Teachers</span>
                                </a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/staffs') }}">
                                    <i class="mdi fa fa-user"></i> <span>Staff</span></a>
                           </li> -->
                        </ul>
                </li>
                <li class="treeview">
                        <a href="#">
                            <i class="metismenu-icon fa fa-university"></i>
                            <span>Frontend </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ URL :: to('/admin/pages') }}">
                                    <i class="fa fa-book"></i> <span> Pages</span></a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/news') }}">
                                    <i class="fa fa-file"></i> <span> Notice Board & News</span></a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/sliders') }}"><i class="fa fa-window-maximize" aria-hidden="true"></i> Slider </a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/downloads') }}"><i
                                        class="fa fa-download"></i> Digital Content </a>
                            </li>
                            <li><a href="{{ URL :: to('/admin/galleries') }}"><i
                                        class="fa fa-image"></i> Gallery </a>
                            </li>
                        </ul>
                    </li>
                <li>
                    <a href="{{ URL :: to('/admin/settings') }}">
                        <i class="metismenu-icon pe-7s-tools"></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ URL :: to('/admin_login/logout') }}">
                        <i class="metismenu-icon pe-7s-upload"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /.sidebar -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.app-sidebar__inner ul li').each(function () {
            if (window.location.href.indexOf($(this).find('a:first').attr('href')) > -1) {
                $(this).closest('ul').closest('li').attr('class', 'mm-active');
                $(this).addClass('mm-active').siblings().removeClass('mm-active');
            }
        });
    });
</script>
