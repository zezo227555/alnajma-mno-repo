<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">AlnajmaCO</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 mr-2 d-flex">
        <div class="image">
          <img src="{{asset('images/user_photos/')}}/{{session('user_photo')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <span class="d-block text-white">{{session('username')}}</span>
        </div>
      </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @if (auth()->user()->role == 1)
        <li class="nav-item has-treeview {{ (request()->is('users*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              المستخدمين
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="{{ (request()->is('user*')) || (request()->is('admins*')) || (request()->is('accounters*')) || (request()->is('edit_alnajma_adds*')) ? 'display: block;' : 'display: none;' }} ">
            <li class="nav-item">
              <a href="{{ route('user.repos_account') }}" class="nav-link {{ (request()->is('users/account')) ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i>
                <p>حسابي الشخصي</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if (auth()->user()->role == 2 || auth()->user()->role == 3)
        <li class="nav-item has-treeview {{ (request()->is('user*')) || (request()->is('admins*')) || (request()->is('accounters*')) || (request()->is('edit_alnajma_adds*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('user*')) || (request()->is('admins*')) || (request()->is('accounters*')) || (request()->is('edit_alnajma_adds*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              المستخدمين
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="{{ (request()->is('user*')) || (request()->is('admins*')) || (request()->is('accounters*')) || (request()->is('edit_alnajma_adds*')) ? 'display: block;' : 'display: none;' }} ">
            <li class="nav-item">
              <a href="{{ route('user.create') }}" class="nav-link {{ (request()->is('user/create')) ? 'active' : '' }}">
                <i class="fa-solid fa-user-plus"></i>
                <p>اضافة مستخدم</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('user')) ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i>
                <p>قائمة المندوبين</p>
              </a>
            </li>
            @if (auth()->user()->role == 3)
            <li class="nav-item">
              <a href="{{ route('user.all_admins') }}" class="nav-link {{ (request()->is('admins')) ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i>
                <p>قائمة المشرفين</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('user.all_accounters') }}" class="nav-link {{ (request()->is('accounters')) ? 'active' : '' }}">
                <i class="fa-solid fa-money-bill"></i>
                <p>المالية</p>
              </a>
            </li>
            @endif
            @if (auth()->user()->role == 2)
            <li class="nav-item">
              <a href="{{ route('admins.admins_account') }}" class="nav-link {{ (request()->is('admins/account')) ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i>
                <p>حسابي الشخصي</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        @if (auth()->user()->role == 1)
        <li class="nav-item has-treeview {{ (request()->is('stores*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('stores*')) ? 'active' : '' }}">
            <i class="fa-solid fa-shop"></i>
            <p>
              المحلات
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="{{ (request()->is('stores*')) ? 'display: block;' : 'display: none;' }} ">
            <li class="nav-item">
              <a href="{{ route('stores.index') }}" class="nav-link {{ (request()->is('stores')) ? 'active' : '' }}">
                <i class="fa-solid fa-shop"></i>
                <p class="mx-1">قائمة المحلات</p>
              </a>
            </li>
            
          </ul>
        </li>
        @endif
        <li class="nav-item has-treeview {{ (request()->is('reports*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('reports*')) ? 'active' : '' }}">
            <i class="fa-solid fa-file"></i>
            <p>
              التقارير
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="{{ (request()->is('reports*')) ? 'display: block;' : 'display: none;' }} ">
            @if (auth()->user()->role == 1)
              <li class="nav-item">
                <a href="{{route('reports.admin_adds_to_repo_form')}}" class="nav-link {{ (request()->is('reports/admin_adds_to_repo_form')) ? 'active' : '' }}">
                  <i class="fa-solid fa-money-bill"></i>
                  <p>تقرير الاضافات</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reports.store_account_form')}}" class="nav-link {{ (request()->is('reports/store_account_form')) ? 'active' : '' }}">
                  <i class="fa-solid fa-rectangle-list"></i>
                  <p>كشف حساب للمحل</p>
                </a>
              </li>
            @elseif(auth()->user()->role == 2)
              <li class="nav-item">
                <a href="{{route('reports.alnajma_adda_to_admin_form')}}" class="nav-link {{ (request()->is('reports/alnajma_adda_to_admin_form')) ? 'active' : '' }}">
                  <i class="fa-solid fa-money-bill-transfer"></i>
                  <p>تقرير الاضافات من المالية</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reports.admin.repo_adds_form')}}" class="nav-link {{ (request()->is('reports/repo_adds_form')) ? 'active' : '' }}">
                  <i class="fa-solid fa-money-bill-transfer"></i>
                  <p>تقرير الشحنات للمندوبين</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reports.repos_salary_from')}}" class="nav-link {{ (request()->is('reports/repos_salary_from')) ? 'active' : '' }}">
                  <i class="fa-solid fa-money-bill"></i>
                  <p>مرتبات المندوبين</p>
                </a>
              </li>
            @else
              <li class="nav-item">
                <a href="{{route('reports.alnajma_adds_form')}}" class="nav-link {{ (request()->is('reports/alnajma_adds_form')) ? 'active' : '' }}">
                  <i class="fa-regular fa-address-book"></i>
                  <p>كشف حساب النجمة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reports.alnajma_adds_to_admin_form')}}" class="nav-link {{ (request()->is('reports/alnajma_adds_to_admin_form')) ? 'active' : '' }}">
                  <i class="fa-solid fa-file-invoice-dollar"></i>
                  <p>تقرير الاضافات للمشرف</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reports.repo_account_statment_form')}}" class="nav-link {{ (request()->is('reports/repo_account_statment_form')) ? 'active' : '' }}">
                  <i class="fa-solid fa-clipboard-user"></i>
                  <p>كشف حساب المندوب</p>
                </a>
              </li>
            @endif
            
          </ul>
        </li>
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>