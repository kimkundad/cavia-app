<!-- Navigation
	================================================== -->

	<!-- Responsive Navigation Trigger -->
	<a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>

	<div class="dashboard-nav">
		<div class="dashboard-nav-inner">

			<ul data-submenu-title="Main">
				<li><a href="{{ url('admin/dashboard') }}"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
				<li><a href="{{ url('admin/blog') }}"><i class="sl sl-icon-layers"></i> บทความ</a></li>
				<li><a href="{{ url('admin/blog/create') }}"><i class="sl sl-icon-plus"></i> เพิ่มบทความ</a></li>
			</ul>

			<ul data-submenu-title="Account">
				
				<li><a href="{{ url('logout') }}"><i class="sl sl-icon-power"></i> ออกจากระบบ</a></li>
			</ul>
			
		</div>
	</div>
	<!-- Navigation / End -->