<!DOCTYPE html>
<html lang="">

  @include('_includes.head')

  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" data-select2-id="17">
    <div class="wrapper">

      @include('_includes.navbar')
      @include('_includes.sidebar')
      <!-- Content Wrapper. Contains page content -->
      
        <div class="content-wrapper px-4">
          <div class="content-header">
            <div class="row">
              <div class="col-sm-4 w-100">
                <h1 class="text-dark">@yield('page_name')</h1>
              </div>
              <div class="col-sm-4 w-100 mt-3">
                @yield('page_info')
              </div>
              <div class="col-sm-4 w-100 mt-3">
                @yield('page_action')
              </div>
            </div>
          </div>

            <div style="overflow: scroll; height: 32rem;">
              <div class="content">
                @yield('page_content')
              </div>
            </div>

        </div>
      

      
    
      @include('_includes.footer')
    </div>

    @include('_includes.foot')

    @yield('models')

    @yield('my_scripts')
  </body>
</html>
