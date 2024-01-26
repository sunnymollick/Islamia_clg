<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <h4>Dashboard</h4>
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
                    <a href="{{ URL :: to('/student/') }}">
                        <i class="metismenu-icon pe-7s-home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="metismenu-icon fa fa-book"></i>
                        <span>Exam & Marks </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--<li>--}}
                            {{--<a href="{{ URL :: to('/student/admitCard') }}">--}}
                            {{--<a href="#">--}}
                                {{--<i class="fa fa-address-card"></i> <span>--}}
                                    {{--Admit Card--}}
                                {{--</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ URL :: to('/student/getAcademicResult') }}">
                                <i class="fa fa-clone"></i>
                                Academic Result
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="{{ URL :: to('/student/profile') }}">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="{{ URL :: to('/student/change_password') }}">
                        <i class="metismenu-icon pe-7s-lock"></i>
                        Change password
                    </a>
                </li>
                <li>
                    <a href="{{ URL :: to('/student_login/logout') }}">
                        <i class="metismenu-icon pe-7s-download"></i>
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