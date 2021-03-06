<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ config('app.name', 'None') }} | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{secure_asset('plugins/fontawesome-free/css/all.min.css')}} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{secure_asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}} ">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{secure_asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}} ">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{secure_asset('plugins/jqvmap/jqvmap.min.css')}} ">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{secure_asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{secure_asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{secure_asset('plugins/daterangepicker/daterangepicker.css')}} ">
  <!-- summernote -->
  <link rel="stylesheet" href="{{secure_asset('plugins/summernote/summernote-bs4.min.css')}} ">
  <link href="{{secure_asset('select2/dist/css/select2.min.css')}}" rel="stylesheet" /> 
  <link href="{{secure_asset('css/addons/datatables.min.css')}}" rel="stylesheet" />  
  <link rel="icon" type="image/x-icon" href="{{secure_asset('img/icon.png')}}"> 

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{secure_asset('dist/img/AdminLTELogo.png')}} " alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('dashboard')}}" class="nav-link">Acceuil</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link font-weight-bold">Exercice {{ date('Y') }} </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            {{csrf_token()}}
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <li>
          <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
              {{csrf_token()}}   
                <a  class="dropdown-item" href="{{route('logout')}}"
                      onclick="event.preventDefault();
                          this.closest('form').submit();">
                          {{ __('D??connexion') }}
                </a>
            </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{secure_asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">RecetteApp</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{secure_asset('dist/img/admin.png')}}" class="img-circle elevation-2" alt="image de l'utilisateur">
        </div>
        <div class="info">          
          <a href="#" class="d-block"> R??gisseur </a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('dashboard')}}" class="nav-link  @if (request()->routeIs('dashboard')) active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord
              </p>  
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('view-taxes')}}"  class="nav-link  @if (request()->routeIs('create-taxe') or request()->routeIs('view-taxes')) active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Taxes
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>            
            
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link  @if (request()->routeIs('add.contribuable') or request()->routeIs('contribuable')) active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Contribuables
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="{{route('add.contribuable')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Ajouter un contribuable</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('add.taxe.contribuable')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Ajouter une taxe au contribuable</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('contribuable')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Contribuables enregistr??s</p>
                </a>
              </li>
            </ul>            
          </li>          
                  
          <li class="nav-item">
            <a href="#"  class="nav-link  @if (request()->routeIs('create-activites') or request()->routeIs('view-activites')) active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Activit??s
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="{{route('create-activites')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouvelle activit??e</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('view-activites')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Activit??s enregistr??es</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#"  class="nav-link  @if (request()->routeIs('add.collecteur') or request()->routeIs('view-collecteur')) active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Collecteurs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="{{route('add.collecteur')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouveau collecteur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('view-collecteur')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>collecteurs enregistr??s</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#"  class="nav-link  @if (request()->routeIs('add.zone') or request()->routeIs('view-zone')) active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Zones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="{{route('add.zone')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouvelle zone</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('view-zone')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>zones enregistr??s</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#"  class="nav-link  @if (request()->routeIs('etat.taxe') or request()->routeIs('etat.contribuable')) active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Etats
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="{{route('etat.contribuable')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Etat des contribuables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('etat.taxe')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Etat des taxes</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('content')


  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="">KBT ing??nierie</a>.</strong>
    Tout droit reserv??.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{secure_asset('plugins/jquery/jquery.min.js')}} "></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{secure_asset('plugins/jquery-ui/jquery-ui.min.js')}} "></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{secure_asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<!-- ChartJS -->
<script src="{{secure_asset('plugins/chart.js/Chart.min.js')}} "></script>
<!-- Sparkline -->
<script src="{{secure_asset('plugins/sparklines/sparkline.js')}} "></script>
<!-- JQVMap -->
<script src="{{secure_asset('plugins/jqvmap/jquery.vmap.min.js')}} "></script>
<script src="{{secure_asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}} "></script>
<!-- jQuery Knob Chart -->
<script src="{{secure_asset('plugins/jquery-knob/jquery.knob.min.js')}} "></script>
<!-- daterangepicker -->
<script src="{{secure_asset('plugins/moment/moment.min.js')}} "></script>
<script src="{{secure_asset('plugins/daterangepicker/daterangepicker.js')}} "></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{secure_asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}} "></script>
<!-- Summernote -->
<script src="{{secure_asset('plugins/summernote/summernote-bs4.min.js')}} "></script>
<!-- overlayScrollbars -->
<script src="{{secure_asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}} "></script>
<!-- AdminLTE App -->
<script src="{{secure_asset('dist/js/adminlte.js')}} "></script>
<!-- AdminLTE for demo purposes -->
<script src="{{secure_asset('dist/js/demo.js')}} "></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{secure_asset('dist/js/pages/dashboard.js')}} "></script>
<script src="{{secure_asset('select2/dist/js/select2.min.js')}}"></script>
<script src="{{secure_asset('js/addons/datatables.min.js')}}"></script>
<script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2();

      $('#dtBasicExample').DataTable();
      $('.dataTables_length').addClass('bs-select');

  });
</script>

</body>
</html>
