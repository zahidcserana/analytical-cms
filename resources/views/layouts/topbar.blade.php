
	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search" style="position: absolute;">
                <p class="text-center text-info h4" style="font-size: 17px;color: darkgoldenrod !important">{{ Config::get('settings.title') }}    <i style="color: darkolivegreen"><small>Powered by</small>&nbsp;</i><a class="link-a" href="{{ Config::get('settings.company.website') }}" target="_blank"><i class="fa fa-copyright" aria-hidden="true">{{ ENV('APP_NAME') }}</i></a></p>
			</div>
		</div>
		<div class="header-right">
			{{-- <div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
						<i class="dw dw-settings2"></i>
					</a>
				</div>
			</div>
			<div class="user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
						<i class="icon-copy dw dw-notification"></i>
						<span class="badge notification-active"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="notification-list mx-h-350 customscroll">
							<ul>
								<li>
									<a href="#">
										<img src="{{ asset('assets/vendors/images/img.jpg') }}" alt="">
										<h3>John Doe</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
									</a>
								</li>
								<li>
									<a href="#">
										<img src="{{ asset('assets/vendors/images/photo1.jpg') }}" alt="">
										<h3>Lea R. Frith</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
									</a>
								</li>
								<li>
									<a href="#">
										<img src="{{ asset('assets/vendors/images/photo2.jpg') }}" alt="">
										<h3>Erik L. Richards</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
									</a>
								</li>
								<li>
									<a href="#">
										<img src="{{ asset('assets/vendors/images/photo3.jpg') }}" alt="">
										<h3>John Doe</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
									</a>
								</li>
								<li>
									<a href="#">
										<img src="{{ asset('assets/vendors/images/photo4.jpg') }}" alt="">
										<h3>Renee I. Hansen</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
									</a>
								</li>
								<li>
									<a href="#">
										<img src="{{ asset('assets/vendors/images/img.jpg') }}" alt="">
										<h3>Vicki M. Coleman</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div> --}}
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="{{ Config::get('settings.company.website') }}" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="{{ asset(Config::get('settings.company.images.profile')) }}" alt="">
						</span>
						<span class="user-name">{{ Auth::user()->name }}</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
                            <i class="dw dw-logout"></i>
							<span class="nav-link-text">{{ __('Logout') }}</span>
						</a>
					</div>
				</div>
			</div>
{{--			<div class="github-link">--}}
{{--				<a href="{{ Config::get('settings.company.website') }}" target="_blank"><img src="{{ asset('assets/vendors/images/aj/sidelogo.svg') }}" alt=""></a>--}}
{{--			</div>--}}
		</div>
	</div>
