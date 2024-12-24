@php
    $card_theme = json_decode($business->card_theme);
    $content = json_decode($business->content);
    $no = 1;
    $social_no = 1;
    $stringid = $business->id;
    $appointment_no = 0;
	$leadgeneration_no = 0;
    $service_row_no = 0;
    $testimonials_row_no = 0;
    $gallery_row_no = 0;
    $is_preview_bussiness_hour = 'false';
    $banner = \App\Models\Utility::get_file('card_banner');
    $logo = \App\Models\Utility::get_file('card_logo');
    $image = \App\Models\Utility::get_file('testimonials_images');
    $s_image = \App\Models\Utility::get_file('service_images');
    $meta_image = \App\Models\Utility::get_file('meta_image');
    $gallery_path = \App\Models\Utility::get_file('gallery');
    $qr_path = \App\Models\Utility::get_file('qrcode');
    $SITE_RTL = Utility::settings()['SITE_RTL'];
    $chatgpt_setting= App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
    $users = \Auth::user();
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    $bussiness_id = $users->current_business;
@endphp
@extends('layouts.admin')
@push('css-page')
    <link rel="stylesheet" href="{{ asset('custom/libs/dropzonejs/dropzone.css') }}">
    <style>
        @import url({{ asset('css/font-awesome.css') }});

        .image {
            position: relative;
        }

        .image .actions {
            right: 1em;
            top: 1em;
            display: block;
            position: absolute;
        }

        .image .actions a {
            display: inline-block;
        }
    </style>
@endpush
@section('page-title')
    {{ __('Edit Business Card') }}
@endsection
@section('title')
    {{ __('') }}
@endsection

@section('action-btn')
@if ($business->status != 'lock')
    <div class="d-flex align-items-center justify-content-end gap-2">
<div class="">
                    {{-- //business Display Start --}}
                    

                    {{-- //business Display End --}}
                </div>
						
						<button type="button" class="btn hide-switch"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" >
                                <i class="feather icon-more-vertical" ></i>
                        </button>
						<div class="dropdown-menu dropdown-menu-end">
                                    
                                    @can('view analytics business')
									<a href="{{ route('business.analytics', $business->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-brand-google-analytics"></i>
                                            <span class="ml-2"> {{ __('View Analytics') }}</span>
                                        </a>
									@endcan
									@can('calendar appointment')
										<a href="{{ route('appointment.calendar', $business->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-calendar"></i>
                                            <span class="ml-2"> {{ __('My Calendar') }}</span>
                                        </a>
									@endcan
									@can('manage contact')
										<a href="{{ route('business.contacts.show', $business->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-phone"></i>
                                            <span class="ml-2"> {{ __('View Contacts') }}</span>
                                        </a>
										
									@endcan
																		
									@can('calendar appointment')
										<a href="#"
                                            class="dropdown-item user-drop" data-bs-toggle="modal"  data-bs-target="#qrcodeModal" id="download-qr">
                                            <i class="fa fa-qrcode"></i>
                                            <span class="ml-2"> {{ __('Download QR Code') }}</span>
                                        </a>
									@endcan
									
										<a href="{{ url('/' . $business->slug) }}" target="-blank" 
                                            class="dropdown-item user-drop">
                                            <i class="fa fa-eye"></i>
                                            <span class="ml-2"> {{ __('Preview Link') }}</span>
                                        </a>

									<a href="#"
                                            class="dropdown-item user-drop cp_link" data-link="{{ url('/' . $business->slug) }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Click to copy card link') }}">
                                            <i class="ti ti-copy"></i>
                                            <span class="ml-2"> {{ __('Copy Link') }}</span>
                                        </a>
									
										@can('delete business')
											<a href="#" class="bs-pass-para dropdown-item user-drop"  data-confirm="{{__('Delete Business Card?')}}" data-text="{{__('This action will delete this business card permanently. Continue?')}}" data-confirm-yes="delete-form-{{ $business->id }}" title="{{__('Delete')}}" data-bs-toggle="tooltip" data-bs-placement="top"><i class="ti ti-trash"></i><span class="ml-2">{{__('Delete')}}</span></a>
											
										
									   
											<span class="edit-icon align-middle bg-gray"><i
												  class="fas fa-lock text-white"></i></span>
															
															

											{!! Form::open([
												'method' => 'DELETE',
												'route' => ['business.destroy', $business->id],
												'id' => 'delete-form-' . $business->id,
											]) !!}
											{!! Form::close() !!}
										@endcan
                                    
                            </div>
        
    </div>
@endif
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header pt-3 d-none">
        <div class="page-block">
            <div class="row gy-4 align-items-center">
                <div class="col-md-4">
                    {{-- //business Display Start --}}
                    

                    {{-- //business Display End --}}
                </div>
                <div class="col-md-8 d-none">
                    <ul class="nav nav-pills nav-fill information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(!session('tab') or (session('tab') and session('tab') == 1)) active @endif" id="theme-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#theme-setting" type="button">{{__('Theme')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 2) active @endif" id="details-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#details-setting" type="button">{{__('Details')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 3) active @endif" id="domain-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#domain-setting" type="button">{{__('Custom')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 4) active @endif" id="block-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#block-setting" type="button">{{__('Change Blocks')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 5) active @endif" id="seo-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#seo-setting" type="button">{{__('SEO')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 6) active @endif" id="pwa-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#pwa-setting" type="button">{{__('PWA')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 7) active @endif" id="cookie-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#cookie-setting" type="button">{{__('Cookie')}}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(session('tab') and session('tab') == 8) active @endif" id="qrcode-setting-tab" data-bs-toggle="pill"
                                data-bs-target="#qrcode-setting" type="button">{{__('QR Code')}}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row ">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade @if(!session('tab') or (session('tab') and session('tab') == 1)) active show @endif" id="theme-setting" role="tabpanel"
                            aria-labelledby="pills-user-tab-1">
							
							<div class="row gy-4">
                                <div class="col-lg-10 col-md-10">
                                    <div class="theme-detail-card card">
                                        {{ Form::open(['route' => ['business.update', $business->id], 'method' => 'put', 'enctype' => 'multipart/form-data','onsubmit' => 'return submitForm()']) }}
                                        <input type="hidden" name="url" value="{{ url('/') }}"
                                            id="url">
                                         <input type="hidden" name="url" value="{{ $chatgpt_setting['enable_chatgpt'] }}"
                                            id="chatgpt">
                                        <div class="d-flex align-items-center justify-content-between mb-4 ">
                                            <h5 class="mb-0">{{__('Edit Personal Info')}}</h5>
                                            <button type="submit" class="btn btn-primary d-none"> <i class="me-2"
                                                    data-feather="folder"></i> {{__('Update Card')}}</button>
                                        </div>
										
                                        <div class="theme-detail-body">
										@if ($users->type == 'company')
                                            <div class="row mb-4">
                                                <div class="col-lg-8">
                                                    <p class="mb-2">{{__('Background Image')}}</p>
                                                    <div class="setting-block banner-setting">
                                                        <div class="position-relative overflow-hidden rounded">
                                                            <img src="{{ isset($business->banner) && !empty($business->banner) ? $banner . '/' . $business->banner : asset('custom/img/placeholder-image1.png') }}"
                                                                alt="images" class="w-100 imagepreview" id="banner">
                                                            <div
                                                                class="position-absolute top-50  end-0 start-0 text-center">
                                                                <div class="choose-file">
                                                                    <input
                                                                        class="custom-input-file custom-input-file-link banner d-none"
                                                                        type="file" name="banner" id="file-1" multiple="">
                                                                        <label for="file-1">
                                                                            <button type="button" 
                                                                                onclick="selectFile('banner')" class="btn btn-primary"><i
                                                                                class="me-2" data-feather="upload"></i>{{ __('Upload Banner...') }}</button>
                                                                        </label>
                                                                    

                                                                </div>
                                                                @error('banner')
                                                                    <span class="invalid-favicon text-xs text-danger"
                                                                        role="alert">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <p class="mb-2">{{__('Profile Picture')}}</p>
                                                    <div class="setting-block banner-small-setting">
                                                        <div class="position-relative">
                                                            <img src="{{ isset($business->logo) && !empty($business->logo) ? $logo.'/'.$business->logo: asset('custom/img/logo-placeholder-image-2.jpg') }}"
                                                                alt="images" id="business_logo">
                                                            <div
                                                                class="position-absolute top-50  end-0 start-0 text-center">
                                                                <div class="choose-file">
                                                                    <input class="d-none business_logo" type="file"
                                                                        name="logo" id="file-2" multiple="">
                                                                        <label for="file-2">
                                                                            <button type="button" 
                                                                                onclick="selectFile('business_logo')" class="btn btn-primary"><i
                                                                                class="me-2" data-feather="upload"></i>{{ __('Upload Picture') }}</button>
                                                                        </label>
                                                                    
                                                                    <input type="hidden" name="business_id"
                                                                        value="{{ $business->id }}">
                                                                    @error('logo')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											@endif
                                            <span class="invalid-favicon text-m text-danger" id="banner_validate"></span>
                                            <div class="row">
                                                
                                                <div class="col-12">
                                                    {{-- <form action=""> --}}
                                                        <div class="row">
														@if ($users->type == 'company')
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('Title', __('Name'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('title', $business->title, ['class' => 'form-control', 'id' => $stringid . '_title', 'placeholder' => __('Enter Title')]) }}
                                                                    @error('title')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('Designation', __('Department'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('designation', $business->designation, ['class' => 'form-control', 'id' => $stringid . '_designation', 'placeholder' => __('Enter Department')]) }}
                                                                    @error('title')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('Sub_Title', __('Designation'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('sub_title', $business->sub_title, ['class' => 'form-control ', 'id' => $stringid . '_subtitle', 'placeholder' => __('Enter Designation' )]) }}
                                                                    @error('sub_title')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
															<div class="col-12">
                                                                <div class="form-group">
                                                                    {{ Form::label('Description', __('Brief Bio'), ['class' => 'form-label']) }}
                                                                    {{ Form::textarea('description', $business->description, ['class' => 'form-control description-text', 'rows' => '3', 'cols' => '30', 'id' => $stringid . '_desc', 'placeholder' => __('Enter Description')]) }}
                                                                    @error('description')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
														@else
															<div class="col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('Title', __('Name'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('title', $business->title, ['class' => 'form-control', 'id' => $stringid . '_title', 'placeholder' => __('Enter Title'), 'readonly' => true]) }}
                                                                    @error('title')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('Designation', __('Department'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('designation', $business->designation, ['class' => 'form-control', 'id' => $stringid . '_designation', 'placeholder' => __('Enter Department'), 'readonly' => true]) }}
                                                                    @error('title')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    {{ Form::label('Sub_Title', __('Designation'), ['class' => 'form-label']) }}
                                                                    {{ Form::text('sub_title', $business->sub_title, ['class' => 'form-control', 'id' => $stringid . '_subtitle', 'placeholder' => __('Enter Designation' ), 'readonly' => true]) }}
                                                                    @error('sub_title')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
															<div class="col-12">
                                                                <div class="form-group">
                                                                    {{ Form::label('Description', __('Brief Bio'), ['class' => 'form-label']) }}
                                                                    {{ Form::textarea('description', $business->description, ['class' => 'form-control description-text', 'rows' => '3', 'cols' => '30', 'id' => $stringid . '_desc', 'placeholder' => __('Enter Description'),'readonly' => true]) }}
                                                                    @error('description')
                                                                        <span class="invalid-favicon text-xs text-danger"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
														@endif
                                                            
                                                        </div>
                                                    {{-- </form> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <h5 class="mb-3">{{__('Custom link')}}</h5>
                                                </div>
                                                <div class="col-lg-12">
													@if ($users->type == 'company')
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" readonly
                                                                value=" {{ $business_url }}"
                                                                placeholder="https://firstbank.com/john-doe">
                                                            {{ Form::text('slug', $business->slug, ['class' => 'input-group-text text-start', 'placeholder' => __('Enter Slug')]) }}
                                                        </div>
														
                                                    </div>
													@else
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" readonly
                                                                value=" {{ $business_url }}"
                                                                placeholder="https://firstbank.com/john-doe">
                                                            {{ Form::text('slug', $business->slug, ['class' => 'input-group-text text-start d-none', 'placeholder' => __('Enter Custom Link'),'readonly']) }}
														
                                                    </div>
													@endif
                                                </div>
                                            </div>
											@if ($users->type == 'company')
											
											<div class="form-group" >
                                                            <label class="form-label mb-3" style="font-size: 16px">{{__('Secret Code')}}</label>
                                                            <div class="row gy-2">
                                                                <div class="col-xl-9 col-lg-9 col-md-9">
                                                                    <input type="text" name = "reset_code" class="form-control d-inline-block" id="myCode"
                                                                        value="{{ $business->secret_code }}" readonly/>
																	
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-3">
                                                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="tooltip" data-bs-placement="bottom"   data-bs-original-title="{{__('Reset Code')}}" title="{{__('Reset Code')}}" onclick="dealCode()" style="padding: 0.5rem;"><i
                                                                        class="fa fa-key" style="font-size: 12px;padding-right: 5px"></i>Reset Code</button>
                                                                </div>
                                                            </div>
                                            </div> 
											@endif
											
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="mb-3">{{__('Settings')}}</h5>
                                                </div>
                                                <div class="col-12">
                                                    <div class="accordion accordion-flush setting-accordion"
                                                        id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    <span class="d-flex align-items-center">
                                                                        {{__('Contact Info')}} 
                                                                    </span>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="me-2">{{__('On/Off:')}}</span>
                                                                        <div
                                                                            class="form-check form-switch custom-switch-v1">
                                                                            <input type="hidden"
                                                                                name="is_contacts_enabled"
                                                                                value="off">
                                                                            <input type="checkbox"
                                                                                class="form-check-input input-primary"
                                                                                name="is_contacts_enabled"
                                                                                id="is_contacts_enabled"
                                                                                {{ isset($contactinfo['is_enabled']) && $contactinfo['is_enabled'] == '1' ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="is_contacts_enabled"></label>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                                aria-labelledby="headingOne"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="row" >
                                                                        <div id="showContact">
                                                                            <div class="col-12" >
                                                                                <div class="row gy-4" id="inputrow_contact">
                                                                                    @if (!is_null($contactinfo_content))
                                                                                    @foreach ($contactinfo_content as $key => $val)
                                                                                        @foreach ($val as $key1 => $val1)
																						
                                                                                            @if ($key1 != 'id')
                                                                                                <div class="col-lg-4" id="inputFormRow">
                                                                                                    <div class="input-edits inputFormRow mb-4">

                                                                                                        @if ($key1 == 'Address')
                                                                                                            @foreach ($val1 as $key2 => $val2)
                                                                                                                <div
                                                                                                                    class="input-group">
                                                                                                                    <span
                                                                                                                        class="input-group-text"><img
                                                                                                                            src="{{ asset('custom/icon/black/' . strtolower($key1) . '.svg') }}"></span>
                                                                                                                    <input
                                                                                                                        type="text"
                                                                                                                        @if ($key2 == 'Address') id="{{ $key1 . '_' . $no }}" @endif
                                                                                                                        name="{{ 'contact[' . $no . '][' . $key1 . '][' . $key2 . ']' }}"
                                                                                                                        value="{{ $val2 }}"
                                                                                                                        class="form-control"
                                                                                                                        placeholder="Username"
                                                                                                                        required>
                                                                                                                </div>
                                                                                                            @endforeach
                                                                                                            <input
                                                                                                                type="hidden"
                                                                                                                name="{{ 'contact[' . $no . '][id]' }}"
                                                                                                                value="{{ $no }}">
                                                                                                        @elseif($key1 == 'Phone')
                                                                                                            <div
                                                                                                                class="input-group">
                                                                                                                <span
                                                                                                                    class="input-group-text"><img
                                                                                                                        src="{{ asset('custom/icon/black/' . strtolower($key1) . '.svg') }}"></span>
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    id="{{ $key1 . '_' . $no }}"
                                                                                                                    name="{{ 'contact[' . $no . '][' . $key1 . ']' }}"
                                                                                                                    value="{{ $val1 }}"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="Mobile">
                                                                                                            </div>
                                                                                                            <input
                                                                                                                type="hidden"
                                                                                                                name="{{ 'contact[' . $no . '][id]' }}"
                                                                                                                value="{{ $no }}">
                                                                                                        @elseif($key1 == 'Whatsapp')
                                                                                                            <div
                                                                                                                class="input-group">
                                                                                                                <span
                                                                                                                    class="input-group-text"><img
                                                                                                                        src="{{ asset('custom/icon/black/' . strtolower($key1) . '.svg') }}"></span>
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    id="{{ $key1 . '_' . $no }}"
                                                                                                                    name="{{ 'contact[' . $no . '][' . $key1 . ']' }}"
                                                                                                                    value="{{ $val1 }}"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="Whatsapp">
                                                                                                            </div>
                                                                                                            <input
                                                                                                                type="hidden"
                                                                                                                name="{{ 'contact[' . $no . '][id]' }}"
                                                                                                                value="{{ $no }}">
                                                                                                        @else
                                                                                                            <div
                                                                                                                class="input-group">
                                                                                                                <span
                                                                                                                    class="input-group-text"><img
                                                                                                                        src="{{ asset('custom/icon/black/' . strtolower($key1) . '.svg') }}"></span>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    id="{{ $key1 . '_' . $no }}"
                                                                                                                    name="{{ 'contact[' . $no . '][' . $key1 . ']' }}"
                                                                                                                    value="{{ $val1 }}"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="Username">
                                                                                                            </div>
                                                                                                            <input
                                                                                                                type="hidden"
                                                                                                                name="{{ 'contact[' . $no . '][id]' }}"
                                                                                                                value="{{ $no }}">
                                                                                                        @endif

                                                                                                        <a href="javascript:void(0);"
                                                                                                            class="close-btn"
                                                                                                            id="removeRow_contact"
                                                                                                            data-id="contact_{{ $loop->parent->index + 1 }}"><svg
                                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                                width="25"
                                                                                                                height="25"
                                                                                                                viewBox="0 0 25 25"
                                                                                                                fill="none">
                                                                                                                <path
                                                                                                                    opacity="0.4"
                                                                                                                    d="M12.2539 22.6094C17.7768 22.6094 22.2539 18.1322 22.2539 12.6094C22.2539 7.08653 17.7768 2.60938 12.2539 2.60938C6.73106 2.60938 2.25391 7.08653 2.25391 12.6094C2.25391 18.1322 6.73106 22.6094 12.2539 22.6094Z"
                                                                                                                    fill="#FF0F00" />
                                                                                                                <path
                                                                                                                    d="M13.3149 12.6092L15.7849 10.1392C16.0779 9.84618 16.0779 9.37115 15.7849 9.07815C15.4919 8.78515 15.0169 8.78515 14.7239 9.07815L12.2539 11.5482L9.78393 9.07815C9.49093 8.78515 9.01592 8.78515 8.72292 9.07815C8.42992 9.37115 8.42992 9.84618 8.72292 10.1392L11.1929 12.6092L8.72292 15.0791C8.42992 15.3721 8.42992 15.8472 8.72292 16.1402C8.86892 16.2862 9.06092 16.3601 9.25292 16.3601C9.44492 16.3601 9.63692 16.2872 9.78292 16.1402L12.2529 13.6701L14.7229 16.1402C14.8689 16.2862 15.0609 16.3601 15.2529 16.3601C15.4449 16.3601 15.6369 16.2872 15.7829 16.1402C16.0759 15.8472 16.0759 15.3721 15.7829 15.0791L13.3149 12.6092Z"
                                                                                                                    fill="#FF0F00" />
                                                                                                            </svg>
                                                                                                        </a>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                            @php
                                                                                                $no++;
                                                                                            @endphp
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                @endif
                                                                                </div>
                                                                            
                                                                            </div>
                                                                            <div class="col-12 mt-3">
                                                                                <a href="javascript:void(0);"
                                                                                    value="sdfcvgbnn"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#fieldModal"
                                                                                    data-bs-whatever="{{ __('Choose contact field') }}"
                                                                                    data-bs-toggle="tooltip"
                                                                                    class="add-new-app flex-row">
                                                                                    <div
                                                                                        class="bg-secondary proj-add-icon">
                                                                                        <i class="ti ti-plus"></i>
                                                                                    </div>
                                                                                    <h6 class="mb-0 ms-2">{{__('Add new contact method')}}</h6>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="fieldModal" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            {{ __('Add Field') }}</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div class="row">
                                                                            @foreach ($businessfields as $val)
                                                                                <div class="col-lg-4 col-md-6">
                                                                                    <div class="card shadow getvalue"
                                                                                        value="{{ $val }}"
                                                                                        id="{{ $val }}"
                                                                                        data-id="{{ $val }}"
                                                                                        onclick="getValue(this.id)">
                                                                                        <div class="card-body p-3">
                                                                                            <div
                                                                                                class="d-flex align-items-center justify-content-between">
                                                                                                <div
                                                                                                    class="d-flex align-items-center">
                                                                                                    <div
                                                                                                        class="theme-avtar bg-primary">
                                                                                                        <img src="{{ asset('custom/icon/white/' . $val . '.svg') }}"
                                                                                                            alt="image"
                                                                                                            class="{{ $val }}">
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="ms-3">
                                                                                                        @if ($val == 'Web_url')
                                                                                                            <h5>
                                                                                                                {{ __('Web Url') }}
                                                                                                            </h5>
                                                                                                        @else
                                                                                                            <h5>
                                                                                                                {{ $val }}
                                                                                                            </h5>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

														<div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingThreea">
                                                                <button class="accordion-button collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseThreea"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseThreea">
                                                                    <span
                                                                        class="d-flex align-items-center">{{__('Lead Generation')}}</span>
                                                                    <div class="d-flex align-items-center"
                                                                        data-value="{{ json_encode($leadGeneration_content) }}">
                                                                        <span class="me-2">{{__('On/Off:')}}</span>
                                                                        <div
                                                                            class="form-check form-switch custom-switch-v1">
                                                                            <input type="hidden"
                                                                                name="is_leadgeneration_enabled"
                                                                                value="off">
                                                                            <input type="checkbox"
                                                                                name="is_leadgeneration_enabled"
                                                                                class="form-check-input input-primary"
                                                                                id="is_leadgeneration_enabled"
                                                                                {{ isset($leadGeneration['is_enabled']) && $leadGeneration['is_enabled'] == '1' ? 'checked="checked"' : '' }}>

                                                                            <label class="form-check-label"
                                                                                for="is_leadgeneration_enabled"></label>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="collapseThreea"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="headingTwo"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="bussiness-hours" id="showLeadGeneration">
                                                                        <div class="row align-items-center gy-4">
                                                                            <div class="col-lg-12">
                                                                                <div class="bussiness-hours-header">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-5">
                                                                                            <span>{{__('Lead Title')}}</span>
                                                                                        </div>
                                                                                        <div class="col-lg-5">
                                                                                            <span>{{__('Button Title')}}</span>
                                                                                        </div>
                                                                                        <div class="col-lg-2">
                                                                                            <span>{{__('Delete')}}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="inputrow_leadgeneration">
																			
                                                                                @if (!is_null($leadGeneration_content))
                                                                                    @foreach ($leadGeneration_content as $k => $leadtitle)
																					
																				
                                                                                        <div class="row mb-4 inputFormRow5"
                                                                                            id="inputFormRow5">
                                                                                            <div class="col-lg-5">
                                                                                                <div
                                                                                                    class="form-group mb-0">
                                                                                                    <input
                                                                                                        type="text"
                                                                                                        name="{{ 'leadtitle[' . $leadgeneration_no . '][title]' }}"
                                                                                                        class="form-control "
                                                                                                        id="leadgeneration_title_{{ $leadgeneration_no }}"
                                                                                                        placeholder="FirstBank Expo"
                                                                                                        value="{{ $leadtitle->title }}"
                                                                                                        />
                                                                                                </div>
                                                                                            </div>
																							
																							<div class="col-lg-5">
                                                                                                <div
                                                                                                    class="form-group mb-0">
                                                                                                    <input
                                                                                                        type="text"
                                                                                                        name="{{ 'leadtitle[' . $leadgeneration_no . '][btitle]' }}"
                                                                                                        class="form-control appointment_time "
                                                                                                        id="leadgeneration_btitle_{{ $leadgeneration_no }}"
                                                                                                        placeholder="Button Title"
                                                                                                        value="{{ $leadtitle->btitle }}"
                                                                                                        onchange="changeTime(this.id)">

                                                                                                </div>
                                                                                            </div>
																							
																							<div class="col-lg-5 d-none">
                                                                                                <div
                                                                                                    class="form-group mb-0 ">
                                                                                                    <input
                                                                                                        type="text"
                                                                                                        name="{{ 'leadtitle[' . $leadgeneration_no . '][created_at]' }}"
                                                                                                        class="form-control appointment_time "
                                                                                                        id="leadgeneration_created_at_{{ $leadgeneration_no }}"
                                                                                                        placeholder="Created_at"
                                                                                                        value="{{ $leadtitle->created_at }}"
                                                                                                        onchange="changeTime(this.id)">

                                                                                                </div>
                                                                                            </div>
																							
                                                                                            
                                                                                            <div class="col-lg-2">
                                                                                                <a href="javascript:void(0);"
                                                                                                    class="close-btn"
                                                                                                    id="removeRow_leadgeneration"
                                                                                                    data-id="{{ 'leadgeneration_' . $leadgeneration_no }}"><svg
                                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="25"
                                                                                                        height="25"
                                                                                                        viewBox="0 0 25 25"
                                                                                                        fill="none">
                                                                                                        <path
                                                                                                            opacity="0.4"
                                                                                                            d="M12.2539 22.6094C17.7768 22.6094 22.2539 18.1322 22.2539 12.6094C22.2539 7.08653 17.7768 2.60938 12.2539 2.60938C6.73106 2.60938 2.25391 7.08653 2.25391 12.6094C2.25391 18.1322 6.73106 22.6094 12.2539 22.6094Z"
                                                                                                            fill="#FF0F00">
                                                                                                        </path>
                                                                                                        <path
                                                                                                            d="M13.3149 12.6092L15.7849 10.1392C16.0779 9.84618 16.0779 9.37115 15.7849 9.07815C15.4919 8.78515 15.0169 8.78515 14.7239 9.07815L12.2539 11.5482L9.78393 9.07815C9.49093 8.78515 9.01592 8.78515 8.72292 9.07815C8.42992 9.37115 8.42992 9.84618 8.72292 10.1392L11.1929 12.6092L8.72292 15.0791C8.42992 15.3721 8.42992 15.8472 8.72292 16.1402C8.86892 16.2862 9.06092 16.3601 9.25292 16.3601C9.44492 16.3601 9.63692 16.2872 9.78292 16.1402L12.2529 13.6701L14.7229 16.1402C14.8689 16.2862 15.0609 16.3601 15.2529 16.3601C15.4449 16.3601 15.6369 16.2872 15.7829 16.1402C16.0759 15.8472 16.0759 15.3721 15.7829 15.0791L13.3149 12.6092Z"
                                                                                                            fill="#FF0F00">
                                                                                                        </path>
                                                                                                    </svg>
                                                                                                </a>
                                                                                                    
                                                                                            </div>
                                                                                        </div>

                                                                                        @php
                                                                                            $leadgeneration_no++;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-12">
                                                                                
                                                                                <a href="javascript:void(0)" class="add-new-app flex-row" onclick="leadgenerationRepeater()">
                                                                                    <div class="bg-secondary proj-add-icon">
                                                                                        <i class="ti ti-plus"></i>
                                                                                    </div>
                                                                                    <h6 class="mb-0 ms-2">{{__('Add New Lead Generation')}}</h6>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
														
                                                        
                                                        
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingSix">
                                                                <button class="accordion-button collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseSix"
                                                                    aria-expanded="false" aria-controls="collapseSix">
                                                                    <span class="d-flex align-items-center">{{__('Social Media Icons')}}</span>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="me-2">{{__('On/Off:')}}</span>
                                                                        <div
                                                                            class="form-check form-switch custom-switch-v1">
                                                                            <input type="hidden" name="is_socials_enabled"
                                                            value="off">
                                                                            <input type="checkbox"
                                                                                class="form-check-input input-primary"
                                                                                id="is_socials_enabled" name="is_socials_enabled" 
                                                                                {{ isset($sociallinks['is_enabled']) && $sociallinks['is_enabled'] == '1' ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="is_socials_enabled"></label>
                                                                        </div>
                                                                    </div>
                                                                </button>       
                                                            </h2>
                                                            <div id="collapseSix" class="accordion-collapse collapse"
                                                                aria-labelledby="headingSix"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="row">
                                                                        <div id="showSocials">
                                                                                {{-- start --}}
                                                                            <div class="col-12" >
                                                                                <div class="row gy-4" id="inputrow_socials">
                                                                                    @if (!is_null($social_content))
                                                                                        @foreach ($social_content as $social_key => $social_val)
                                                                                            @foreach ($social_val as $social_key1 => $social_val1)
                                                                                                @if ($social_key1 != 'id')
                                                                                                <div class="col-lg-4" id="inputFormRow4">
                                                                                                    <div class="input-edits" >
                                                                                                        <div class="input-group">
                                                                                                            <span class="input-group-text"><img
                                                                                                                    src="{{ asset('custom/icon/black/' . strtolower($social_key1) . '.svg') }}"></span>
                                                                                                            <input type="text"
                                                                                                                name="{{ 'socials[' . $social_no . '][' . $social_key1 . ']' }}"
                                                                                                                value="{{ $social_val1 }}"
                                                                                                                id="{{ 'social_link_' . $social_no }}"
                                                                                                                class="form-control social_href"
                                                                                                                placeholder="Enter page link" required/>
                                                                                                                <input type="hidden" name="{{ 'socials[' . $social_no . '][id]' }}" value="{{ $social_no }}">
                                                                                                        </div>
                                                                                                        <h6 class="text-danger mt-2 text-xs"  id="{{ 'social_link_' . $social_no . '_error_href' }}"></h6>
                                                                                                        <a href="javascript:void(0)"
                                                                                                            class="close-btn" id="removeRow_socials" data-id="socials_{{ $loop->parent->index + 1 }}"><svg
                                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                                width="25" height="25"
                                                                                                                viewBox="0 0 25 25"
                                                                                                                fill="none">
                                                                                                                <path opacity="0.4"
                                                                                                                    d="M12.2539 22.6094C17.7768 22.6094 22.2539 18.1322 22.2539 12.6094C22.2539 7.08653 17.7768 2.60938 12.2539 2.60938C6.73106 2.60938 2.25391 7.08653 2.25391 12.6094C2.25391 18.1322 6.73106 22.6094 12.2539 22.6094Z"
                                                                                                                    fill="#FF0F00"></path>
                                                                                                                <path
                                                                                                                    d="M13.3149 12.6092L15.7849 10.1392C16.0779 9.84618 16.0779 9.37115 15.7849 9.07815C15.4919 8.78515 15.0169 8.78515 14.7239 9.07815L12.2539 11.5482L9.78393 9.07815C9.49093 8.78515 9.01592 8.78515 8.72292 9.07815C8.42992 9.37115 8.42992 9.84618 8.72292 10.1392L11.1929 12.6092L8.72292 15.0791C8.42992 15.3721 8.42992 15.8472 8.72292 16.1402C8.86892 16.2862 9.06092 16.3601 9.25292 16.3601C9.44492 16.3601 9.63692 16.2872 9.78292 16.1402L12.2529 13.6701L14.7229 16.1402C14.8689 16.2862 15.0609 16.3601 15.2529 16.3601C15.4449 16.3601 15.6369 16.2872 15.7829 16.1402C16.0759 15.8472 16.0759 15.3721 15.7829 15.0791L13.3149 12.6092Z"
                                                                                                                    fill="#FF0F00"></path>
                                                                                                            </svg></a>
                                                                                                    </div>
                                                                                                </div>
                                                                                                @endif
                                                                                                @php
                                                                                                    $social_no++;
                                                                                                @endphp
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-auto flex-grow-1 mt-3">
                                                                                <a href="javascript:void(0)"
                                                                                    class="add-new-app flex-row" value="sdfcvgbnn" data-bs-toggle="modal" data-bs-target="#socialsModal">
                                                                                    <div
                                                                                        class="bg-secondary proj-add-icon">
                                                                                        <i class="ti ti-plus"></i>
                                                                                    </div>
                                                                                    <h6 class="mb-0 ms-2">{{__('Add New Social Links')}}</h6>
                                                                                </a>
                                                                            </div>
                                                                        {{-- end --}}
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary"> <i class="me-2"
                                                    data-feather="credit-card"></i> {{__('Update Card')}}
                                            </button>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 d-none">
                                    <div id="sticky" class="theme-preview large-preview preview-height">
                                        
                                        <div  class="theme-preview-body ">
                                            <div class="mb-3">
                                                <h5>{{__('Preview')}}</h5>
                                            </div>
                                            @include('card.' . $card_theme->theme . '.index')
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							@if ($users->type != 'company')
							<div style="margin-top: 50px">
                            <div class="row gy-4">
                                <div class="col-lg-7 col-md-7">
                                    {{ Form::open(['route' => ['business.qrcode_setting', $business->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                        <div class="theme-detail-card" style="box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3); background: #ffffff">
                                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0 flex-grow-1">{{__('Qr Code Settings:')}}</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{ Form::label('Forground Color', __('Foreground Color'), ['class' => 'form-label']) }}
                                                        <input type="color" name="foreground_color" value="{{isset($qr_detail->foreground_color)? $qr_detail->foreground_color :'#000000'}}" class="form-control foreground_color qr_data" data-multiple-caption="{count} files selected" multiple="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{ Form::label('Background Color', __('Background Color'), ['class' => 'form-label']) }}
                                                        <input type="color" name="background_color"  value="{{isset($qr_detail->background_color)?$qr_detail->background_color:'#ffffff'}}" class="form-control background_color qr_data" data-multiple-caption="{count} files selected" multiple="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{ Form::label('Corner Radius', __('Corner Radius'), ['class' => 'form-label']) }}
                                                        <input type="range" name="radius" class="radius qr_data" min="1" max="50" step="1" style="width:100%;" value="{{isset($qr_detail->radius)?$qr_detail->radius:26}}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row gy-2 gx-2 my-3 gallery-btn"  > 
                                                   
                                                        @foreach ($qr_code as $k => $value)
                                                        <div class="col-auto " id="">
                                                                <label for="enable_{{$k}}" class="btn btn-secondary qr_type">
                                                                <input type="radio"  class="d-none btn btn-secondary qr_type_click" @if(isset($qr_detail->qr_type) && ($qr_detail->qr_type==$k)) checked  @endif 
                                                                    name="qr_type" value="{{$k}}" id="{{$k}}"/><i class="me-2" data-feather="folder"></i>
                                                                {{ __($value) }}
                                                                </label>    
                                                        </div>  
                                                        @endforeach
                                                    </div>
                                               </div>
                                                <span id="qr_type_option" style="{{ $qr_detail == null ? 'display: none' : 'display: block' }}">
                                                    <div id="text_div">
                                                        <div class="col-md-12 mt-2 " >
                                                            <div class="form-group">
                                                                {{ Form::label('Text', __('Text'), ['class' => 'form-label']) }}
                                                                <input type="text" name="qr_text" maxlength="10" value="{{isset($qr_detail->qr_text)?$qr_detail->qr_text:''}}" class="form-control qr_text qr_keyup">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                {{ Form::label('Text Color', __('Text Color'), ['class' => 'form-label']) }}
                                                                <input type="color" name="qr_text_color" value="{{isset($qr_detail->qr_text_color)?$qr_detail->qr_text_color:'#f50a0a'}}" class="form-control qr_text_color qr_data">
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-md-12 mt-2" id="image_div">
                                                        <div class="form-group">
                                                            {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
        
                                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" class="form-control qr_image qr_data">
                                                            <input type="hidden" name="old_image" value="">
                                                        
                                                            <img id="image-buffer" src="{{ isset($qr_detail->image) ? $qr_path.'/' . $qr_detail->image :''}}" class="d-none">
        
                                                        </div>
                                                    </div>
        
                                                    <div class="col-md-12" id="size_div">
                                                        <div class="form-group">
                                                            {{ Form::label('Size', __('Size'), ['class' => 'form-label']) }}
                                                            <input type="range" name="size" class="qr_size qr_data"  value="{{isset($qr_detail->size)?$qr_detail->size:9}}" min="1" max="50" step="1" style="width:100%;">
                                                        </div>
                                                    </div>
        
                                                </span>
        
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-3 ">
                                                <h5 class="mb-0"></h5>
                                                <button type="submit" class="btn btn-primary"> <i
                                                        data-feather="grid"></i>&nbsp;{{__('Update QR Code')}} </button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="theme-preview" style="box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3); background: #ffffff">
                                        <div class=" code" >    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
							
                            <div class="row gy-4" style="margin-top:50px">
                                <div class="col-lg-10 col-md-10">
                                    {{ Form::open(['route' => ['business.edit-theme', $business->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                    <div class="select-theme-portion" style="box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3); background: #ffffff;">
                                        <div class="d-flex align-items-center justify-content-between mb-4 ">
                                            <h5 class="mb-0">{{__('Select Theme:')}}</h5>
                                            
                                        </div>
                                       
                                        <div class="theme-slider">
                                            
                                            @foreach (\App\Models\Utility::themeOne() as $key => $v)
                                                {{-- @if (in_array($key, Auth::user()->getPlanThemes())) --}}
                                                <div class="theme-view-card">
                                                    <div class="theme-view-inner">
                                                        <div class="theme-view-img ">
                                                            <img class="color1 {{ $key }}_img"
                                                                data-id="{{ $key }}"
                                                                src="{{ asset(Storage::url('uploads/card_theme/' . $key . '/color1.png')) }}"
                                                                alt="">
                                                        </div>
                                                        <div class="theme-view-content mt-3">
                                                            <h6>{{__('Modern Theme')}}</h6>
                                                            {{-- <span class="mb-1">{{__('Select Sub-Color:')}}</span> --}}
                                                            <div class="d-flex align-items-center" id="{{ $key }}">
                                                                @foreach ($v as $css => $val)
                                                                    <label class="colorinput">
                                                                        <input name="theme_color"
                                                                            id="{{ $css }}"
                                                                            type="radio" value="{{ $css }}"
                                                                            data-theme="{{ $key }}"
                                                                            data-imgpath="{{ $val['img_path'] }}"
                                                                            class="colorinput-input"
                                                                            {{ isset($business->theme_color) && $business->theme_color == $css ? 'checked' : '' }}>
                                                                        <span class="border-box">
                                                                            <span class="colorinput-color"
                                                                                style="background:{{ $val['color'] }}"></span>
                                                                        </span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @endif --}}
                                            @endforeach
                                            
                                        </div>
										<div class="d-flex align-items-center justify-content-between mb-4 ">
                                            <h5 class="mb-0">{{__('')}}</h5>
                                            {{ Form::hidden('themefile', null, ['id' => 'themefile']) }}
                                            <button type="submit" class="btn btn-primary"> <i class="me-2"
                                                    data-feather="folder"></i> {{__('Save Theme')}}</button>
                                        </div>
                                       
                                    </div>
                                    {{ Form::close() }}
                                </div>
                                <div class="col-lg-4 col-md-5 d-none">
                                    <div class="theme-preview theme-preview-1">
                                        <div class="mb-3">
                                            <h5>{{__('Preview')}}</h5>
                                        </div>
                                        <div class="theme-preview-body">
                                            <img src="{{ asset(Storage::url('uploads/card_theme/theme1/color1.png')) }}"
                                                class="theme_preview_img">
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
                         {{-- End Custom QR-Code  --}}
							<div  style="margin-top: 50px">
                            <div class="row gy-4">
                                {{ Form::open(['route' => ['business.block-setting', $business->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                <div <div class="col-lg-10 col-md-10">
                                    <div class="theme-detail-card" style="box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3); background: #ffffff;">
                                            <div class="d-flex align-items-center justify-content-between mb-4 ">
                                                    <h5 class="mb-0">{{__('Re-Order Links')}}</h5>
                                                    
                                                </div>
                                        
                                        <ul class="list-unstyled list-group sortable">
                                            <input type="hidden" name="theme_name"
                                                value="{{ $card_theme->theme }}">
                                            <input type="hidden" name="order" value=""
                                                id="hidden_order">

                                            @for ($i = 1; $i <= 11; $i++)
                                                @foreach ($card_theme->order as $order_key => $order_value)
                                                    @if ($i == $order_value)
                                                        
                                                    <li class="list-group-item d-flex align-items-center justify-content-between {{ $card_theme->theme == 'theme5' && $order_key == 'social' ? 'd-none' : '' }}{{ $card_theme->theme == 'theme6' && $order_key == 'social' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme2' && $order_key == 'description' ? 'd-none' : '' }}{{ $card_theme->theme == 'theme3' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme4' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme5' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme6' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme7' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme8' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme9' && $order_key == 'description' ? 'd-none' : '' }} {{ $card_theme->theme == 'theme10' && $order_key == 'description' ? 'd-none' : '' }}{{ $card_theme->theme == 'theme11' && $order_key == 'description' ? 'd-none' : '' }}{{ $card_theme->theme == 'theme9' && $order_key == 'contact_info' ? 'd-none' : '' }}{{ $card_theme->theme == 'theme4' && $order_key == 'gallery' ? 'd-none' : '' }}{{ $card_theme->theme == 'theme11' && $order_key == 'contact_info' ? 'd-none' : '' }}"
                                                            data-id="{{ $order_key }}">
                                                            @if ($order_key == 'scan_me')
                                                                <h6 class="mb-0">
                                                                    <i class="me-3" data-feather="move"></i>
                                                                    <span>{{__('Scan Me')}}</span>
                                                                </h6>
                                                            @elseif($order_key == 'contact_info')
                                                                <h6 class="mb-0">
                                                                    <i class="me-3" data-feather="move"></i>
                                                                    <span>{{__('Contact Info')}}</span>
                                                                </h6>
                                                            @elseif($order_key == 'bussiness_hour')
                                                                <h6 class="mb-0">
                                                                    <i class="me-3" data-feather="move"></i>
                                                                    <span>{{__('Bussiness Hour')}}</span>
                                                                </h6>
															@elseif($order_key == 'leadgeneration')
                                                                <h6 class="mb-0">
                                                                    <i class="me-3" data-feather="move"></i>
                                                                    <span>{{__('Lead Generation')}}</span>
                                                                </h6>
                                                            @elseif($order_key == 'custom_html')
                                                                    <h6 class="mb-0">
                                                                    <i class="me-3" data-feather="move"></i>
                                                                    <span>{{__('Custom HTML')}}</span>
                                                                </h6>
                                                            @else
                                                                <h6 class="mb-0">
                                                                    <i class="me-3" data-feather="move"></i>
                                                                        <span>{{__(ucfirst($order_key))}}</span>
                                                                </h6>
                                                            @endif
                                                            <div class="d-flex align-items-center {{ $card_theme->theme == 'theme5' && $order_key == 'social' ? 'd-none' : '' }}">
                                                                @if ($order_key != 'description' && $order_key != 'more' && $order_key != 'scan_me')
                                                                    <span class="me-2">{{__('On/Off:')}}</span>
                                                                    <div class="form-check form-switch custom-switch-v1">
                                                                        <input type="hidden"
                                                                            name="is_{{ $order_key }}_enabled"
                                                                            value="off">
                                                                            
                                                                        <input type="checkbox"
                                                                            name="is_{{ $order_key }}_enabled"
                                                                            class="form-check-input input-primary"
                                                                            id="is_{{ $order_key }}{{ $order_key == 'custom_html' ? '11' : '' }}_enabled" 
                                                                            {{ \App\Models\Utility::isEnableBlock($order_key, $business->id) == '1' ? 'checked="checked"' : '' }}/>
                                                                        <label class="form-check-label"
                                                                            for="is_{{ $order_key }}{{ $order_key == 'custom_html' ? '11' : '' }}_enabled"></label>
                                                                    </div>
                                                                @else
                                                                    <span>{{__('This is required')}}</span>
                                                                @endif
                                                            </div>

                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endfor
                                        </ul>
										
										<div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary"> <i class="me-2"
                                                    data-feather="link-2" id="btnSubmit"></i> &nbsp;{{__('Update Links')}}
                                            </button>
                                        </div>
										

                                        <p class="mt-3"><b>{{__('')}}</b></p>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        
                        </div>
						<div  style="margin-top: 50px">
						<div class="row gy-4">
                                 <div class="col-lg-10 col-md-10">
                                    <div class="theme-detail-card" style="box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3); background: #ffffff;">
                                        {{ Form::open(['route' => ['business.seo-setting', $business->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                        <div class="d-flex align-items-center justify-content-between mb-4 ">
                                            <h5 class="mb-0">{{__('Thumbnail')}}</h5>
                                            
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            {{ Form::label('meta_keyword', __('Meta Keywords'), ['class' => 'form-label']) }}
                                                            {{ Form::text('meta_keyword', $business->meta_keyword, ['class' => 'form-control', 'rows' => '3', 'placeholder' => __('Enter Meta Keywords')]) }}
                                                        </div>
                                                        @error('metakeywords')
                                                            <span class="invalid-favicon text-xs text-danger"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            {{ Form::label('meta_description', __('Meta Description'), ['class' => 'form-label']) }}
                                                            {{ Form::textarea('meta_description', $business->meta_description, ['class' => 'form-control', 'rows' => '3', 'cols' => '30', 'placeholder' => __('Enter Meta Description')]) }}
                                                        </div>
                                                        @error('meta_description')
                                                            <span class="invalid-favicon text-xs text-danger"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    {{-- Meta Image --}}
                                                    <div class="col-12 form-group">
                                                        {{ Form::label('meta_image', __('Meta Image'), ['class' => 'form-label']) }}
                                                        <div class="setting-block ">
                                                            <div class="position-relative overflow-hidden rounded">
                                                                <a href="{{ (isset($business->meta_image) && !empty($business->meta_image) ? $business->meta_image : asset('custom/img/placeholder-image1.jpg'))   }}"
                                                                target="_blank">
                                                                    <img id="blah" alt="your image"
                                                                    src="{{ isset($business->meta_image) && !empty($business->meta_image) ? $meta_image . '/' . $business->meta_image : asset('custom/img/placeholder-image1.jpg') }}"
                                                                        class="meta_images">
                                                                </a>
                                                                <div
                                                                    class="position-absolute top-50  end-0 start-0 text-center">
                                                                    <div class="choose-file">
                                                                        <label for="meta_image">
                                                                            <div class="btn btn-md bg-primary company_logo_update" style="color: white;"> <i
                                                                                class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                                                </div>
                                                                                <input type="file" class="form-control file" name="meta_image"
                                                                                id="meta_image" data-filename="meta_image"
                                                                                onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                                        </label>
                                                                    </div>
                                                                    @error('meta_image')
                                                                    <span class="invalid-company_logo text-xs text-danger"
                                                                        role="alert">{{ $message }}</span>
                                                                @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End Meta Image --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('google_analytic', __('Google Analytics'), ['class' => 'form-label']) }}
                                                        {{ Form::text('google_analytic', $business->google_analytic, ['class' => 'form-control', 'placeholder' => 'UA-XXXXXXXXX-X']) }}
                                                    </div>
                                                    @error('google_analytic')
                                                        <span class="invalid-google_analytic" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('facebook_pixel_code', __('Facebook Pixel'), ['class' => 'form-label']) }}
                                                        {{ Form::text('fbpixel_code', $business->fbpixel_code, ['class' => 'form-control', 'placeholder' => 'UA-0000000-0']) }}
                                                    </div>
                                                    @error('facebook_pixel_code')
                                                        <span class="invalid-google_analytic" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                       
										<div class="d-flex align-items-center justify-content-between mb-4 ">
                                            <h5 class="mb-0">{{__('')}}</h5>
                                            <button type="submit" class="btn btn-primary"> <i
                                                    data-feather="folder"></i>&nbsp;{{__('Save Thumbail')}} </button>
                                        </div>
                                         {{ Form::close() }}
                                    </div>
                                </div>
								@endif
							</div>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
    

    <div class="modal fade" id="socialsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Field') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($businessfields as $val)
                            @if ($val != 'Email' && $val != 'Phone')
                                <div class="col-lg-4 col-md-6">
                                    <div class="card shadow getvalue" value="{{ $val }}"
                                        id="{{ $val }}" data-id="{{ $val }}"
                                        onclick="socialRepeater(this.id)">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="theme-avtar bg-primary">

                                                        <img src="{{ asset('custom/icon/white/' . $val . '.svg') }}"
                                                            alt="image" class="{{ $val }}">
                                                    </div>
                                                    <div class="ms-3">
                                                        @if ($val == 'Web_url')
                                                            <h5>{{ __('Web Url') }}</h6>
                                                            @else
                                                                <h5>{{ $val }}</h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div id="addnewfield">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="qrcodeModal" data-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('QR Code') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="qrdata">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('custom/libs/dropzonejs/min/dropzone.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/repeaterInput.js') }}"></script>
    <script src="{{ asset('js/bootstrap-toggle.js') }}"></script>
    {{-- <script src="{{ asset('custom/js/jquery.qrcode.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="https://jeromeetienne.github.io/jquery-qrcode/src/qrcode.js"></script> --}}
    <script src="{{ asset('custom/libs/jquery-ui/jquery-ui.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
   
    <script src="{{ asset('custom/theme1/js/slick.min.js') }}" defer="defer"></script>
    <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>

    <script>
        $(function() {
            $(".sortable").sortable();
            $(".sortable").disableSelection();
            $(".sortable").sortable({
                stop: function() {
                    var order = [];
                    $(this).find('li').each(function(index, data) {
                        order[index] = $(data).attr('data-id');
                    });
                    $('#hidden_order').val(order);

                }
            });
            var block_order = [];
            $(".sortable").find('li').each(function(index, data) {
                block_order[index] = $(data).attr('data-id');
            });
            $('#hidden_order').val(block_order);
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#details-setting-tab").click(function() {
                    setTimeout(function() {
                    $('.testimonial-slider').slick('refresh');
                    $('.gallery-slider').slick('refresh');
                    $('.service-slider').slick('refresh');
                }, 500);
            });  
            $("#theme-setting-tab").click(function() {
                    setTimeout(function() {
                        $('.theme-slider').slick('refresh');
                }, 200);
            });       
        });
    </script>
    <script type="text/javascript">
        var theme = '{{ $card_theme->theme }}';
        var theme_path = `{{ asset('custom/${theme}/icon/') }}`;
        var asset_path = `{{ asset('custom/icon/') }}`
        var color = `{{ $business->theme_color }}`.substring(0, 6);
        var add_row_no = {{ $no }};

        function getValue(el) {
            //alert(el);
            var data = repeaterInput(el, 'contact', add_row_no, 'inputrow_contact', theme_path, `${theme}`, color,
                asset_path);
            add_row_no = data;
        }
        var row_no = {{ $appointment_no }};

        function appointmentRepeater() {
            var data = repeaterInput('', 'appointment', row_no, 'inputrow_appointment', "", `${theme}`, color, asset_path);
            row_no = data;
			console.log(row_no);
            // $('select').niceSelect('update');

        }
		
		var leadgeneration_no = {{ $leadgeneration_no }};

        function leadgenerationRepeater() {
			
            var data = repeaterInput('', 'leadgeneration', leadgeneration_no, 'inputrow_leadgeneration', "", `${theme}`, color, asset_path);
			
            leadgeneration_no = data;
            // $('select').niceSelect('update');

        }
		
        var service_row_no = {{ $service_row_no }};

        function servieRepeater() {
            var data = repeaterInput('', 'service', service_row_no, 'inputrow_service', theme_path, `${theme}`, color,
                asset_path);
            service_row_no = data;
        }

        var testimonials_row_no = {{ $testimonials_row_no }};

        function testimonialRepeater() {
            $(".testimonial-slider").slick('destroy');
            var data = repeaterInput('', 'testimonial', testimonials_row_no, 'inputrow_testimonials',
                "{{ asset('custom/img/logo-placeholder-image-2.png') }}", `${theme}`, color, asset_path);
            @if ($SITE_RTL == 'on')
                if ($('.testimonial-slider').length > 0) {
                    $('.testimonial-slider').slick({
                        autoplay: false,
                        slidesToShow: 2,
                        speed: 1000,
                        slidesToScroll: 1,
                        rtl: true,
                        // prevArrow: '<button class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
                        // nextArrow: '<button class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
                        dots: false,
                        arrows: false,
                        buttons: false,
                        responsive: [{
                            breakpoint: 420,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }]
                    });
                }
            @else
                if ($('.testimonial-slider').length > 0) {
                    $('.testimonial-slider').slick({
                        autoplay: false,
                        slidesToShow: 2,
                        speed: 1000,
                        slidesToScroll: 1,
                        // prevArrow: '<button class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
                        // nextArrow: '<button class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
                        dots: false,
                        arrows: false,
                        buttons: false,
                        responsive: [{
                            breakpoint: 420,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }]
                    });
                }
            @endif
                  
            testimonials_row_no = data;

        }

      

        var socials_row_no = {{ $social_no }};

        function socialRepeater(el) {

            var data = repeaterInput(el, 'social_links', socials_row_no, 'inputrow_socials', theme_path, `${theme}`, color,
                asset_path);
            socials_row_no = data;
        }
       $("#is_business_hours_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {
            $('#business-hours-div').show();
            $('.business-hours-div').show();
            $('#showElement').show();
        }
        if (enable == false) {
            $('#showElement').hide();
            $('#business-hours-div').hide();
            $('.business-hours-div').hide();
        }
    }).change();

    $("#is_appoinment_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {
            $('#appointment-div').show();
            $('#showAppoinment').show();
        }
        if (enable == false) {
            $('#appointment-div').hide();
            $('#showAppoinment').hide();
        }
    }).change();
	
	
	    $("#is_leadgeneration_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {
            $('#appointment-div').show();
            $('#showLeadGeneration').show();
        }
        if (enable == false) {
            $('#appointment-div').hide();
            $('#showLeadGeneration').hide();
        }
    }).change();


    $("#is_socials_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {
            $('#social-div').show();
            $('.social-div').show();
            $('#showSocials').show();
        }
        if (enable == false) {
            $('#social-div').hide();
            $('#showSocials').hide();
        }
    }).change();

    $("#is_testimonials_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {

            $('#testimonials-div').show();
            $('.showTestimonials').show();
        }
        if (enable == false) {
            $('#testimonials-div').hide();
            $('.showTestimonials').hide();
        }
    }).change();

    $("#is_services_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {

            $('#services-div').show();
            $('.showServices').show();
        }
        if (enable == false) {
            $('#services-div').hide();
            $('.showServices').hide();
        }
    }).change();
    $("#is_contacts_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {
            $('#showContact').show();
            $('#showContact_preview').show();
            $('#contact-div').show();
            $('#contact-div1').show();
        }
        if (enable == false) {
            $('#showContact').hide();
            $('#showContact_preview').hide();
            $('#contact-div').hide();
            $('#contact-div1').hide();
        }
    }).change();
    $("#is_gallery_enabled").change(function() {
        var $input = $(this);
        var enable = $input.is(":checked");

        if (enable == true) {

            $('#gallery-div').show();
            $('.showGallery').show();
        }
        if (enable == false) {
            $('#gallery-div').hide();
            $('.showGallery').hide();
        }
    }).change();


    var count = document.querySelectorAll('.inputFormRow').length;
    if (count < 3) {
        $('.hideelement').show();
    } else {
        $('.hideelement').hide();
    }
    $(document).ready(function() {
        $('.theme-slider').slick('refresh');
    });

    $(document).ready(function(){
        @if ($SITE_RTL == 'on')
        
            if ($('.theme-slider').length > 0) {
                $('.theme-slider').slick({
                    // autoplay: true,
                    rows:2,
                    rtl: true,
                    slidesToShow: 4,
                    loop:false,
                    infinite:false,
                    speed: 1000,
                    slidesToScroll: 4,
                    prevArrow: '<div class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></div>',
                    nextArrow: '<div class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></div>',
                    dots: false,
                    arrows:true,
                    // buttons: false,
                    responsive: [
                        {
                            breakpoint: 1700,
                            settings: {
                                rows:2,
                                slidesToShow: 3,
                                slidesToScroll: 3,
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                rows:2,
                                slidesToShow: 2,
                                slidesToScroll: 2,
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                rows:2,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 430,
                            settings: {
                                rows:2,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }
                    ]
                });
            }
        @else
            if ($('.theme-slider').length > 0) {
                $('.theme-slider').slick({
                    // autoplay: true,
                    rows:2,
                    slidesToShow: 4,
                    loop:false,
                    infinite:false,
                    speed: 1000,
                    slidesToScroll: 4,
                    prevArrow: '<div class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></div>',
                    nextArrow: '<div class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></div>',
                    dots: false,
                    arrows:true,
                    // buttons: false,
                    responsive: [
                        {
                            breakpoint: 1700,
                            settings: {
                                rows:2,
                                slidesToShow: 3,
                                slidesToScroll: 3,
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                rows:2,
                                slidesToShow: 2,
                                slidesToScroll: 2,
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                rows:2,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 430,
                            settings: {
                                rows:2,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }
                    ]
                });
            }
        @endif
    });

    function changeFunction(el) {
        var data_preview_id = $(`#${el}`).data('id');
        var start_time_preview = $(`#${data_preview_id}_start`).val();
        var end_time_preview = $(`#${data_preview_id}_end`).val();
        var time_preview = start_time_preview + '-' + end_time_preview;
        //var is_closed = $(`.${data_preview_id}`).text();
        if ($(`#${data_preview_id}`).prop('checked')) {
            $(`.${data_preview_id}`).text(time_preview);
        }
        //var preview_time = $(`#${el}`).val();
        //$(`.${el}`).text(preview_time);
    }

    function getRadio(el) {
        //var classss = $(el).attr('class');
        var get_val = $(el).val();
        //alert(get_val);
        var get_class = $(el).attr('class');
        $('.' + get_class).text(get_val);
        var span_star = '';
        const arr = [
            1,
            2,
            3,
            4,
            5
        ];
        $('#' + get_class + '_star').text('')
        $.each(arr, function(index, value) {
           
            // Will stop running after "three"
            
            if (value <= get_val) {
                span_star = `<i class="star-color  fas fa-star"></i>`;
            } else {
                span_star = `<i class="fa fa-star"></i>`;
            }
            console.log(span_star);
            $('#' + get_class + '_star').append(span_star);
        });
       

    }



    function validURL(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_@.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
        return !!pattern.test(str);
    }

    $("input").keyup(function() {
        var id = $(this).attr('id');
        var preview = $(`#${id}`).val();
        $(`#${id}_preview`).text(preview);
    });

    $(".social_href").keyup(function() {
        var id = $(this).attr('id');
        var text = $(this).attr('name');
        var subtext = "Whatsapp";
        var isIncluded = text.includes(subtext);
        var preview = $(`#${id}`).val();
        var h_preview = validURL(preview);
        
        if (h_preview == true) {
            $(`#${id}_error_href`).text("");
            $(`#${id}_href_preview`).attr("href", preview);
        } else {
            if(isIncluded==false)
            {
                $(`#${id}_error_href`).text("Please enter valid link");
                $(`#${id}_href_preview`).attr("href", "#");
            }
        }

    });

    $("textarea").keyup(function() {
        var id = $(this).attr('id');
        //console.log(id);
        var preview = $(`#${id}`).val();
        $(`#${id}_preview`).text(preview);
        $(`.description-div`).show();
        if ($('.description-text').val() == "") {
            $(`.description-div`).hide();
        }
    });


    $(".days").change(function() {
        var day_id = $(this).attr('id');
        if ($(this).prop('checked')) {
            var this_attr_id = $(this).attr('id');
            var start_time = $(`#${this_attr_id}_start`).val();
            var end_time = $(`#${this_attr_id}_end`).val();
            if (start_time == '' && end_time == '') {
                //var time = start_time + '-' + end_time;
                $(`.${day_id}`).text('00:00');

            } else {
                var time = start_time + '-' + end_time;
                $(`.${day_id}`).text(time);
            }
        } else {
            $(`.${day_id}`).text('closed');

        }
    });

    function changeTime(el) {
        var time_input = $(`#${el}`).val();
        $(`#${el}_preview`).text(time_input);

        // $('select').niceSelect('update');
    }

    $(document).on('click', 'input[name="theme_color"]', function() {

        var eleParent = $(this).attr('data-theme');
        $('#themefile').val(eleParent);
        var imgpath = $(this).attr('data-imgpath');
        $('.' + eleParent + '_img').attr('src', imgpath);

        $('.theme_preview_img').attr('src', imgpath);
        setTimeout(function(e) {
            $('.theme-save').trigger('click');
        }, 200);

        $(".theme-view-card").removeClass('selected-theme')
        $(this).closest('.theme-view-card').addClass('selected-theme');
    });

    $(document).ready(function() {

        console.log($('.modal-backdrop'));
        // $('.modal-backdrop').addClass('d-none');
        setTimeout(function(e) {
            var checked = $("input[type=radio][name='theme_color']:checked");
            $('#themefile').val(checked.attr('data-theme'));
            $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
            $('.theme_preview_img').attr('src', checked.attr('data-imgpath'));

        }, 300);
    });

    $(document).on('change', '.domain_click#enable_storelink', function(e) {
       
        $('#StoreLink').show();
        $('.sundomain').hide();
        $('.domain').hide();
        $('#domainnote').hide();
        $(this).parent().removeClass('btn-secondary');
        $(this).parent().addClass('btn-primary');
        $('#enable_domain').parent().addClass('btn-secondary');
        $('#enable_domain').parent().removeClass('btn-primary');
        $('#enable_subdomain').parent().addClass('btn-secondary');
        $('#enable_subdomain').parent().removeClass('btn-primary');
    });
    $(document).on('change', '.domain_click#enable_domain', function(e) {
        $('.domain').show();
        $('#StoreLink').hide();
        $('.sundomain').hide();
        $('#domainnote').show();
        $(this).parent().removeClass('btn-secondary');
        $(this).parent().addClass('btn-primary');
        $('#enable_storelink').parent().addClass('btn-secondary');
        $('#enable_storelink').parent().removeClass('btn-primary');
        $('#enable_subdomain').parent().addClass('btn-secondary');
        $('#enable_subdomain').parent().removeClass('btn-primary');
        
    });
    $(document).on('change', '.domain_click#enable_subdomain', function(e) {
        $('.sundomain').show();
        $('#StoreLink').hide();
        $('.domain').hide();
        $('#domainnote').hide();
        $(this).parent().removeClass('btn-secondary');
        $(this).parent().addClass('btn-primary');
        $('#enable_storelink').parent().addClass('btn-secondary');
        $('#enable_storelink').parent().removeClass('btn-primary');
        $('#enable_domain').parent().addClass('btn-secondary');
        $('#enable_domain').parent().removeClass('btn-primary');
    });

    $(document).ready(function() {
        var checked = $("input[type=radio][name='enable_domain']:checked");
        //alert(checked);
        $(checked).closest('#enable_storelink').removeClass('btn-primary');
        $(checked).parent().addClass('btn-primary');
    });

    function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        show_toastr('Success', "{{ __('Link copied') }}", 'success');
    }

	
		function dealCode()
        {
            let characters = 'ABCDEFGHJKMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
            let charactersLength = 12;
            let randomString = '';
            for (let i = 0; i < charactersLength; i++) {
                let rnum = Math.floor(Math.random() * characters.length);
                randomString +=characters.substring(rnum,rnum+1)
            }
			document.getElementById("myCode").value = randomString;
            return randomString;
        };

    $(".textboxhover").mouseover(function() {
        $(this).removeClass("border-0");
    }).mouseout(function() {
        $(this).addClass("border-0");
    });
</script>

<script>
    $(document).ready(function() {
        setTimeout(function(e) {
            var checked = $("input[type=radio][name='theme_color']:checked");
            $('#themefile').val(checked.attr('data-theme'));
            $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
        }, 300);
        if ($('.enable_pwa_business').is(':checked')) {
            $('.pwa_is_enable').removeClass('disabledPWA');

        } else {
            $('.pwa_is_enable').addClass('disabledPWA');
        }
        $('#pwa_business').on('change', function() {
            if ($('.enable_pwa_business').is(':checked')) {
                $('.pwa_is_enable').removeClass('disabledPWA');
            } else {
                $('.pwa_is_enable').addClass('disabledPWA');
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#is_custom_html_enabled').trigger('change');
    });
    $(document).on('change', '#is_custom_html_enabled', function(e) {
        $('.custom_html_text').hide();
        if ($("#is_custom_html_enabled").prop('checked') == true) {
            $('.custom_html_text').show();
        }
    });

    $(".input-text-location").each(function() {
        var textarea = $(this);
        var text = textarea.text();
        var div = $('<div id="temp"></div>');
        div.css({
            "width": "530px"
        });
        div.text(text);
        $('body').append(div);
        var divHeight = $('#temp').height();
        div.remove();
        divHeight += 32;
        this.setAttribute("style", "height:" + divHeight + "px;overflow-y:hidden;");
    }).on("input", function() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
    });
</script>

<script>
     $(document).ready(function(){
        var gallery=[];
        $( ".gallary_data" ).each(function( index ) {
            var data_id= $(this).attr('data-id');
            gallery.push(data_id);
        
        });
        $("input[name=galary_data]").val(gallery);
        //reset       
        $(".gallery_click").click(function () {
            $(".gallery_click").parent().removeClass('btn-primary').addClass('btn-secondary');
            if ($(this).is(":checked")) {

                //checked
                $(this).parent().removeClass('btn-secondary');
                    $(this).parent().addClass('btn-primary');

            } else {
                //unchecked
                    $(this).parent().removeClass('btn-primary');
                    $(this).parent().addClass('btn-secondary');
            }

        })

    });

    $(document).ready(function() {
        $('#gdpr_cookie').trigger('change');
    });
    $(document).ready(function() {
        var checked = $("input[type=radio][name='theme_color']:checked");
        $('#themefile').val(checked.attr('data-theme'));
        $(checked).closest('.theme-view-card').addClass('selected-theme');
    });

    $(document).on('change', '#gdpr_cookie', function(e) {
        $('.gdpr_cookie_text').hide();
        if ($("#gdpr_cookie").prop('checked') == true) {
            $('.gdpr_cookie_text').show();
        }
    });
    $(document).ready(function() {
        $('#branding').trigger('change');
    });
    $(document).on('change', '#branding', function(e) {
        $('.branding_text').hide();
        if ($("#branding").prop('checked') == true) {
            $('.branding_text').show();
        }
    });

    $(document).on('change', '.domain_click#enable_storelink', function(e) {
        $('#StoreLink').show();
        $('.sundomain').hide();
        $('.domain').hide();
        $('#domainnote').hide();
        $("#enable_storelink").parent().addClass('active');
        $("#enable_domain").parent().removeClass('active');
        $("#enable_subdomain").parent().removeClass('active');
       
    });
    $(document).on('change', '.domain_click#enable_domain', function(e) {
        $('.domain').show();
        $('#StoreLink').hide();
        $('.sundomain').hide();
        $('#domainnote').show();
        $("#enable_domain").parent().addClass('active');
        $("#enable_storelink").parent().removeClass('active');
        $("#enable_subdomain").parent().removeClass('active');
    });
    $(document).on('change', '.domain_click#enable_subdomain', function(e) {
        $('.sundomain').show();
        $('#StoreLink').hide();
        $('.domain').hide();
        $('#domainnote').hide();
        $("#enable_subdomain").parent().addClass('active');
        $("#enable_domain").parent().removeClass('active');
        $("#enable_domain").parent().removeClass('active');
    });

    $(".color1").click(function() {
        var dataId = $(this).attr("data-id");
        $('#color1-' + dataId).trigger('click');
        //$(dataId)
        //$(".theme-view-card").addClass('selected-theme')
        $(".theme-view-card").removeClass('selected-theme')
        $(this).closest('.theme-view-card').addClass('selected-theme');

    });

    $(document).on("click",".color1",function() {
        var id = $(this).attr('data-id');
        $(".theme-view-card").removeClass('selected-theme')
        $(this).closest('.theme-view-card').addClass('selected-theme');
        // $(".theme-view-card").addClass('')
    });



        $('#next-btn').click(function() {
        event.preventDefault();
        $('div').animate({
            scrollLeft: "+=300px"
        }, "slow");
        });

        $('#prev-btn').click(function() {
        event.preventDefault();
        $('div').animate({
            scrollLeft: "-=300px"
        }, "slow");
        });

    $('#download-qr').on('click', function() {

        var qrcode = '{{ $business->slug }}';

        $.ajax({
            url: '{{ route('download.qr') }}',
            type: 'GET',
            data: {
                "qrData": qrcode,
            },
            success: function(data) {

                 if (data.success == true) {
                    $('#qrdata').html(data.data);
                }
                setTimeout(() => {
                    // canvasdata();
                    var element = document.querySelector("#qrdata");
                    saveCapture(element)

                    $("#qrcodeModal").removeClass("show");
                    $("#qrcodeModal").modal('hide');
                    $("body").css("overflow",'');
                    $("body").css("padding-right",'');
                    $('body').removeClass('modal-open');
                    $('#qrcodeModal').removeClass('modal-backdrop');
                    $(".modal-backdrop").removeClass("show");
                    $("#qrdata").html('');
                }, 200);
            }
        });
    });

    // Gallery Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.remove_gallery').on('click', function(e) {
        var this_id = $(this).data('id');
        var business_id = '{{$business->id}}';
        $.ajax({
            url: '{{ route('destory.gallery') }}',
            type: 'POST',
            data: {
                "id": this_id,
                "business_id":business_id,
            },
            success: function(data) {
                $(this).closest('#inputFormRow5').remove();
                location.reload();
            }
        });

    });


    function download(url) {
        var a = $("<a style='display:none' id='js-downloder'>")
            .attr("href", url)
            .attr("download", "{{ $business->slug }}")
            .appendTo("body");
        a[0].click();
        a.remove();
    }

    function saveCapture(element) {
        html2canvas(element).then(function(canvas) {
            download(canvas.toDataURL("image/png"));
        })
    }

    function canvasdata() {
        html2canvas($('#qrdata'), {
            onrendered: function(canvas) {
                var a = document.createElement('a');
                // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                a.download = 'somefilename.jpg';
                a.click();
            }
        });
    }
    $(document).ready(function() {

        var slug = '{{ $business->slug }}';
        var url_link = `{{ url('/') }}/${slug}`;
        $(`.qr-link`).text(url_link);
        $('.qrcode').qrcode(url_link);
        // console.log($('.qrcode').qrcode(url_link));

        let ele = $(".emojiarea").emojioneArea();
        $.each( ele, function( key, value ) {

            ele[key].emojioneArea.on("keyup", function(btn, event) {
                //let sf = ele[key];
                var get_id = ele[key].getAttribute('id');
                var get_val = btn.html();
                get_val = get_val.replace('&nbsp','');

                $(`#${get_id}_preview`).text(get_val);
                $(`.description-div`).show();
                if ($('.description-text').val() == "") {
                    $(`.description-div`).hide();
                }
            });
        });

    });
    
    $("#details-setting-tab").click(function(){
        $('.testimonial-slider').slick('refresh');
        $('.gallery-slider').slick('refresh');
        $('.service-slider').slick('refresh');
    });

        //Gallery
    function getSelectedGalleryValue()
    {
        var checked = $("input[type=radio][name='galleryoption']:checked");   
        var id = $(checked).attr("id");
    
        if(id=='enable_video')
        {
            $('.video').show();
            $('.image').hide();
            $('.custom_image').hide();
            $('.custom_video').hide();

            $('.video').addClass('d-block');
            $('.video').removeClass('d-none');
            $('.image').addClass('d-none');
            $('.custom_image').addClass('d-none');
            $('.custom_video').addClass('d-none');
        

        }
        else if(id=='enable_image'){

            $('.image').show();
            $('.video').hide();
            $('.custom_image').hide();
            $('.custom_video').hide();

            $('.image').addClass('d-block');
            $('.image').removeClass('d-none');
            $('.video').addClass('d-none');
            $('.custom_image').addClass('d-none');
            $('.custom_video').addClass('d-none');
            

        }else if(id=='enable_custom_image_link'){
            $('.video').hide();
            $('.image').hide();
            $('.custom_image').show();
            $('.custom_video').hide();

            $('.custom_image').addClass('d-block');
            $('.custom_image').removeClass('d-none');
            $('.image').addClass('d-none');
            $('.video').addClass('d-none');
            $('.custom_video').addClass('d-none');
            
        
            
        }
        else if(id=='enable_custom_video_link'){
            $('.video').hide();
            $('.image').hide();
            $('.custom_image').hide();
            $('.custom_video').show();

            $('.custom_video').addClass('d-block');
            $('.custom_video').removeClass('d-none');
            $('.image').addClass('d-none');
            $('.video').addClass('d-none');
            $('.custom_image').addClass('d-none');
        
        }
    
    }


</script>
<script type="text/javascript">
    $('.cp_link').on('click', function () {
         var value = $(this).attr('data-link');
         var $temp = $("<input>");
         $("body").append($temp);
         $temp.val(value).select();
         document.execCommand("copy");
         $temp.remove();
         toastrs('{{__('Success')}}', '{{__('Link Copy on Clipboard')}}', 'success');
     });
 </script>
 <script type="text/javascript">
    function enablecookie() {
        const element = $('#enable_cookie').is(':checked');
        $('.cookieDiv').addClass('disabledCookie');
        if (element==true) {
            $('.cookieDiv').removeClass('disabledCookie');
            $("#cookie_logging").attr('checked', true);
            $('.ai_cookie').removeClass('disabledCookie');
        } else {
            $('.cookieDiv').addClass('disabledCookie');
            $("#cookie_logging").attr('checked', false);
            $('.ai_cookie').addClass('disabledCookie');
        }
    }

     //Custom Qr Code Scripts
     $('.qr_type').on('click', function () {
        $("input[type=radio][name='qr_type']").attr('checked', false);
        $("input[type=radio][name='qr_type']").parent().removeClass('btn-primary');
        $("input[type=radio][name='qr_type']").parent().addClass('btn-secondary');
        

        var value=$(this).children().attr('checked', true);
        var qr_type_val=$(this).children().attr('id'); 
        
        if(qr_type_val == 0){
            $('#qr_type_option').slideUp();
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-primary');
        }else if(qr_type_val == 2){
            $('#qr_type_option').slideDown();
            $('#text_div').slideDown();
            $('#image_div').slideUp();
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-primary');
        } else if(qr_type_val == 4){
            $('#qr_type_option').slideDown();
            $('#text_div').slideUp();
            $('#image_div').slideDown();
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-primary');
        }
        generate_qr();
    });
    function generate_qr() {
        if($("input[name='qr_type']:checked").parent().hasClass('btn-primary')==false)
        {
            var chekced=$("input[name='qr_type']:checked").parent().addClass('btn-primary');
            var qr_type_val=$("input[name='qr_type']:checked").attr('id'); 
            if(qr_type_val == 0){
                $('#qr_type_option').slideUp();
                $(this).removeClass('btn-secondary');
                $(this).addClass('btn-primary');
            }else if(qr_type_val == 2){
                $('#qr_type_option').slideDown();
                $('#text_div').slideDown();
                $('#image_div').slideUp();
                $(this).removeClass('btn-secondary');
                $(this).addClass('btn-primary');
            } else if(qr_type_val == 4){
                $('#qr_type_option').slideDown();
                $('#text_div').slideUp();
                $('#image_div').slideDown();
                $(this).removeClass('btn-secondary');
                $(this).addClass('btn-primary');
            }
                
            }
        var card_url = '{{ env('APP_URL').'/'.$business->slug. '?cxz='.$business->secret_code }}';
        $('.code').empty().qrcode({
            render: 'image',
            size: 500,
            ecLevel: 'H',
            minVersion: 3,
            quiet: 1,
            text: card_url,
            fill: $('.foreground_color').val(),
            background: $('.background_color').val(),
            radius: .01 * parseInt($('.radius').val(), 10),
            mode: parseInt($("input[name='qr_type']:checked").val(), 10),
            label: $('.qr_text').val(),
            fontcolor: $('.qr_text_color').val(),
            image: $("#image-buffer")[0],
            mSize: .01 * parseInt($('.qr_size').val(), 10)
        });
    }
    $('.qr_data').on('change', function () {
        generate_qr();
    });

     $('.qr_keyup').on('keyup', function () {
         generate_qr();
     });
     


    $(document).on('change', '.qr_image', function(e) {       
        var img_reader, img_input = $('.qr_image')[0];
        img_input.files && img_input.files[0] && ((img_reader = new window.FileReader).onload = function (event) {
            $("#image-buffer").attr("src", event.target.result);
            setTimeout(generate_qr, 250)
                // ) generate_qr();
        }, img_reader.readAsDataURL(img_input.files[0]))
    });
    generate_qr();
    function showimagename () {
      var uploaded_image_name = document.getElementById('file-7'); 
      $('.uploaded_image_name').text(uploaded_image_name.files.item(0).name);
    };

     function showvideoname () {
      var uploaded_image_name = document.getElementById('file-6'); 
      $('.uploaded_video_name').text(uploaded_image_name.files.item(0).name);
    };
</script>

<script>
    function submitForm(e) {
        var banner_val = '{{$business->banner}}';
        var logo_val = '{{$business->logo}}';
        if(banner_val==null || banner_val=='' || logo_val==null ||logo_val=='')
        {
            var banner = $('input[name=banner]')[0].files[0];
            var logo = $('input[name=logo]')[0].files[0];
            if(banner==undefined || banner=='' )
            {
                //$(`#banner_validate`).text("Banner Field is required");
                return true;
            }
            else if(logo==undefined || logo=='' )
            {
                //$(`#banner_validate`).text("Logo Field is required");
                return true;
            }
            else
            {
                return true;
            }
        }

    }
  </script>

                                                   
@endpush
