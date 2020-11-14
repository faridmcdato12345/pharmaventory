<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>PHARMAVENTORY</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
  <style>
    @media print
    {
      html, body { height: auto; }
      .dt-print-table,.dt-print-table thead tr:nth-child(1) th,.dt-print-table thead tr:nth-child(2) th {border: 0 none !important;}
      .dt-print-table img{
        width:100px;
        text-align: left !important;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars" style="color:
          #D50000"></i></a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light">PHARMAVENTORY</span>
    </a>
    <div class="sidebar">
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <p class="d-block text-white">Username: {{Auth::user()->username}}</p>
            <p class="text-md text-white uppercase">Role: {{Auth::user()->roles->name}}</p>
        </div>
      </div> --}}
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dashboard">
            <a href="{{route('dashboard.index')}}" class="nav-link">
              <i class="nav-icon fa fa-tachometer-alt"></i>
              <p>
                DASHBOARD
              </p>
            </a>
          </li>
          <li class="nav-item dashboard">
            <a href="{{route('admin.new.pos')}}" class="nav-link">
              <i class="nav-icon fa fa-cart-plus"></i>
              <p>
                POINT OF SALE - POS
              </p>
            </a>
          </li>
          @if (Auth::user()->role_id == 1)
          <li class="nav-item user">
            <a href="{{route('product.index')}}" class="nav-link">
              <i class="nav-icon fa fa-list-alt"></i>
              <p>
                PRODUCT MANAGEMENT
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                PRODUCT ATTRIBUTE
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item maintenance">
              <a href="{{route('types.index')}}" class="nav-link">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type</p>
                </a>
              </li>
              <li class="nav-item blanket">
              <a href="{{route('potencies.index')}}" class="nav-link">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Potency</p>
                </a>
              </li>
              <li class="nav-item project">
                <a href="{{route('packagings.index')}}" class="nav-link">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Packaging</p>
                </a>
              </li>
              <li class="nav-item metering">
                <a href="{{route('brands.index')}}" class="nav-link">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Brand</p>
                </a>
              </li>
              <li class="nav-item sitio">
                <a href="{{route('categories.index')}}" class="nav-link">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview material_credit">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
               REPORT
               <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item maintenance">
                  <a href="{{route('inventory.report')}}" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inventory Report</p>
                  </a>
                </li>
                <li class="nav-item blanket">
                <a href="{{route('sales.report')}}" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sales Report</p>
                  </a>
                </li>
              </ul>
          </li>
          @endif
          <li class="nav-item has-treeview setting">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                SETTINGS
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item profile">
                <a href="#" class="nav-link password">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Password</p>
                </a>
              </li>
              <li class="nav-item profile">
                <a href="{{route('business.index')}}" class="nav-link password">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Business Management</p>
                </a>
              </li>
              <li class="nav-item profile">
                <a href="{{route('storage.index')}}" class="nav-link password">
                  <i class="nav-icon"></i>
                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Storage Management</p>
                </a>
              </li>
            </ul>
          </li>
          @if(Auth::user()->role_id == 1)
          <li class="nav-item import">
            <a href="{{route('invoice.all')}}" class="nav-link">
              <i class="nav-icon fa fa-receipt"></i>
                <p>
                  INVOICES
                </p>
              </a>
          </li>
          <li class="nav-item import">
          <a href="{{route('user.log.index')}}" class="nav-link">
            <i class="nav-icon fa fa-user"></i>
              <p>
                USERS LOG
              </p>
            </a>
          </li>
          <li class="nav-item import">
            <a href="{{route('user.index')}}" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
                <p>
                  USERS
                </p>
              </a>
            </li>
          @endif
          <li class="nav-item form-group">
            <a href="{{ route('logout') }}" class="nav-link btn btn-danger text-white text-left" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="nav-icon fa fa-sign-out-alt" ></i>
                <p>
                LOGOUT
                </p>
            </a>
          </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
        </ul>
      </nav>
      </div>
    </aside>
  <div class="content-wrapper overflow-y-auto">
    @yield('content')
    @include('includes.modal.modal')
    @include('includes.modal.attribute-modal')
  </div>
  <input type="hidden" value="{{Auth::user()->api_token}}" id="user-api-token">
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date("Y");?> <a href="#">PHARMAVENTORY</a>.</strong> All rights reserved.
  </footer>
</div>
</body>

<script src="{{asset('js/app.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script>
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@include('sweetalert::alert')
@yield('script')
@include('includes.scripts.product-attribute')

</html>
