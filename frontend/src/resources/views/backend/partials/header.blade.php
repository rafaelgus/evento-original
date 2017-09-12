<!-- Main Header -->

<style>
    .holder {
        width: auto;
        display: inline-block;
    }
    .holder img {
        width: 80%; /* Will shrink image to 30% of its original width */
        height: auto;
    }​
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="/management" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">E<b>O</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Evento<b>Original</b></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success" id="messagesCount"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="unreadMessages"></li>
                        <li>
                            <div class="slimScrollDiv" id="messagesScroll">
                                <ul class="menu" id="unreadMessagesList">
                                </ul>
                            </div>
                        </li>
                        <li class="footer"><a href="/messages">Ver todos</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning" id="notificationCount"></span>
                    </a>
                    <ul class="dropdown-menu"  style="width:350px">
                        <li class="header" id="unreadNotifications"></li>
                        <li>
                            <div class="slimScrollDiv">
                                <ul class="menu" id="unreadNotificationsList"  id="notificationsContainer">
                                </ul>
                            </div>
                        </li>
                        <li class="footer" id="li-unread-notifications">
                            <a href="#" style="color:#3c8dbc;" id="all-read">Marcar todas como leidas</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar -->
                        <img src="/backend/img/avatar5.png" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->getName() }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="/backend/img/avatar5.png" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->getName() }}
                                <small>Bienvenido!</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/profile" class="btn btn-default btn-flat">Mi cuenta</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ trans('auth.sign_out') }}
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="submit" value="logout" style="display: none;">
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>