<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset('js/fontawesome.js') }}" crossorigin="anonymous"></script>
        <script src="{{asset('js/bootstrap.bundle.min.js')}}" crossorigin="anonymous"></script>

        {{--  JQuery fixed syntax --}}
        <script src="{{asset('js/jquery-3.6.4.min.js')}}" crossorigin="anonymous"></script>
        <script src="{{asset('js/jquery-ui-1.12.1.js')}}" crossorigin="anonymous"></script>

        {{-- Datatable fixed syntax--}}
        <link href="{{ asset('css/dt-1.13.8.datatables.min.css') }}" rel="stylesheet">
        <script src="{{ asset('js/dt-1.13.8.datatables.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/chart.js') }}" crossorigin="anonymous"></script>

        {{--  PDF Support syntax  --}}
        <script src="{{ asset('js/html2pdf.bundle.min.js') }}" crossorigin="anonymous"></script>


    </head>

    @if(session('success'))

        <div class="modal fade" id="successModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Notification:</h5>
                    </div>
                    <div class="modal-body">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="closeModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                $('#successModal').modal('show');
            });
            function closeModal() {
                $('#successModal').modal('hide');
            }
        </script>
    @endif


   @if(session('error') || $errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Notification:</h5>
                    </div>
                    <div class="modal-body">
                        {{ session('error') }}
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="closeerrorModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                $('#errorModal').modal('show');
            });
            function closeerrorModal() {
                $('#errorModal').modal('hide');
            }
        </script>
    @endif

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3 me-3" href="{{route("dashboard")}}">Job Order</a>
            <button class="btn btn-link btn-sm order-0 ps-2 pe-4 " id="sidebarToggle" ><i class="fas fa-bars"></i></button>
            <a onclick="toggleFullScreen()" class="link-secondary mx-0 ps-0" style="cursor: pointer" title="Maximize">
                <i class="fas fa-maximize fa-lg fa-fw"></i>
            </a>
            <div class="container-fluid justify-content-end me-2">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown"  role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            {{--  <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Activity Log</a></li>  --}}
                            {{--  <li><hr class="dropdown-divider" /></li>  --}}
                            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Content</div>
                                <a class="nav-link" href="{{route("dashboard")}}">
                                    <div class="sb-nav-link-icon"><i class="fa fa-laptop"></i></div>
                                    Dashboard
                                </a>
                            <div class="sb-sidenav-menu-heading">Transactions</div>
                                <a class="nav-link" href="{{route("workorder")}}">
                                    <div class="sb-nav-link-icon"><i class="fa fa-tasks"></i></div>
                                    Work Order
                                </a>
                                <a class="nav-link" href="{{route('chargeinvoice')}}">
                                    <div class="sb-nav-link-icon"><i class="fa fa-file-invoice"></i></div>
                                    Charge Invoice
                                </a>
                            <div class="sb-sidenav-menu-heading">Set-up</div>
                                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fa fa-id-card"></i></div>
                                    Entries
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{route("customer")}}">Customer</a>
                                            <a class="nav-link" href="{{route("status")}}">Status</a>
                                        </nav>
                                    </div>
                                <a class="nav-link" href="{{route("user")}}">
                                    <div class="sb-nav-link-icon"><i class="fa fa-user-circle"></i></div>
                                    User Profile
                                </a>

                            <div class="sb-sidenav-menu-heading">Report</div>
                                <a class="nav-link" href="{{ route("dailyreport")}}">
                                    <div class="sb-nav-link-icon"><i class="fa fa-sticky-note"></i></div>
                                    Daily Report
                                </a>
                                <a class="nav-link" href="{{ route("salesreport")}}">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-file-waveform"></i></div>
                                    Sales Report
                                </a>



                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        @if (auth()->check())
                        <p>{{ auth()->user()->name }}</p>
                        @else
                            <p>Guest</p>
                        @endif
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    @yield('maincontent')

                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted" id="copyright"></div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>

    </body>

    <script>

        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
                localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
            });
        }

        var currentYear = new Date().getFullYear();
        document.getElementById('copyright').innerHTML = 'Copyright &copy; ' + currentYear;


        function toggleFullScreen() {
            const doc = window.document;
            const docEl = doc.documentElement;

            const requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
            const exitFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

            if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
                requestFullScreen.call(docEl);
            }

        }

    </script>

</html>
