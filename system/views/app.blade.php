<!DOCTYPE html>
<html lang="en" ng-app="zeApp" ng-controller="MainCtrl as main" ng-cloak ng-strict-di>
    <head>
        <meta charset="utf-8">
        <title ng-bind="notificationsNotSeen() ? '['+notificationsNotSeen()+'] Zeapps' : 'Zeapps'">Zeapps</title>
        <base href="/">

<!-- ************************************************************* -->
<!-- **************************** CSS **************************** -->
<!-- ************************************************************* -->
        <!-- Bootstrap -->
        <link rel="stylesheet" media="print,screen" href="/assets/bootstrap-3.3.7/css/bootstrap.min.css">

        <!-- jQuery UI -->
        <link rel="stylesheet" media="print,screen" href="/assets/js/jquery-ui-1.11.4/jquery-ui.min.css">
        <link rel="stylesheet" media="print,screen" href="/assets/js/jquery-ui-1.11.4/jquery-ui.structure.min.css">
        <link rel="stylesheet" media="print,screen" href="/assets/js/jquery-ui-1.11.4/jquery-ui.theme.min.css">

        <!-- Full Calendar -->
        <link rel="stylesheet" media="print,screen" href="/assets/css/fullcalendar.min.css">
        <link rel="stylesheet" media="print" href="/assets/css/fullcalendar.print.min.css">

        <!-- Font-Awesome -->
        <!--<link rel="stylesheet" media="print,screen" href="/assets/css/font-awesome.min.css">-->
        <link rel="stylesheet" media="print,screen" href="/assets/fontawesome-free-5.7.2-web/css/all.css">



        <link rel="stylesheet" media="print,screen" href="/assets/css/app.css">
        <link rel="stylesheet" media="print,screen" href="/cache/css/global.css">


    </head>
    <body>
        <div id="ze-loader" ng-hide="$root.contextLoaded" class="text-center">
            <span id="logo"><img src="/assets/images/logo.png" class="loading"/></span>
        </div>
        <div ng-show="$root.contextLoaded" class="ng-hide">
            <!-- HOOK zeappsDaemon_Hook -->
            <span ng-repeat="hook in daemon_hooks | orderBy:'sort'" ng-include="hook.template"></span>

            <div id="menu-hover-shadow"></div>

            <div id="menu-hover">
                <div class="essential">
                    <div class="title">{{ __t("The essential") }}</div>
                    <div class="url-menu">
                        <ul class="nav">

                            @foreach ($menuEssential as $menuItem)
                                <li>
                                    <a href="{{ $menuItem["url"] }}">
                                        {{ $menuItem["label"] }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <div class="menu-content">
                    <div class="row">
                        @if (count($menuTopCol1) > 0)
                            <div class="col-sm-6">
                                @foreach ($menuTopCol1 as $menuSpace)
                                    @if (sizeof($menuSpace["item"]) > 0)
                                        <div class="title">
                                            {{ $menuSpace["info"]["name"] }}
                                        </div>
                                        <ul class="nav">
                                            @foreach ($menuSpace["item"] as $menuItem)
                                                <li>
                                                    <a href="{{ $menuItem["url"] }}">{{ $menuItem["label"] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        @if (count($menuTopCol2) > 0)
                            <div class="col-sm-6">
                                @foreach ($menuTopCol2 as $menuSpace)
                                    @if (sizeof($menuSpace["item"]) > 0)
                                        <div class="title">{{ $menuSpace["info"]["name"] }}</div>
                                        <ul class="nav">
                                            @foreach ($menuSpace["item"] as $menuItem)
                                                <li>
                                                    <a href="{{ $menuItem["url"] }}">{{ $menuItem["label"] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="footer-menu">

                    <div class="pull-left">
                        <button type="button" class="btn btn-sm" ze-auth="zeapps_admin">
                            <span class="fa fa-fw fa-shopping-cart" aria-hidden="true"></span>
                            {{ __t("Extension store") }}
                        </button>
                        <button type="button" class="btn btn-sm" ze-auth="zeapps_admin">
                            <span class="fa fa-fw fa-list-ul" aria-hidden="true"></span>
                            {{ __t("Subscription") }}
                        </button>
                    </div>

                    <div class="pull-right">
                        <a href="/ng/com_zeapps/config" class="btn btn-sm" ze-auth="zeapps_admin">
                            <span class="fa fa-fw fa-cogs" aria-hidden="true"></span>
                            {{ __t("Configuration") }}
                        </a>
                    </div>

                </div>
            </div>

            <div id="ze-header">
                <div id="logo"><a href="/"><img src="/assets/images/logo.png" class="vertical-middle" ng-class="loading()"/></a>
                </div>
                <div id="search">
                    <div class="content">
                        <div class="menu pointer">
                            <span class="vertical-middle">
                                {{ __t("menu") }}
                                <span class="fa fa-caret-down" aria-hidden="true"></span>
                            </span>
                        </div>
                        <div class="formSearch">
                            <input type="text" ng-model="globalSearch" ng-keypress="startGlobalSearch($event)"/>
                        </div>
                        <div class="right-menu">

                            <div class="pull-right">
                            <span ng-click="toggleNotification()" class="pointer">
                                <span class="fa fa-fw fa-bell" aria-hidden="true"></span>
                                <span ng-show="notificationsNotSeen() != 0">
                                    <span class="label label-danger label-as-badge">@{{ notificationsNotSeen() }}</span>
                                </span>
                            </span>

                                <span ng-click="toggleDropdown()" class="pointer">
                                    @{{user.firstname[0]}}. @{{user.lastname}}
                                <span class="fa fa-fw" ng-class="dropdown ? 'fa-caret-up' : 'fa-caret-down'" aria-hidden="true"></span>
                            </span>

                            </div>


                            <ul ng-show="dropdown" class="userMenu">
                                <li><a href="/ng/com_zeapps/profile/view">{{ __('Profil') }}</a></li>
                                <li><a href="/ng/com_zeapps/logout">{{ __('Logout') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="main">
                <div id="left-menu" ng-class="fullSizedMenu ? '' : 'shrinked'">
                    <div id="full-menu" ng-show="menu == 'essentiel'?true:false" class="app-sale">
                        <div class="title-app" ng-click="toggleMenuSize()">
                            <span class="menu_title">{{ __t("The essential") }}</span>
                        </div>
                        <div id="menu-nav">
                            <ul class="nav">

                                @foreach ($menuEssential as $menuItem)
                                    <li>
                                        <a href="{{ $menuItem["url"] }}">
                                            {{ $menuItem["label"] }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    @foreach ($menuLeft as $menuSpace)
                        <div id="full-menu" ng-show="menu == '{{ $menuSpace["info"]["id"] }}'?true:false" class="app-sale">
                            <div class="title-app" ng-click="toggleMenuSize()">
                                <span class="fas fa-fw fa-{{ isset($menuSpace["info"]["fa-icon"]) ? $menuSpace["info"]["fa-icon"] : 'chevron-circle-down' }}"></span>
                                <span class="menu_title">{{ $menuSpace["info"]["name"] }}</span>
                            </div>
                            <div id="menu-nav">
                                <ul class="nav">
                                    @foreach ($menuSpace["item"] as $menuItem)
                                        <li ng-class="menu_active == '{{ $menuItem["id"] }}' ? 'active' :''">
                                            <a href="{{ $menuItem["url"] }}">
                                                <span class="fas fa-fw fa-{{ isset($menuItem["fa-icon"]) ? $menuItem["fa-icon"] : 'align-justify' }}" aria-hidden="true"></span>
                                                <span class="menu_item">{{ $menuItem["label"] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>

                <ul class="notifications" ng-class="showNotification ? 'show' : ''">
                    <li ng-repeat="(moduleName, module) in notifications" ng-class="notification.status">
                    <span class="module-name">
                        <span class="fas fa-times pointer pull-right" aria-hidden="true" ng-click="readAllNotificationsFrom(moduleName)"></span>
                        @{{ moduleName }}
                    </span>
                        <ul>
                            <li ng-repeat="notification in module.notifications | limitTo:'15'" class="notification">
                                <span class="fa fa-times pointer pull-right" aria-hidden="true" ng-click="readNotification(notification)"></span>
                                <a href="@{{ notification.url }}" ng-if="notification.url">
                                    @{{ notification.message }}
                                </a>
                                <span ng-if="!notification.url">
                                @{{ notification.message }}
                            </span>
                            </li>
                            <li ng-if="module.notifications.length > 15">
                                ...
                            </li>
                        </ul>
                    </li>
                    <li ng-hide="hasUnreadNotifications()" class="no-notifications">
                        {{ __t("No notification") }}<br>
                    </li>
                </ul>

                <div id="content-area" ng-class="{showingNotifs:showNotification, shrinkedMenu:!fullSizedMenu}">

                    <div class="view-animate" ng-view>
                        <div id="content" class="home">
                            <div class="row">
                                @if (count($menuTopCol1) > 0)
                                    <div class="col-sm-6">
                                        @foreach ($menuTopCol1 as $menuSpace)
                                            @if (sizeof($menuSpace["item"]) > 0)
                                                <div class="title">
                                                    {{ $menuSpace["info"]["name"] }}
                                                </div>
                                                <ul class="nav">
                                                    @foreach ($menuSpace["item"] as $menuItem)
                                                        <li>
                                                            <a href="{{ $menuItem["url"] }}">{{ $menuItem["label"] }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                @if (count($menuTopCol2) > 0)
                                    <div class="col-sm-6">
                                        @foreach ($menuTopCol2 as $menuSpace)
                                            @if (sizeof($menuSpace["item"]) > 0)
                                                <div class="title">{{ $menuSpace["info"]["name"] }}</div>
                                                <ul class="nav">
                                                    @foreach ($menuSpace["item"] as $menuItem)
                                                        <li>
                                                            <a href="{{ $menuItem["url"] }}">{{ $menuItem["label"] }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <toasts></toasts>
            </div>
        </div>



        <!-- ************************************************************* -->
        <!-- ***************************** JS **************************** -->
        <!-- ************************************************************* -->
        <!-- jQuery -->
        <script src="/assets/js/jquery-3.2.1.min.js"></script>

        <!-- ChartJS -->
        <script src="/assets/js/chartjs/Chart.min.js"></script>

        <!-- AngularJS -->
        <script src="/assets/js/angular-1.7.5/angular.min.js"></script>
        <script src="/assets/js/angular-1.7.5/angular-route.min.js"></script>
        <script src="/assets/js/angular-1.7.5/angular-animate.min.js"></script>
        <script src="/assets/js/angular-1.7.5/angular-touch.min.js"></script>
        <script src="/assets/js/angular-1.7.5/angular-sanitize.min.js"></script>
        <script src="/assets/js/angular-1.7.5/i18n/angular-locale_fr-fr.js"></script>

        <!-- angularjs directive for ChartJS -->
        <script src="/assets/js/angular-chartjs/angular-chart.min.js"></script>

        <!-- angularjs Upload Files -->
        <script src="/assets/js/angular-upload/ng-file-upload.min.js"></script>
        <script src="/assets/js/angular-upload/ng-file-upload-shim.min.js"></script>

        <!-- angularjs UI -->
        <script src="/assets/js/ui-bootstrap-tpls-1.1.2.min.js"></script>
        <script src="/assets/js/ui-sortable-0.13.4/sortable.min.js"></script>

        <!-- CACHED FILES -->
        <script src="/cache/js/main.js?serial={{ $numero_serie }}" defer></script>
        <script src="/cache/js/global.js?serial={{ $numero_serie }}" defer></script>

        <!-- Bootstrap -->
        <script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" defer></script>

        <!-- jQuery UI -->
        <script src="/assets/js/jquery-ui-1.11.4/jquery-ui.min.js" defer></script>

        <!-- Moment -->
        <script src="/assets/js/momentjs/moment.min.js" defer></script>

        <!-- Full Calendar -->
        <script src="/assets/js/fullcalendar/fullcalendar.min.js" defer></script>
        <script src="/assets/js/fullcalendar/locale-all.js" defer></script>

        <!-- ckeditor -->
        <script src="/assets/js/ckeditor/ckeditor.js" defer></script>
    </body>
</html>