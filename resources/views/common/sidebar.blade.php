<!-- Main Sidebar Container -->
@php 
        $generalSetting = get_general_settings();
        $siteLogo       = '';
        $siteficon      = '';
        $siteTitle      = '';
        if(!empty($generalSetting)){
            if(isset($generalSetting['gs_ficon'])){
                $siteURL         = $generalSetting['gs_site_url'];
                $siteURL         = $siteURL ? $siteURL : '';
                
                $siteLogo        = $generalSetting['gs_sitelogo'];
                $siteLogo        = $siteLogo ? $siteLogo : '';
                
                $siteSidebarIcon = $generalSetting['gs_sidebaricon'];
                $siteSidebarIcon = $siteSidebarIcon ? $siteSidebarIcon : '';

                $siteficon       = $generalSetting['gs_ficon'];
                $siteficon       = $siteficon ? $siteficon : '';

                $siteTitle       = $generalSetting['gs_sitetitle'];
                $siteTitle       = $siteTitle ? $siteTitle : '';
               
                $sitePhone       = $generalSetting['gs_phone'];
                $sitePhone       = $sitePhone ? $sitePhone : '';
                
                $siteEmail       = $generalSetting['gs_email'];
                $siteEmail       = $siteEmail ? $siteEmail : '';
                /* SOCIAL LINKS*/
                $siteFblink      = $generalSetting['gs_fblink'];
                $siteFblink      = $siteFblink ? $siteFblink : '';
                $siteInstalink   = $generalSetting['gs_instalink'];
                $siteInstalink   = $siteInstalink ? $siteInstalink : '';
                $sitegmlink      = $generalSetting['gs_gmaplink'];
                $sitegmlink      = $sitegmlink ? $sitegmlink : '';
                $siteaddress      = $generalSetting['gs_addressinfo'];
                $siteaddress      = $siteaddress ? $siteaddress : '';
                // $siteTlink       = $generalSetting['gs_tlink'];
                // $siteTlink       = $siteTlink ? $siteTlink : '';
                // $siteYlink       = $generalSetting['gs_ylink'];
                // $siteYlink       = $siteYlink ? $siteYlink : '';
                
                $siteCopyright   = $generalSetting['gs_copyinfo'];
                $siteCopyright   = $siteCopyright ? $siteCopyright : '';
            }
        }
        @endphp
    
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}/admin" class="brand-link">
        @if(!empty($siteSidebarIcon))
          <img src="{{ asset($siteSidebarIcon) }}" alt="{{$siteTitle}}" class="brand-image img-circle elevation-3" style="opacity: .8">
        @endif
        <span class="brand-text font-weight-light">{{$siteTitle}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div> --}}

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @if(isset($usermenu))
          @foreach($usermenu as $key => $menu)
            @if(in_array($key, $menus) || Auth::user()->user_type=="SuperAdmin" || Auth::user()->user_type == "Admin")
              @php
                $active_link = array();
                foreach($menu['active_link'] as $val){
                  if($val!='admin'){
                    $active_link[] = $val."/*";
                  }else{
                    $active_link[] = $val;
                  }
                }
              @endphp
              <li class="nav-item {{ (isset($menu['sub']) && !(empty($menu['sub']))) ? (((in_array(Request::path(), $menu['active_link'])) || Request::is($active_link)) ? 'has-treeview menu-open' : 'has-treeview') : '' }}">
                <a href="{{ $menu['link']}}" class="nav-link {{ (in_array(Request::path(), $menu['active_link']) || Request::is($active_link)) ? 'active' : '' }}">
                  <i class="fas {{ $menu['icon']}} nav-icon"></i>
                  <p>
                    {{ $menu['value'] }}
                    @if(isset($menu['sub']) && !(empty($menu['sub'])))
                      <i class="fas fa-angle-left right"></i>
                    @endif
                  </p>
                </a>
                @if(isset($menu['sub']) && !(empty($menu['sub'])))
                <ul class="nav nav-treeview">
                    @foreach($menu['sub'] as $submenu)
                      @php
                      $subactive_link = array();
                      foreach($submenu['active_link'] as $subval){
                        if($subval!='admin'){
                          // $subactive_link[] = $subval."/*";
                          $subactive_link[] = $subval."/";
                        }else{
                          $subactive_link[] = $subval;
                        }
                      }
                      @endphp
                      <li class="nav-item">
                        <a href="{{ $submenu['link'] }}" class="nav-link {{ (in_array(Request::path(), $submenu['active_link']) || Request::is($subactive_link)) ? 'active' : '' }}">
                          <i class="far {{ $submenu['icon'] }} nav-icon"></i>
                          <p>{{ $submenu['value'] }}</p>
                        </a>
                      </li>
                    @endforeach
                </ul>
                @endif
              </li>
            @endif
          @endforeach
        @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>