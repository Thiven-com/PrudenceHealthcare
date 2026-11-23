@if (!Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
	<!-- Sidebar -->
	<div class="sidebar" id="sidebar">
@endif
	@if (Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
		<!-- Sidebar -->
		<div class="sidebar d-none" id="sidebar">
	@endif
		<!-- Logo -->
		<div class="sidebar-logo">
			<a href="{{ route('hospital.dashboard') }}" class="logo logo-normal">
				<img src="{{URL::asset('build/img/logo.png')}}" alt="Img">
			</a>
			<a href="{{ route('hospital.dashboard') }}" class="logo logo-white">
				<img src="{{URL::asset('build/img/logo-white.svg')}}" alt="Img">
			</a>
			<a href="{{ route('hospital.dashboard') }}" class="logo-small">
				<img src="{{URL::asset('build/img/logo-small.png')}}" alt="Img">
			</a>
			<a href="{{ route('hospital.dashboard') }}" class="logo-small-white">
				<img src="{{URL::asset('build/img/logo-small-white.png')}}" alt="Img">
			</a>
			<a id="toggle_btn" href="javascript:void(0);">
				<i data-feather="chevrons-left" class="feather-16"></i>
			</a>
		</div>
		<!-- /Logo -->
		<div class="modern-profile p-3 pb-0">
			<div class="text-center rounded bg-light p-3 mb-4 user-profile">
				<div class="avatar avatar-lg online mb-3">
					<img src="{{URL::asset('build/img/customer/customer15.jpg')}}" alt="Img"
						class="img-fluid rounded-circle">
				</div>
				<h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
				<p class="fs-12 mb-0">System Admin</p>
			</div>
			<div class="sidebar-nav mb-3">
				<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
					<li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
					<li class="nav-item"><a class="nav-link border-0" href="{{url('chat')}}">Chats</a></li>
					<li class="nav-item"><a class="nav-link border-0" href="{{url('email')}}">Inbox</a></li>
				</ul>
			</div>
		</div>
		<div class="sidebar-header p-3 pb-0 pt-2">
			<div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
				<div class="avatar avatar-md onlin">
					<img src="{{URL::asset('build/img/customer/customer15.jpg')}}" alt="Img"
						class="img-fluid rounded-circle">
				</div>
				<div class="text-start sidebar-profile-info ms-2">
					<h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
					<p class="fs-12">System Admin</p>
				</div>
			</div>
			<div class="d-flex align-items-center justify-content-between menu-item mb-3">
				<div>
					<a href="{{ route('hospital.dashboard') }}" class="btn btn-sm btn-icon bg-light">
						<i class="ti ti-layout-grid-remove"></i>
					</a>
				</div>
				<div>
					<a href="{{url('chat')}}" class="btn btn-sm btn-icon bg-light">
						<i class="ti ti-brand-hipchat"></i>
					</a>
				</div>
				<div>
					<a href="{{url('email')}}" class="btn btn-sm btn-icon bg-light position-relative">
						<i class="ti ti-message"></i>
					</a>
				</div>
				<div class="notification-item">
					<a href="{{url('activities')}}" class="btn btn-sm btn-icon bg-light position-relative">
						<i class="ti ti-bell"></i>
						<span class="notification-status-dot"></span>
					</a>
				</div>
				<div class="me-0">
					<a href="{{url('general-settings')}}" class="btn btn-sm btn-icon bg-light">
						<i class="ti ti-settings"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="sidebar-inner slimscroll">
			<div id="sidebar-menu" class="sidebar-menu">
				<ul>
					<li class="submenu-open">
						<h6 class="submenu-hdr">Main</h6>
						<ul>
							<li class="{{ Route::is('hospital.dashboard') ? 'active' : '' }}">
								<a href="{{ route('hospital.dashboard') }}">
									<i class="ti ti-layout-grid fs-16 me-2"></i>
									<span>Dashboard</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="submenu-open">
						<h6 class="submenu-hdr">HRM</h6>
						<ul>
							<li class="{{ Route::is('hospital.departments.*') ? 'active' : '' }}">
								<a href="{{ route('hospital.departments.index') }}">
									<i class="ti ti-layout-grid fs-16 me-2"></i>
									<span>Departments</span>
								</a>
							</li>
							<li class="{{ Route::is('hospital.designations.*') ? 'active' : '' }}">
								<a href="{{ route('hospital.designations.index') }}">
									<i class="ti ti-layout-grid fs-16 me-2"></i>
									<span>Designations</span>
								</a>
							</li>
							<li class="{{ Route::is('hospital.staff.*') ? 'active' : '' }}">
								<a href="{{ route('hospital.staff.index') }}">
									<i class="ti ti-layout-grid fs-16 me-2"></i>
									<span>Staff</span>
								</a>
							</li>
							<li class="{{ Route::is('hospital.leads.*') ? 'active' : '' }}">
								<a href="{{ route('hospital.leads.index') }}">
									<i class="ti ti-layout-grid fs-16 me-2"></i>
									<span>Leads</span>
								</a>
							</li>
							<li class="{{ request()->routeIs('hospital.additional-details.*') ? 'active' : '' }}">
								<a href="{{ route('hospital.additional-details.index') }}">
									<i class="ti ti-building-hospital fs-16 me-2"></i>
									<span>Hospital Additional Details</span>
								</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- /Sidebar -->