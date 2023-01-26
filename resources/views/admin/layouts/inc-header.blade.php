<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
      <div class="nav-top flex-grow-1">
        <div class="container d-flex flex-row h-100 align-items-center">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center">
            <a class="navbar-brand brand-logo" href="{{ url('admin/dashboard') }}"><img src="{{ url('assets/img/LOGO CV-Full-Orange.gif') }}" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{ url('admin/dashboard') }}"><img src="{{ url('assets/img/LOGO CV-Full-Orange.gif') }}" alt="logo" style="max-width:120px"/></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between flex-grow-1">

            <ul class="navbar-nav navbar-nav-right mr-0 ml-auto">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                  MENU
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
             
                  <a href="{{ url('admin/dashboard') }}" class="dropdown-item"><i class="link-icon text-primary icon-pie-chart mr-2"></i><span class="menu-title">หน้าแรก</span></a>
                  <a href="{{ url('admin/product') }}" class="dropdown-item"><i class="link-icon text-primary icon-drawer mr-2"></i><span class="menu-title">สินค้า</span></a>
                  <a href="{{ url('admin/order') }}" class="dropdown-item"><i class="link-icon text-primary icon-wallet mr-2"></i><span class="menu-title">รายการแลกของ</span></a>
                  <a href="{{ url('admin/slide_show') }}" class="dropdown-item"><i class="link-icon text-primary icon-disc mr-2"></i><span class="menu-title">รูปสไลด์</span></a>
                  <a href="{{ url('admin/get_point') }}" class="dropdown-item"><i class="link-icon text-primary icon-magic-wand mr-2"></i><span class="menu-title">สะสมแต้มทั้งหมด</span></a>
                  <a href="{{ url('admin/setting') }}" class="dropdown-item"><i class="link-icon text-primary icon-people mr-2"></i><span class="menu-title">ตั้งค่า</span></a>
                  
                  
                </div>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right mr-0">


              <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                  <img src="{{ url('assets/img/1483556517.png') }}" alt="profile"/>
                  <span class="nav-profile-name"> {{ Auth::user()->name }} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item">
                    
					
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ url('logout') }}">
                    <i class="icon-logout text-primary mr-2"></i>
                    ออกจากระบบ
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="icon-menu text-dark"></span>
            </button>
          </div>
        </div>
      </div>
      <div class="nav-bottom">
        <div class="container">
          <ul class="nav page-navigation">
            <li class="nav-item">
              <a href="{{ url('admin/dashboard') }}" class="nav-link"><i class="link-icon icon-pie-chart"></i><span class="menu-title">หน้าแรก</span></a>
            </li>
           
            <li class="nav-item">
              <a href="{{ url('admin/product') }}" class="nav-link"><i class="link-icon icon-drawer"></i><span class="menu-title">สินค้า</span></a>
            </li>

            <li class="nav-item">
              <a href="{{ url('admin/order') }}" class="nav-link"><i class="link-icon icon-wallet"></i><span class="menu-title">รายการแลกของ</span></a>
            </li>

            <li class="nav-item">
              <a href="{{ url('admin/slide_show') }}" class="nav-link"><i class="link-icon icon-disc"></i><span class="menu-title">รูปสไลด์</span></a>
            </li>

            <li class="nav-item">
              <a href="{{ url('admin/get_point') }}" class="nav-link"><i class="link-icon icon-magic-wand"></i><span class="menu-title">สะสมแต้มทั้งหมด</span></a>
            </li>

            <li class="nav-item">
              <a href="{{ url('admin/users') }}" class="nav-link"><i class="link-icon icon-people"></i><span class="menu-title">ผู้ใช้งาน</span></a>
            </li>

           

            <li class="nav-item">
              <a href="{{ url('admin/setting') }}" class="nav-link"><i class="link-icon icon-settings"></i><span class="menu-title">ตั้งค่า</span></a>
            </li>
            
			



          </ul>
        </div>
      </div>
    </nav>
