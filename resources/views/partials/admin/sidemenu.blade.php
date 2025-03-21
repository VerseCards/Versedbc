@php
    // $logo=asset(Storage::url(''));
    $company_logo = \App\Models\Utility::GetLogo();
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $users = \Auth::user();
    $bussiness_id='';
    $bussiness_id = $users->current_business;
	$total_business_cards = \App\Models\Business::where('user_id', $users->id)->count();
@endphp


<!-- [ navigation menu ] start -->

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif

<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">
            @if ($setting['cust_darklayout'] == 'on')
                <img src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png').'?'.time() }}"
                    alt="" class="img-fluid" />
            @else
                <img src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png').'?'.time() }}"
                    alt="" class="img-fluid" />
            @endif
        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">
            <li
                class="dash-item {{ Request::segment(1) == 'home' || Request::segment(1) == '' || Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="dash-link"><span class="dash-micon"><i
                            class="ti ti-home"></i></span><span class="dash-mtext">{{ __('Dashboard') }}</span></a>

            </li>
            <li class="dash-item dash-hasmenu">
                <a class="dash-link {{ Request::segment(1) == 'new_business' || Request::segment(1) == 'business' ? 'active' : '' }}"
                    data-toggle="collapse" role="button"
                    aria-expanded="{{ Request::segment(1) == 'new_business' || Request::segment(1) == 'business' ? 'true' : 'false' }}"
                    aria-controls="navbar-getting-started"><span class="dash-micon"><i
                            class="ti ti-credit-card"></i></span><span class="dash-mtext">{{ __('Business Cards') }}</span><span
                        class="dash-arrow"><i data-feather="chevron-right"></i></span>
                </a>
                <ul class="dash-submenu">
                    @if ($users->type == 'techsupport' || $total_business_cards <= 100)
                        <li class="dash-item {{ Request::segment(1) == 'new_business' ? 'active' : '' }}">
                            <a href="#" class="dash-link" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                data-url="{{ route('business.create') }}" data-size="xl"
                                data-bs-whatever="{{ __('Create Versecard') }}"> {{ __('Create Card') }}
                            </a>
                        </li>
                    @endif
                    
                        <li class="dash-item {{ Request::segment(1) == 'business' ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('business.index') }}">{{ __('Manage Cards') }}</a>

                        </li>
                    
                </ul>
            </li>
			
                <li class="dash-item {{ Request::segment(1) == 'contacts' ? 'active' : '' }}">
                    <a href="{{ route('contacts.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-phone"></i></span><span class="dash-mtext">{{ __('Contacts') }}</span></a>

                </li>
            
                
				<li class="dash-item {{ Request::segment(1) == 'leadcampaign' ? 'active' : '' }}">
                    <a href="{{ route('campaign.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-phone"></i></span><span class="dash-mtext">{{ __('Leads Campaign') }}</span></a>

                </li>
           
			@if ($users->type == 'company' || $users->type == 'techsupport')
            <li class="dash-item dash-hasmenu">
					
                <a class="dash-link {{ Request::segment(1) == 'employee' || Request::segment(1) == 'client' ? 'active' : '' }}"
                    data-toggle="collapse" role="button"
                    aria-expanded="{{ Request::segment(1) == 'employee' || Request::segment(1) == 'client' ? 'true' : 'false' }}"
                    aria-controls="navbar-getting-started"><span class="dash-micon"><i
                            class="ti ti-users"></i></span><span class="dash-mtext">{{ __('Manage Staff') }}</span><span
                        class="dash-arrow"><i data-feather="chevron-right"></i></span>
                </a>
				
                <ul class="dash-submenu">
                   
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' ? 'active open' : '' }}">
                            <a class="dash-link"
                                {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : '' }}
                                href="{{ route('users.index') }}">{{ __('Users') }}</span></a>
                        </li>
                   
                    
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'roles' ? 'active open' : '' }}">
                            <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Department') }}</a>
                        </li>
                    

                </ul>
            </li>
			
            

				@endif
				<li class="dash-item {{ Request::segment(1) == 'tap-history' ? 'active' : '' }}">
                    <a href="{{ route('loadTaps') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-calendar"></i></span><span
                            class="dash-mtext">{{ __('NFC History') }}</span></a>

                </li>
            
            @if ($users->type == 'techsupport')
                <li class="dash-item {{ Request::segment(1) == 'email_template_lang' ? 'active' : '' }}">
                    <a href="{{ route('manage.email.language', $users->lang) }}" class="dash-link"><span
                            class="dash-micon"><i class="ti ti-mail"></i></span><span
                            class="dash-mtext">{{ __('Email Template') }}</span></a>
                </li>
            
                <li class="dash-item {{ Request::segment(1) == 'systems' ? 'active' : '' }}">
                    <a href="{{ route('systems.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-settings"></i></span><span
                            class="dash-mtext">{{ __('Settings') }}</span></a>

                </li>
            @endif
			
                <li class="dash-item {{ Request::segment(1) == '2faVerify' ? 'active' : '' }}">
                    <a href="{{ route('show2faForm') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-settings"></i></span><span
                            class="dash-mtext">{{ __('Multi FA') }}</span></a>

                </li>
				
				<li class="dash-item {{ Request::segment(1) == 'profile' ? 'active' : '' }}">
                    <a href="{{ route('profile') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-user"></i></span><span
                            class="dash-mtext">{{ __('Profile') }}</span></a>

                </li>
				<li class="dash-item {{ Request::segment(1) == 'logout' ? 'active' : '' }}">
                    <a href="{{ route('logout') }}" class="dash-link" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><span class="dash-micon"><i
                                class="ti ti-power"></i></span><span
                            class="dash-mtext">{{ __('Logout') }}</span></a>
					<form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>

                </li>
				
          
        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
