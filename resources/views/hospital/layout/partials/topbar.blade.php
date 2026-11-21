<!-- Header -->
<div class="header">
	<div class="main-header">

		<!-- Logo -->
		<div class="header-left active">
			<a href="{{url('index')}}" class="logo logo-normal">
				<img src="{{URL::asset('build/img/logo.png')}}" alt="Img">
			</a>
			<a href="{{url('index')}}" class="logo logo-white">
				<img src="{{URL::asset('build/img/logo-white.svg')}}" alt="Img">
			</a>
			<a href="{{url('index')}}" class="logo-small">
				<img src="{{URL::asset('build/img/logo-small.png')}}" alt="Img">
			</a>
		</div>
		<!-- /Logo -->

		<a id="mobile_btn" class="mobile_btn" href="#sidebar">
			<span class="bar-icon">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</a>

		<!-- Header Menu -->
		<ul class="nav user-menu" style="justify-content: end">
			<li class="nav-item nav-item-box">
				<a href="javascript:void(0);" id="btnFullscreen">
					<i class="ti ti-maximize"></i>
				</a>
			</li>
			<li class="nav-item dropdown has-arrow main-drop profile-nav">
				<a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
					<span class="user-info p-0">
						<span class="user-letter">
							<img src="{{URL::asset('build/img/profiles/avator1.jpg')}}" alt="Img" class="img-fluid">
						</span>
					</span>
				</a>
				<div class="dropdown-menu menu-drop-user">
					<div class="profileset d-flex align-items-center">
						<span class="user-img me-2">
							<img src="{{asset('website/assets/favicon.png')}}" alt="Img">
						</span>
						<div>
							<h6 class="fw-medium">{{ Auth::guard('hospital')->user()->hospital_name ?? 'Hospital' }}</h6>
						</div>
					</div>
					<hr class="my-2">
					<form action="{{ route('hospital.logout') }}" method="POST">
						@csrf
						<button type="submit" class="dropdown-item">
							<i class="ti ti-logout me-2"></i>Logout
						</button>
					</form>
				</div>
			</li>
		</ul>
		<!-- /Header Menu -->

		<!-- Mobile Menu -->
		<div class="dropdown mobile-user-menu">
			<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
				aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<form action="{{ route('hospital.logout') }}" method="POST">
					@csrf
					<button type="submit" class="dropdown-item">
						<i class="ti ti-logout me-2"></i>Logout
					</button>
				</form>
			</div>
		</div>
		<!-- /Mobile Menu -->
	</div>
</div>
<!-- /Header -->