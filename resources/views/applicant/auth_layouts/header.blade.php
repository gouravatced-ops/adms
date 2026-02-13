<!--Full width header Start-->
<div class="full-width-header">
    <!--Header Start-->
    <header id="rs-header" class="rs-header style2">
        <!-- Topbar Area Start -->
        <div class="topbar-area style2">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-6">
                        <ul class="topbar-contact">
                            <li>
                                <i class="flaticon-user"></i>
                                <a href="{{ route('admin.login') }}"><span class="menu-text">Admin</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 text-right">
                        <ul class="topbar-contact">
                            <li>
                                <i class="flaticon-email"></i>
                                <a href="mailto:jspcranchi@gmail.com">jshbranchi@gmail.com</a>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <a href="tel:++1(990)999–5554"> 0345-9834234</a>
                            </li>
                            <li>
                                <i class="flaticon-clock"></i>
                                <span id="liveTime"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateTime() {
                const now = new Date();

                const options = {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };

                document.getElementById('liveTime').innerText =
                    now.toLocaleDateString('en-IN', options);
            }

            updateTime();
            setInterval(updateTime, 1000);
        </script>
        <!-- Topbar Area End -->
        <!-- Menu Start -->

        <div class="container md-pt-3 lg-pt-3">
            <div class="row align-items-center mt-3">
                <div class="col-lg-1">
                    <div class="logo-part">
                        <a href="/"><img src="{{ asset('assets/applicant/auth/images/jspc_logo_in.png') }}"
                                alt=""></a>
                    </div>
                </div>

                <div class="col-lg-5">
                    <a href="index.php" style="text-decoration:none;">
                        <span class="htitle headtitle" style="color: #007bff; font-weight:bolder !important;" alt="Go To Home"
                            title="Go To Home">झारखण्ड राज्य हाउसिंग बोर्ड</span>
                        <span class="htitle1 headtitle" style="color: #007bff; font-weight:bolder !important;" alt="Go To Home"
                            title="Go To Home">Jharkhand State Housing Board</span>
                    </a>
                </div>

                <div class="col-lg-5 text-center"></div>

                <div class="col-lg-1">
                    <div class="logo-part">
                        <a href="/"><img src="{{ asset('assets/applicant/auth/images/jharkhand_logo_in.png') }}"
                                alt=""></a>
                    </div>
                </div>
            </div>

            <div class="mobile-menu">
                <a href="#" class="rs-menu-toggle rs-menu-toggle-close secondary">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>

        <br>
        <div class="menu-area menu-sticky" style="background-image: linear-gradient(90deg, #106eea 10%, #007bff 100%);">
            <div class="container">
                <div class="row align-items-left">

                    <div class="col-lg-12">
                        <div class="">
                            <div class="main-menu">
                                <nav class="rs-menu pr-100 lg-pr-50 md-pr-0">
                                    <ul class="nav-menu">

                                        @include('applicant.auth_layouts.navbar')

                                    </ul> <!-- //.nav-menu -->
                                </nav>
                            </div> <!-- //.main-menu -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu End -->
    </header>
    <!--Header End-->

</div>
<!--Full width header End-->
