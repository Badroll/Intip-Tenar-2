<div class="navbar navbar-inverse">
    <div class="navbar-header" style=" padding: 8px !important;">
        <img src="{!! url("assets/logo-main.png")  !!}" width="60" height="30" alt="logo navbar">
        &nbsp;&nbsp;
        <strong style="font-size: 120%; vertical-align: middle;">INTIP RUDIMARANG</strong>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>
    

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li id="liCollapse">
                <a class="sidebar-control sidebar-main-toggle hidden-xs">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{!! url("assets/logo-user-1.png")  !!}">
                    <span>{{ session("admin_session")->U_FULLNAME }}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('auth/logout') }}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>