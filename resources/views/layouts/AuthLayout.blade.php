<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MEDYSEVA TECHNOLGIES PVT LTD</title>
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" href="assets/images/apple-touch-icon-57-precomposed.png">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/apple-touch-icon-114-precomposed.png">
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/apple-touch-icon-72-precomposed.png">
    <!-- For iPad Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/apple-touch-icon-144-precomposed.png">

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="{{asset('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/fonts/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/fonts/webfont/cryptocoins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/animate.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <link href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/morris-chart/css/morris.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/calendar/fullcalendar.css')}}" rel="stylesheet" type="text/css" media="screen"/>
    <link href="{{asset('assets/plugins/icheck/skins/minimal/minimal.css')}}" rel="stylesheet" type="text/css" media="screen"/>
    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" >
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class=" ">
    <!-- START TOPBAR -->
    <div class='page-topbar gradient-blue1'>
        <div class='logo-area crypto'>
          
        </div>
        <div class='quick-area'>
            <div class='pull-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="sidebar-toggle-wrap">
                        <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                
                
                </ul>
            </div>
            <div class='pull-right'>
                <ul class="info-menu right-links list-inline list-unstyled">
                   
                  
                    <li class="profile">
                        <a href="#" data-toggle="dropdown" class="toggle">
                            <img src="assets/images/user.png" alt="user-image" class="img-circle img-inline">
                            <span>Arnold Ramsy <i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu profile animated fadeIn">
                          
                            <li>
                                <a href="doctor-update.php">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="help-center.php">
                                    <i class="fa fa-info"></i> Help
                                </a>
                            </li>
                            <li class="last">
                                <a href="dashboard.php">
                                    <i class="fa fa-lock"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <!-- END TOPBAR -->
    <!-- START CONTAINER -->
    <div class="page-container row-fluid container-fluid">

        <!-- SIDEBAR - START -->

        <div class="page-sidebar fixedscroll">

            <!-- MAIN MENU - START -->
            <div class="page-sidebar-wrapper" id="main-menu-wrapper">

                <ul class='wraplist'>
                    <li class='menusection'>Main</li>
                    @if(Auth::user()->role == 'admin')
                    <li class="open">
                        <a href="{{route('user.admin_index')}}">
                           <i class="fa fa-tachometer"></i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('user.coupon')}}">
                            <i class="fa fa-gift"></i>
                            <span class="title">Coupon List</span>
                        </a>
                    </li>
                    @else
                     <li class="open">
                        <a href="{{route('user.dashboard')}}">
                           <i class="fa fa-tachometer"></i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                  
                    <!--<li class="">-->
                    <!--    <a href="{{route('user.invoices')}}">-->
                    <!--        <i class="fa fa-file-text-o" aria-hidden="true"></i>-->
                    <!--        <span class="title">Invoice List</span>-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                      <li class="">
                        <a href="{{route('user.vle')}}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span class="title">VLE List</span>
                        </a>
                    </li>
                    
                    <li class="">
                        <a href="/vle/session">
                            <i class="fa fa-area-chart" aria-hidden="true"></i>
                            <span class="title">VLE Session</span>
                        </a>
                    </li>
                    
                      <li class="">
                        <a href="{{route('user.wallet')}}">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            <span class="title">Wallet Details</span>
                        </a>
                    </li>
                   
                    <!-- <li class="">
                        <a href="javascript:;">
                            <i class="img">
                                <img src="data/hos-dash/icons/7.png" alt="" class="width-20">
                            </i>
                            <span class="title">Billing</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a class="" href="payment.php">Payments</a>
                            </li>
                            <li>
                                <a class="" href="add-payment.php">Add Payment</a>
                            </li>
                            <li>
                                <a class="" href="patient-invoice.php">Patient Invoice</a>
                            </li>
                        </ul>
                    </li> -->
                    <!--<li class="">-->
                    <!--    <a href="{{route('user.patient')}}">-->
                    <!--        <i class="fa fa-users" aria-hidden="true"></i>-->
                    <!--        <span class="title">Patient List</span>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <li class="">
                        <a href="{{route('user.walletTransactions')}}">
                            <i class="fa fa-list"></i>
                            <span class="title">Transaction List</span>
                        </a>
                    </li>
                    
                     <li class="">
                        <a href="/invoice/nict">
                            <i class="fa fa-file"></i>
                            <span class="title">NICT INVOICES</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('user.withdrawRequest')}}">
                            <i class="fa fa-vcard-o" aria-hidden="true"></i>
                            <span class="title">Withdraw Request</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('user.MywithdrawRequest')}}">
                            <i class="fa fa-vcard-o" aria-hidden="true"></i>
                            <span class="title">My Withdraw</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="/wallet/topup">
                            <i class="fa fa-address-book"></i>
                            <span class="title">Topup Request</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('user.MytopupRequest')}}">
                            <i class="fa fa-address-book"></i>
                            <span class="title">My Topup Request</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('user.vle_report')}}">
                            <i class="fa fa-address-book"></i>
                            <span class="title">VLE Report</span>
                        </a>
                    </li>
                    
                    <li class="">
                        <a href="{{route('user.password')}}">
                            <i class="fa fa-lock"></i>
                            <span class="title">Change Password</span>
                        </a>
                    </li>
                    @endif
                    <li class="">
                        <a href="{{route('user.logout')}}">
                            <i class="fa fa-power-off"></i>
                            <span class="title">Logout</span>
                        </a>
                    </li>
                    
                 
                </ul>

            </div>
            <!-- MAIN MENU - END -->

        </div>
        <!--  SIDEBAR - END -->

        <!-- START CONTENT -->
        <section id="main-content" class=" ">
            <div class="wrapper main-wrapper row" style=''>
                @yield('content')
             </div>
        </section>
        
        
    </div>
    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}"></script>
    <script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/plugins/viewport/viewportchecker.js')}}"></script>
    <script>
        window.jQuery || document.write('<script src="/assets/js/jquery.min.js"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="{{asset('assets/plugins/echarts/echarts-custom-for-dashboard.js')}}"></script>

    <script src="{{asset('assets/plugins/flot-chart/jquery.flot.js')}}"></script>
    <script src="{{asset('assets/plugins/flot-chart/jquery.flot.time.js')}}"></script>
    <script src="{{asset('assets/js/chart-flot.js')}}"></script>

    <script src="{{asset('assets/js/dashboard-hos.js')}}"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
    
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE TEMPLATE JS - START -->
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- END CORE TEMPLATE JS - END -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

    @if(\Session::has('success'))
    toastr.success('<?php echo \Session::get("success")?>');     
    @endif
    
    @if(\Session::has('error'))
    toastr.error('<?php echo \Session::get("error")?>');     
    @endif
    
    $(".toggle").click(function(){
  $(".showopacity").toggleClass("open");
});


      let inactivityTime = function() {
        let time;
         window.onload = resetTimer;
         document.onload = resetTimer;
         document.onmousemove = resetTimer;
         document.onmousedown = resetTimer; // touchscreen presses
         document.ontouchstart = resetTimer;
         document.onclick = resetTimer; // touchpad clicks
         document.onkeypress = resetTimer;
         document.addEventListener('scroll', resetTimer, true); // improved; see comments
        function logout() {
            
              swal({
                 title: "Hi!",
                text: "You are inactive since long time!",
                icon: "info",
               });
        }
        function resetTimer() {
          clearTimeout(time);
          time = setTimeout(logout, 600000)
        }
      };



      
      window.onload = function() {
        inactivityTime();
      }


</script>
@yield('script')


</body>

</html>