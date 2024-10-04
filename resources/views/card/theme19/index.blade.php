@php
    $social_no = 1;
    $appointment_no = 0;
    $service_row_no = 0;
    $testimonials_row_no = 0;
    $gallery_row_no = 0;
    $path = isset($business->banner) && !empty($business->banner) ? asset(Storage::url('card_banner/' . $business->banner)) : asset('custom/img/placeholder-image.jpg');
    $no = 1;
    $stringid = $business->id;
    $is_enable = false;
    $is_contact_enable = false;
    $is_enable_appoinment = false;
	$is_enable_leadgeneration = false;
    $is_enable_service = false;
    $is_enable_testimonials = false;
    $is_enable_sociallinks = false;
    $is_custom_html_enable = false;
    $is_enable_gallery = false;
    $custom_html = $business->custom_html_text;
    $is_branding_enabled = false;
    $branding = $business->branding_text;
    $is_gdpr_enabled = false;
    $gdpr_text = $business->gdpr_text;
    $card_theme = json_decode($business->card_theme);
    $banner = \App\Models\Utility::get_file('card_banner');
    $logo = \App\Models\Utility::get_file('card_logo');
    $image = \App\Models\Utility::get_file('testimonials_images');
    $s_image = \App\Models\Utility::get_file('service_images');
    $company_favicon = Utility::getsettingsbyid($business->created_by);
    $company_favicon = $company_favicon['company_favicon'];
    $logo1 = \App\Models\Utility::get_file('uploads/logo/');
    $meta_image = \App\Models\Utility::get_file('meta_image');
    $gallery_path = \App\Models\Utility::get_file('gallery');
    $qr_path = \App\Models\Utility::get_file('qrcode');
    if (!is_null($business_hours) && !is_null($businesshours)) {
        $businesshours['is_enabled'] == '1' ? ($is_enable = true) : ($is_enable = false);
    }
    if (!is_null($contactinfo) && !is_null($contactinfo)) {
        $contactinfo['is_enabled'] == '1' ? ($is_contact_enable = true) : ($is_contact_enable = false);
    }
    
    if (!is_null($appoinment_hours) && !is_null($appoinment)) {
        $appoinment['is_enabled'] == '1' ? ($is_enable_appoinment = true) : ($is_enable_appoinment = false);
    }
	
	if (!is_null($leadGeneration_content) && !is_null($leadGeneration)) {
        $leadGeneration['is_enabled'] == '1' ? ($is_enable_leadgeneration = true) : ($is_enable_leadgeneration = false);
		
    }
    
    if (!is_null($services_content) && !is_null($services)) {
        $services['is_enabled'] == '1' ? ($is_enable_service = true) : ($is_enable_service = false);
    }
    
    if (!is_null($testimonials_content) && !is_null($testimonials)) {
        $testimonials['is_enabled'] == '1' ? ($is_enable_testimonials = true) : ($is_enable_testimonials = false);
    }
    
    if (!is_null($social_content) && !is_null($sociallinks)) {
        $sociallinks['is_enabled'] == '1' ? ($is_enable_sociallinks = true) : ($is_enable_sociallinks = false);
    }
    
    if (!is_null($custom_html) && !is_null($customhtml)) {
        $customhtml->is_custom_html_enabled == '1' ? ($is_custom_html_enable = true) : ($is_custom_html_enable = false);
    }
    if (!is_null($gallery_contents) && !is_null($gallery)) {
        $gallery['is_enabled'] == '1' ? ($is_enable_gallery = true) : ($is_enable_gallery = false);
    }
    if (!is_null($business->is_branding_enabled) && !is_null($business->is_branding_enabled)) {
        !empty($business->is_branding_enabled) && $business->is_branding_enabled == 'on' ? ($is_branding_enabled = true) : ($is_branding_enabled = false);
    } else {
        $is_branding_enabled = false;
    }
    if (!is_null($business->is_gdpr_enabled) && !is_null($business->is_gdpr_enabled)) {
        !empty($business->is_gdpr_enabled) && $business->is_gdpr_enabled == 'on' ? ($is_gdpr_enabled = true) : ($is_gdpr_enabled = false);
    }
    
    $color = substr($business->theme_color, 0, 6);
    $SITE_RTL = Cookie::get('SITE_RTL');
    if ($SITE_RTL == '') {
        $SITE_RTL = 'off';
    }
    $SITE_RTL = Utility::settings()['SITE_RTL'];
    
    $url_link = env('APP_URL') . '/' . $business->slug;
    $meta_tag_image = $meta_image . '/' . $business->meta_image;
    // Cookie
    $cookie_data = App\Models\Business::card_cookie($business->slug);
    $a = $cookie_data;
@endphp
<!DOCTYPE html>
<html dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="{{ $business->title }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>{{ $business->title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="author" content="{{ $business->title }}">
    <meta name="keywords" content="{{ $business->meta_keyword }}">
    <meta name="description" content="{{ $business->meta_description }}">

    {{-- Meta tag Preview --}}
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $url_link }}">
    <meta property="og:title" content="{{ $business->title }}">
    <meta property="og:description" content="{{ $business->meta_description }}">
    <meta property="og:image"
        content="{{ !empty($business->meta_image) ? $meta_tag_image : asset('custom/img/placeholder-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $url_link }}">
    <meta property="twitter:title" content="{{ $business->title }}">
    <meta property="twitter:description" content="{{ $business->meta_description }}">
    <meta property="twitter:image"
        content="{{ !empty($business->meta_image) ? $meta_tag_image : asset('custom/img/placeholder-image.jpg') }}">

    {{-- End Meta tag Preview --}}

    <link rel="icon"
        href="{{ $logo1 . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('custom/theme19/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/theme19/fonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/emojionearea.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    @if (isset($is_slug))
        <link rel="stylesheet" href="{{ asset('custom/theme19/modal/bootstrap.min.css') }}">
    @endif

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('custom/theme19/css/rtl-main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('custom/theme19/css/rtl-responsive.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('custom/theme19/css/main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('custom/theme19/css/responsive.css') }}">
    @endif

    @if ($business->google_fonts != 'Default' && isset($business->google_fonts))
        <style>
            @import url('{{ \App\Models\Utility::getvalueoffont($business->google_fonts)['link'] }}');

            :root .theme19-v1 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme19-v2 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme19-v3 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme19-v4 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme19-v5 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }
        </style>
    @endif

    @if (isset($is_slug))
        <link rel='stylesheet' href='{{ asset('css/cookieconsent.css') }}' media="screen" />
        <style type="text/css">
            {{ $business->customcss }}
        </style>
    @endif

    {{-- pwa customer app --}}
    <meta name="mobile-wep-app-capable" content="yes">
    <meta name="apple-mobile-wep-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <link rel="apple-touch-icon"
        href="{{ asset(Storage::url('uploads/logo/') . (!empty($setting->value) ? $setting->value : 'favicon.png')) }}" />
    @if ($business->enable_pwa_business == 'on')
        <link rel="manifest"
            href="{{ asset('storage/uploads/theme_app/business_' . $business->id . '/manifest.json') }}" />
    @endif
    @if (!empty($business->pwa_business($business->slug)->theme_color))
        <meta name="theme-color" content="{{ $business->pwa_business($business->slug)->theme_color }}" />
    @endif
    @if (!empty($business->pwa_business($business->slug)->background_color))
        <meta name="apple-mobile-web-app-status-bar"
            content="{{ $business->pwa_business($business->slug)->background_color }}" />
    @endif
    @foreach ($pixelScript as $script)
        <?= $script ?>
    @endforeach
</head>

<body class="tech-card-body">
    <!--wrapper start here-->
    <div id="boxes">
        <div id="view_css"
            class="{{ \App\Models\Utility::themeOne()['theme19'][$business->theme_color]['theme_name'] }}" style="padding: 7px; background: #fff9e7">
            <div class="home-wrapper">
                <section class="home-banner-section padding-top">
                    <div class="container">
                        <div class="client-intro">
                            <div class="client-image">
                                <img src="{{ isset($business->logo) && !empty($business->logo) ? $logo . '/' . $business->logo : asset('custom/img/logo-placeholder-image-2.png') }}"
                                    id="business_logo_preview" alt="image">
                            </div>
                            <div class="client-brief-info text-center">
                                <h3 id="{{ $stringid . '_title' }}_preview">{{ $business->title }}</h3>
                                <h6 id="{{ $stringid . '_designation' }}_preview">{{ $business->designation }}</h6>
                                <span id="{{ $stringid . '_subtitle' }}_preview">{{ $business->sub_title }}</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="top-social-section" style="background: #e4e4e4;">
                    <div class="container" id="contact-div1" >
                        <ul class="banner-social-icons" id="inputrow_contact_preview1">
                            @if (!is_null($social_content) && !is_null($sociallinks))
                                            @foreach ($social_content as $social_key => $social_val)
                                                @foreach ($social_val as $social_key1 => $social_val1)
                                                    @if ($social_key1 != 'id')
                                            <li class="socials_{{ $loop->parent->index + 1 }}"
                                                            id="socials_{{ $loop->parent->index + 1 }}">
                                                            @if ($social_key1 == 'Whatsapp')
                                                                @if ((new \Jenssegers\Agent\Agent())->isDesktop())
                                                                    @php
                                                                        $social_links = url('https://web.whatsapp.com/send?phone=' . $social_val1);
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $social_links = url('https://wa.me/' . $social_val1);
                                                                    @endphp
                                                                @endif
                                                            @else
																	@if ($social_key1 == 'Instagram')
                                                                    @php
                                                                        $social_links = url('https://www.instagram.com/'.$social_val1);
                                                                    @endphp
																	@elseif ($social_key1 == 'Facebook')
                                                                    @php
                                                                        $social_links = url('https://web.facebook.com/'.$social_val1);
                                                                    @endphp
																	@elseif ($social_key1 == 'Linkedin')
                                                                    @php
                                                                        $social_links = url('https://www.linkedin.com/'.$social_val1);
                                                                    @endphp
																	@elseif ($social_key1 == 'Tiktok')
                                                                    @php
                                                                        $social_links = url('https://www.tiktok.com/'.$social_val1);
                                                                    @endphp
																	@elseif ($social_key1 == 'Twitter')
                                                                    @php
                                                                        $social_links = url('https://x.com/'.$social_val1);
                                                                    @endphp
																	@elseif ($social_key1 == 'Youtube')
                                                                    @php
                                                                        $social_links = url('https://youtube.com/'.$social_val1);
                                                                    @endphp
																	@elseif ($social_key1 == 'Behance')
                                                                    @php
                                                                        $social_links = url('https://behance.com/'.$social_val1);
                                                                    @endphp
																	@else
																		@php
                                                                        $social_links = url($social_val1);
                                                                    @endphp
																	@endif
                                                                @endif

                                                    <a href="{{ $social_links }}"
                                                                class="social_link_{{ $loop->parent->index + 1 }}_href_preview"
                                                                id="social_link_{{ $loop->parent->index + 1 }}_href_preview'}}"
                                                                target="_blank">

                                                                <img src="{{ asset('custom/theme19/icon/' . $color . '/social/' . strtolower($social_key1) . '.svg') }}"
                                                                    alt="twitter" class="img-fluid"
                                                                    style="height: 30px">
                                                            </a>
                                            </li>
                                        @endif
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                @endforeach

                            @endif
                        </ul>
                    </div>
                </section>
                @php $j = 1; @endphp

                @foreach ($card_theme->order as $order_key => $order_value)
                    @if ($j == $order_value)

                        @if ($order_key == 'description')
                            <section class="contact-info-section padding-top">
                                <div class="container">
                                    <div class="client-intro">
                                        <div class="client-brief-intro">
                                            <p id="{{ $stringid . '_desc' }}_preview">
                                                {{ $business->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'bussiness_hour')
                            <section class="business-hour-section padding-top" id="business-hours-div">
                                <div class="container">
                                    <div class="section-title text-center">
                                        <h2>{{ __('Business Hours') }}</h2>
                                    </div>
                                    <div class="daily-hours-content">
                                        <div class="daily-hours-inner">
                                            <ul class="pl-1">
                                                @foreach ($days as $k => $day)
                                                    <li>
                                                        <p>{{ __($day) }}:<span
                                                                class="days_{{ $k }}">
                                                                @if (isset($business_hours->$k) && $business_hours->$k->days == 'on')
                                                                    <span
                                                                        class="days_{{ $k }}_start">{{ !empty($business_hours->$k->start_time) && isset($business_hours->$k->start_time) ? date('h:i A', strtotime($business_hours->$k->start_time)) : '00:00' }}</span>
                                                                    - <span
                                                                        class="days_{{ $k }}_end">{{ !empty($business_hours->$k->end_time) && isset($business_hours->$k->end_time) ? date('h:i A', strtotime($business_hours->$k->end_time)) : '00:00' }}</span>
                                                                @else
                                                                    {{ __('Closed') }}
                                                                @endif
                                                            </span></p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'appointment')
                            <section id="appointment-div" class="appointment-section padding-top">
                                <div class="container">
                                    <div class="section-title text-center">
                                        <h2><b>{{ __('Make an') }}</b> {{ __('appointment') }}</h2>
                                    </div>
                                    <form class="appointment-detail">
                                        <div class="app-date form-group">
                                            <label>{{ __('Date') }}:</label>
                                            <input type="text" name="date" class="form-control datepicker_min"
                                                placeholder="{{ __('Pick a Date') }}">
                                        </div>
                                        <div class="app-hour form-group" id="inputrow_appointment_preview">
                                            <label>{{ __('Hour:') }}</label>
                                            <select class="form-control app_select time">
                                                <option id="">{{ __('Select hour') }}</option>
                                                @if (!is_null($appoinment_hours))
                                                    @foreach ($appoinment_hours as $k => $hour)
                                                        <option id="{{ 'appointment_' . $appointment_no }}">
                                                            <span id="appoinment_start_{{ $appointment_no }}_preview">
                                                                @if (!empty($hour->start))
                                                                    {{ $hour->start }}
                                                                @else
                                                                    00:00
                                                                @endif
                                                            </span> - <span
                                                                id="appoinment_end_{{ $appointment_no }}_preview">
                                                                @if (!empty($hour->end))
                                                                    {{ $hour->end }}
                                                                @else
                                                                    00:00
                                                                @endif
                                                            </span>
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </form>
                                    <div class="w-100 mt-0">
                                        <span class="text-danger span-error-date"></span>
                                    </div>
                                    <div class="text-center mt-0 mb-3 col-12">
                                        <span class="text-danger text-center span-error-time"></span>
                                    </div>
                                    <div class="appointment-btn">
                                        <a href="javascript:;" data-toggle="modal" data-target="#appointment-modal"
                                            class="btn" tabindex="0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4 1C4 0.447715 4.44772 0 5 0C5.55228 0 6 0.447715 6 1V2H14V1C14 0.447715 14.4477 0 15 0C15.5523 0 16 0.447715 16 1V2H17C18.6569 2 20 3.34315 20 5V17C20 18.6569 18.6569 20 17 20H3C1.34315 20 0 18.6569 0 17V5C0 3.34315 1.34315 2 3 2H4V1Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8 10C7.44772 10 7 10.4477 7 11C7 11.5523 7.44772 12 8 12H15C15.5523 12 16 11.5523 16 11C16 10.4477 15.5523 10 15 10H8ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z"
                                                    fill="white" />
                                            </svg>
                                            {{ __('Book appointment') }}
                                        </a>
                                    </div>
                                </div>

                            </section>
                        @endif
                        @if ($order_key == 'service')
                            <section class="service-section padding-top padding-bottom" id="services-div">
                                <div class="container">
                                    <div class="section-title text-center">
                                        <h2>{{ __('Services') }}</h2>
                                    </div>

                                    <div class="service-card-wrapper" id="inputrow_service_preview">
                                        @php $image_count = 0; @endphp
                                        @foreach ($services_content as $k1 => $content)
                                            <div class="service-card" id="services_{{ $service_row_no }}">
                                                <div class="service-card-inner">
                                                    <div class="service-icon testimonials_image">
                                                        <img id="{{ 's_image' . $image_count . '_preview' }}"
                                                            src="{{ isset($content->image) && !empty($content->image) ? $s_image . '/' . $content->image : asset('custom/img/logo-placeholder-image-21.png') }}"
                                                            alt="image">
                                                    </div>
                                                    <h5 id="{{ 'title_' . $service_row_no . '_preview' }}">
                                                        {{ $content->title }}</h5>
                                                    <p id="{{ 'description_' . $service_row_no . '_preview' }}">
                                                        {{ $content->description }}
                                                    </p>
                                                    @if (!empty($content->purchase_link))
                                                        <a href="{{ url($content->purchase_link) }}"
                                                            class="read-more-btn"
                                                            id="{{ 'link_title_' . $service_row_no . '_preview' }}">
                                                            {{ $content->link_title }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                height="6" viewBox="0 0 4 6" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                            @php
                                                $image_count++;
                                                $service_row_no++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'gallery')
                            <section class="gallery-section padding-top padding-bottom" id="gallery-div">
                                <div class="container">
                                    <div class="section-title text-center">
                                        <h2>{{ __('Gallery') }}</h2>
                                    </div>
                                    <div class="gallery-card-wrapper" id="inputrow_gallery_preview">
                                        @php $image_count = 0; @endphp
                                        @if (isset($is_pdf))
                                            <div class="row gallery-cards">
                                                @if (!is_null($gallery_contents) && !is_null($gallery))
                                                    @foreach ($gallery_contents as $key => $gallery_content)
                                                        <div class="col-md-6 col-12 p-0 gallery-card-pdf"
                                                            id="gallery_{{ $gallery_row_no }}">
                                                            <div class="gallery-card-inner-pdf">
                                                                <div class="gallery-icon-pdf">
                                                                    @if (isset($gallery_content->type))
                                                                        @if ($gallery_content->type == 'video')
                                                                            <a href="javascript:;" id=""
                                                                                tabindex="0" class="videopop">
                                                                                <video loop autoplay controls="true">
                                                                                    <source class="videoresource"
                                                                                        src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'image')
                                                                            <a href="javascript:;" id="imagepopup"
                                                                                tabindex="0" class="imagepopup">
                                                                                <img src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images"
                                                                                    class="imageresource">
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $image_count++;
                                                            $gallery_row_no++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        @else
                                            <div class="gallery-slider">
                                                @if (!is_null($gallery_contents) && !is_null($gallery))
                                                    @foreach ($gallery_contents as $key => $gallery_content)
                                                        <div class="gallery-card" id="gallery_{{ $gallery_row_no }}">
                                                            <div class="gallery-card-inner">
                                                                <div class="gallery-icon">
                                                                    @if (isset($gallery_content->type))
                                                                        @if ($gallery_content->type == 'video')
                                                                            <a href="javascript:;" id=""
                                                                                tabindex="0" class="videopop">
                                                                                <video loop  controls="true">
                                                                                    <source class="videoresource"
                                                                                        src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'image')
                                                                            <a href="javascript:;" id="imagepopup"
                                                                                tabindex="0" class="imagepopup">
                                                                                <img src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images"
                                                                                    class="imageresource">
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'custom_video_link')
                                                                            @if (str_contains($gallery_content->value, 'youtube') || str_contains($gallery_content->value, 'youtu.be'))
                                                                                @php
                                                                                    if (strpos($gallery_content->value, 'src') !== false) {
                                                                                        preg_match('/src="([^"]+)"/', $gallery_content->value, $match);
                                                                                        $url = $match[1];
                                                                                        $video_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                                                    } elseif (strpos($gallery_content->value, 'src') == false && strpos($gallery_content->value, 'embed') !== false) {
                                                                                        $video_url = str_replace('https://www.youtube.com/embed/', '', $gallery_content->value);
                                                                                    } else {
                                                                                        $video_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $gallery_content->value));
                                                                                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $gallery_content->value, $matches);
                                                                                        if (count($matches) > 0) {
                                                                                            $videoId = $matches[1];
                                                                                            $video_url = strtok($videoId, '&');
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0" class="videopop1">
                                                                                    <video loop controls="true"
                                                                                        poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                        <source class="videoresource1"
                                                                                            src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? 'https://www.youtube.com/embed/' . $video_url : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            @else
                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0" class="videopop1">
                                                                                    <video loop controls="true"
                                                                                        poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                        <source class="videoresource1"
                                                                                            src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            @endif
                                                                        @elseif($gallery_content->type == 'custom_image_link')
                                                                            <a href="javascript:;" id=""
                                                                                target="" tabindex="0"
                                                                                class="imagepopup1">
                                                                                <img class="imageresource1"
                                                                                    src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images" id="upload_image">
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $image_count++;
                                                            $gallery_row_no++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        @endif
                        
                        
                        @if ($order_key == 'contact_info')
                            <div class="container" id="contact-div">
    <div class="client-contact" id="inputrow_contact_preview">
        @if (!is_null($contactinfo_content) && !is_null($contactinfo))
            @foreach ($contactinfo_content as $key => $val)
                @foreach ($val as $key1 => $val1)
                    @if ($key1 == 'Phone')
                        @php $href = 'tel:'.$val1; @endphp
                    @elseif($key1 == 'Email')
                         @php $href = 'mailto:'.$val1; @endphp
                    @elseif($key1 == 'Address')
                        @php $href = ''; @endphp
                    @else
                        @php $href = $val1; @endphp
                    @endif

                    @if ($key1 != 'id')
                        @php
                            $svg_file_2 = file_get_contents(asset('custom/theme19/icon/' . $color . '/contact1/' . strtolower($key1) . '.svg'));
                                                        
                                $find_string_2 = '<svg>';
                                $position_2 = strpos($svg_file_2, $find_string_2);
                                                        
                                $svg_file_new_2 = substr($svg_file_2, $position_2);
                        @endphp

                    <div class="calllink contactlink contact_{{ $loop->parent->index + 1 }}"
                                                        id="contact_{{ $loop->parent->index + 1 }}" style="display: flex">
                                                        <a href="{{ $href }}" class="theme-text">
                                                            {!! $svg_file_new_2 !!}
                                                            <div class="contact-text">
                                                                @if ($key1 == 'Address')
                                                                    @foreach ($val1 as $key2 => $val2)
                                                                        @if ($key2 == 'Address')
                                                                            @php $href = $val2; @endphp
																		<span class="{{ $key1 . '_' . $no }}" id="{{ $key1 . '_' . $no }}">{{ $val2 }}</span>
                                                                <div class="contact-label">{{ $key1 }}</div>
																	</div>
																	@endif
                                                                    @endforeach

																@else
                                                                    @if ($key1 == 'Whatsapp')
                                                                        <a href="{{ url('https://wa.me/' . $href) }}"
                                                                            target="_blank" style="justify-content: space-between;margin-top: 0;">
																		
                                                                        @else
                                                                            <a href="{{ $href }}" style="justify-content: space-between;margin-top: 0">
																		
                                                                    @endif
                                                                    <div class="contact-text">
																		<span class="{{ $key1 . '_' . $no }}" id="{{ $key1 . '_' . $no }}">{{ Str::limit($val1, 23) }}</span>
                                                                <div class="contact-label">{{ $key1 }}</div>
																	</div>
															</div>
                                                                    
                                                                @endif	

                                                        </a>
                                                    </div>
													
                    @endif
                @endforeach
            @endforeach
        @endif
    </div>

                        @endif
						
						@if ($order_key == 'leadgeneration')
                            <section class="more-card-section padding-bottom"  style="background: linear-gradient(180deg, rgb(245 245 245) 0%, rgb(255 255 255) 100%);border-radius: 15px 15px 15px 15px; padding-top: 30px;">
                                
                                <div class="container" id = "leadgeneration-div" style="width: 100%;">
                                    
                                    <div class="more-btn">

                                        @foreach ($leadGeneration_content  as $leadgen) 
											
											<a href="javascript:;" class="btn lead-generation{{$leadgen->id}}" tabindex="0" style="width:100%;margin-bottom: 10px;height: 55px;border-radius: 15px;">
												<img src="{{ asset('custom/theme50/icon/' . $color . '/phone.svg') }}"
													alt="signout" class="img-fluid">
												&nbsp;
												{{ __($leadgen->btitle) }}
											</a>
										
										@endforeach
											
										
                                    </div>
                                </div>
								<div class="container" style="width: 100%;">
                                    <div class="more-card-btn">
                                        
                                        <a href="javascript:;" class="btn our-card" tabindex="0" style="width:100%;margin-bottom: 10px;height: 55px;border-radius: 15px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="22"
                                                viewBox="0 0 18 22" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.99858 9.03956C6.02798 9.59107 5.60474 10.062 5.05324 10.0914C4.30055 10.1315 3.7044 10.1806 3.23854 10.2297C2.61292 10.2957 2.23278 10.68 2.16959 11.2328C2.07886 12.0264 2 13.2275 2 14.9997C2 16.772 2.07886 17.973 2.16959 18.7666C2.23289 19.3204 2.61207 19.7036 3.23675 19.7695C4.33078 19.885 6.13925 19.9997 9 19.9997C11.8608 19.9997 13.6692 19.885 14.7632 19.7695C15.3879 19.7036 15.7671 19.3204 15.8304 18.7666C15.9211 17.973 16 16.7719 16 14.9997C16 13.2275 15.9211 12.0264 15.8304 11.2328C15.7672 10.68 15.3871 10.2957 14.7615 10.2297C14.2956 10.1806 13.6995 10.1315 12.9468 10.0914C12.3953 10.062 11.972 9.59107 12.0014 9.03956C12.0308 8.48806 12.5017 8.06482 13.0532 8.09422C13.8361 8.13595 14.4669 8.18757 14.9712 8.24075C16.4556 8.3973 17.6397 9.4504 17.8175 11.0056C17.9188 11.892 18 13.1712 18 14.9997C18 16.8282 17.9188 18.1074 17.8175 18.9938C17.6398 20.5481 16.4585 21.6017 14.9732 21.7585C13.7919 21.8831 11.9108 21.9997 9 21.9997C6.08922 21.9997 4.20806 21.8831 3.02684 21.7585C1.54151 21.6017 0.360208 20.5481 0.182529 18.9938C0.081204 18.1074 0 16.8282 0 14.9997C0 13.1712 0.0812039 11.892 0.182529 11.0056C0.360314 9.4504 1.54436 8.3973 3.02877 8.24075C3.53306 8.18757 4.16393 8.13595 4.94676 8.09422C5.49827 8.06482 5.96918 8.48806 5.99858 9.03956Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.20711 5.20711C5.81658 5.59763 5.18342 5.59763 4.79289 5.20711C4.40237 4.81658 4.40237 4.18342 4.79289 3.79289L8.29289 0.292893C8.68342 -0.0976311 9.31658 -0.0976311 9.70711 0.292893L13.2071 3.79289C13.5976 4.18342 13.5976 4.81658 13.2071 5.20711C12.8166 5.59763 12.1834 5.59763 11.7929 5.20711L10 3.41421V13C10 13.5523 9.55228 14 9 14C8.44772 14 8 13.5523 8 13L8 3.41421L6.20711 5.20711Z"
                                                    fill="white" />
                                            </svg>
                                            {{ __('View QR Code') }}
                                        </a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#mycontactModal"
                                            class="btn our-contact" tabindex="0" style="width:100%;margin-bottom: 10px;height: 55px;border-radius: 15px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.82379 1.66449C5.83674 0.651544 7.512 0.770603 8.37152 1.91662L9.79825 3.81894C10.5011 4.75611 10.4079 6.06751 9.57958 6.89586L8.52769 7.94775C8.62963 8.2131 8.96522 8.79539 9.98717 9.81734C11.0091 10.8393 11.5914 11.1749 11.8567 11.2768L12.9086 10.2249C13.737 9.39657 15.0484 9.30336 15.9856 10.0062L17.8879 11.433C19.0339 12.2925 19.153 13.9678 18.14 14.9807C17.8107 15.31 17.755 15.3658 17.2054 15.9153C16.6453 16.4754 15.456 16.999 14.2519 17.0513C12.3677 17.1332 9.80829 16.2966 6.65811 13.1464C3.50793 9.99621 2.67127 7.43681 2.7532 5.55258C2.79877 4.50442 3.13201 3.35321 3.89355 2.6035C4.43874 2.04954 4.50964 1.97864 4.82379 1.66449ZM4.32105 5.62075C4.26426 6.92686 4.81471 9.08362 7.7678 12.0367C10.7209 14.9898 12.8776 15.5402 14.1838 15.4835C15.403 15.4304 16.0571 14.8413 16.0957 14.8056L17.0303 13.871C17.368 13.5334 17.3283 12.975 16.9463 12.6885L15.044 11.2617C14.7316 11.0274 14.2944 11.0585 14.0183 11.3346C13.6023 11.7506 13.3183 12.0388 12.7624 12.5926C11.6077 13.743 9.63106 11.6806 8.87748 10.927C8.18495 10.2345 6.07446 8.1951 7.21078 7.04531C7.21302 7.04305 7.51909 6.73699 8.4699 5.78618C8.74601 5.51006 8.77708 5.07293 8.54279 4.76054L7.11605 2.85822C6.82955 2.47621 6.27112 2.43653 5.93348 2.77418C5.62271 3.08494 5.271 3.43665 4.99979 3.70973C4.44161 4.27178 4.35092 4.93369 4.32105 5.62075Z"
                                                    fill="white" />
                                            </svg>
                                            {{ __('Connect With Me') }}
                                        </a>
                                    </div>
                                </div>
                            </section>
							
                        @endif
                        
                        
                        @php
                            $j = $j + 1;
                        @endphp
                    @endif
                @endforeach

                @if ($is_branding_enabled)
                    <div id="is_branding_enabled" class="is_branding_enable copyright mt-3 pb-2">
                        <p id="{{ $stringid . '_branding' }}_preview" class="branding_text">
                            {{ $business->branding_text }}
                        </p>
                    </div>
                @endif


            </div>
            <!--appointment popup start here-->
            <div class="appointment-popup">
                <div class="container">
                    <form class="appointment-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Make Appointment') }}</h5>
                            <div class="close-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M14.6 17.4L0.600001 3.4C-0.2 2.6 -0.2 1.4 0.600001 0.600001C1.4 -0.2 2.6 -0.2 3.4 0.600001L17.4 14.6C18.2 15.4 18.2 16.6 17.4 17.4C16.6 18.2 15.4 18.2 14.6 17.4V17.4Z"
                                        fill="#000" />
                                    <path
                                        d="M0.600001 14.6L14.6 0.600001C15.4 -0.2 16.6 -0.2 17.4 0.600001C18.2 1.4 18.2 2.6 17.4 3.4L3.4 17.4C2.6 18.2 1.4 18.2 0.600001 17.4C-0.2 16.6 -0.2 15.4 0.600001 14.6V14.6Z"
                                        fill="#000" />
                                </svg>
                            </div>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Name:') }} </label>
                                    <input type="text" class="form-control app_name"
                                        placeholder="{{ __('Enter your name') }}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Email:') }} </label>
                                    <input type="email" class="form-control app_email"
                                        placeholder="{{ __('Enter your email') }}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-email"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Phone:') }} </label>
                                    <input type="number" class="form-control app_phone"
                                        placeholder="{{ __('Enter your phone no.') }}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-phone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" name="CLOSE" class="close-btn btn ">
                                {{ __('Close') }}
                            </button>
                            <button type="button" name="SUBMIT" class="btn btn-secondary" id="makeappointment">
                                {{ __('Make Appointment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--appointment popup end here-->
            <!--card popup start here-->
            <div class="card-popup">
                <div class="container">
                    <div class="share-card-wrapper">
                        <div class="section-title">
                            <div class="close-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="9"
                                    viewBox="0 0 7 9" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.84542 0.409757C6.21819 0.789434 6.21819 1.40501 5.84542 1.78469L3.17948 4.5L5.84542 7.21531C6.21819 7.59499 6.21819 8.21057 5.84542 8.59024C5.47265 8.96992 4.86826 8.96992 4.49549 8.59024L1.15458 5.18746C0.781807 4.80779 0.781807 4.19221 1.15458 3.81254L4.49549 0.409757C4.86826 0.0300809 5.47265 0.0300809 5.84542 0.409757Z"
                                        fill="#12131A" />
                                </svg>
                            </div>
                            <div class="section-title-center">
                                <h5>{{ __('Scan QR Code') }}</h5>
                            </div>
                            <button type="button" name="LOGOUT" class="logout-btn">

                            </button>
                        </div>
                        <div class="qr-scaner-wrapper">
                            <div class="qr-image">
                                <div class="shareqrcode mt-3"></div>
                            </div>
                           
                            <ul class="card-social-icons">
                                
                            </ul>

                        </div>

                    </div>
                </div>
            </div>
            <!--contact popup start here-->
            <div class="contact-popup">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Connect With Me') }}</h5>
                            <div class="close-search" data-dismiss="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M14.6 17.4L0.600001 3.4C-0.2 2.6 -0.2 1.4 0.600001 0.600001C1.4 -0.2 2.6 -0.2 3.4 0.600001L17.4 14.6C18.2 15.4 18.2 16.6 17.4 17.4C16.6 18.2 15.4 18.2 14.6 17.4V17.4Z"
                                        fill="#000" />
                                    <path
                                        d="M0.600001 14.6L14.6 0.600001C15.4 -0.2 16.6 -0.2 17.4 0.600001C18.2 1.4 18.2 2.6 17.4 3.4L3.4 17.4C2.6 18.2 1.4 18.2 0.600001 17.4C-0.2 16.6 -0.2 15.4 0.600001 14.6V14.6Z"
                                        fill="#000" />
                                </svg>
                            </div>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Name') }}:</label>
                                    <input type="text" name="name" placeholder="{{ __('Enter your name') }}"
                                        class="form-control contact_name">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactname"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Email') }}:</label>
                                    <input type="email" name="email" placeholder="{{ __('Enter your email') }}"
                                        class="form-control contact_email">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactemail"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Phone') }}:</label>
                                    <input type="text" name="phone"
                                        placeholder="{{ __('Enter your phone no.') }}"
                                        class="form-control contact_phone">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactphone"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="business_id" value="{{ $business->id }}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Message') }}:</label>
                                    <textarea name="message" placeholder="{{ __('Enter your Message.') }}"
                                        class="custom_size contact_message emojiarea" rows="3"></textarea>
                                    <div class="">
                                        <span class="text-danger h5 span-error-contactmessage"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" class="close-btn btn "
                                data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="button" class="btn btn-secondary"
                                id="makecontact">{{ __('Connect') }}</button>


                        </div>
                    </form>
                </div>
            </div>
			<div class="add-to-contact-wrapper " style="position: fixed;bottom: 10px;left: 50%;transform: translateX(-50%);z-index: 999999">
        <a href="{{ route('bussiness.save', $business->slug) }}" class="btn btn-primary add-to-contact-btn add-to-contact-botton" ><i class="fa fa-address-card"></i>&nbsp; Add to Contact</a>
    </div>
            <!--contact popup end here-->
            <!--card popup end here-->
			@foreach ($leadGeneration_content  as $leadgen) 
		<div class="leadgeneration-popup{{$leadgen->id}}">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{__($leadgen->title) }}</h5>
                            <div class="close-search">
                                <img src="{{ asset('custom/theme50/icon/' . $color . '/close.svg') }}"
                                    alt="back" class="img-fluid">
                            </div>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Name:') }}</label>
                                    <input type="text" name="name{{$leadgen->id}}" placeholder="{{ __('Enter your name') }}"
                                        class="form-control contact_name{{$leadgen->id}}">
										<input type="hidden" name="campaign_name{{$leadgen->id}}" class="form-control campaign_name{{$leadgen->id}}" value = "{{$leadgen->title}}">
										<input type="hidden" name="campaign_id{{$leadgen->id}}" class="form-control campaign_id{{$leadgen->id}}" value = "{{$leadgen->id}}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactname{{$leadgen->id}}"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Email:') }}</label>
                                    <input type="email" name="email{{$leadgen->id}}" placeholder="{{ __('Enter your email') }}"
                                        class="form-control contact_email{{$leadgen->id}}" id="recipient-email{{$leadgen->id}}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactemail{{$leadgen->id}}"></span>
                                    </div>
                                </div>
                            </div>
							
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Phone:') }}</label>
                                    <input type="text" name="phone{{$leadgen->id}}"
                                        placeholder="{{ __('Enter your phone no') }}"
                                        class="form-control contact_phone{{$leadgen->id}}" id="recipient-phone{{$leadgen->id}}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactphone{{$leadgen->id}}"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Message:') }}</label>
                                    <textarea name="message{{$leadgen->id}}" placeholder="" class="custom_size contact_message{{$leadgen->id}} emojiarea" id="recipient-message{{$leadgen->id}}"></textarea>
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactmessage{{$leadgen->id}}"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="business_id" value="{{ $business->id }}">
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" name="CLOSE" class="close-btn btn">
                                {{ __('Cancel') }}
                            </button>
                            <button type="button" class="btn btn-secondary"
                                id="leadcontact{{$leadgen->id}}">{{ __('Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
		@endforeach
            <div class="contact-popup-2" id="passwordmodel" role="dialog" data-backdrop="static"
                data-keyboard="false">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Enter Password') }}</h5>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Password') }}:</label>
                                    <input type="password" name="Password" placeholder="{{ __('Enter password') }}"
                                        class="form-control password_val" placeholder="Password">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-password"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button"
                                class="btn form-btn--submit password-submit">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Gallery Models --}}
            <div class="contact-popup-2" id="gallerymodel" role="dialog" data-backdrop="static"
                data-keyboard="false">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('') }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group section-title">
                                    <label>{{ __('Image preview') }}:</label>
                                    <img src="" class="imagepreview" style="width: 500px; height: 300px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" class="btn btn-default close-btn close-model"
                                data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="contact-popup-2" id="videomodel" role="dialog" data-backdrop="static"
                data-keyboard="false">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('') }}</h5>
                        </div>
                        <div class="row ">
                            <div class="col-12">
                                <div class="form-group section-title">
                                    <label>{{ __('Video preview') }}:</label>
                                    <iframe width="100%" height="360" class="videopreview" src=""
                                        frameborder="0" allowfullscreen ></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" class="btn btn-default close-btn close-model1"
                                data-dismiss="modal">{{__('Close')}}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overlay"></div>
            <img src="{{ isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : '' }}" id="image-buffers"
                style="display: none">
        </div>
    </div>
    <div id="previewImage"> </div>
    <a id="download" href="#" class="font-lg download mr-3 text-white">
        <i class="fas fa-download"></i>
    </a>

    <!---wrapper end here-->

    <!-- Modal -->

    <!--scripts start here-->


    <script src="{{ asset('custom/theme19/js/jquery.min.js') }}"></script>
    <script src="{{ asset('custom/theme19/js/slick.min.js') }}" defer="defer"></script>
    @if ($SITE_RTL == 'on')
        <script src="{{ asset('custom/theme19/js/rtl-custom.js') }}" defer="defer"></script>
    @else
        <script src="{{ asset('custom/theme19/js/custom.js') }}" defer="defer"></script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.date.js"></script>

    <script src="{{ asset('custom/js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.min.js') }}"></script>
    <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>
    @if ($business->enable_pwa_business == 'on')
        <script type="text/javascript">
            const container = document.querySelector("body")

            const coffees = [];

            if ("serviceWorker" in navigator) {
                window.addEventListener("load", function() {
                    navigator.serviceWorker
                        .register("{{ asset('serviceWorker.js') }}")
                        .then(res => console.log("service worker registered"))
                        .catch(err => console.log("service worker not registered", err))

                })
            }
        </script>
    @endif

    <script type="text/javascript">
        $('#Demo').socialSharingPlugin({
            urlShare: window.location.href,
            description: $('meta[name=description]').attr('content'),
            title: $('title').text()
        })
    </script>
    <script>
        $(".imagepopup").on("click", function(e) {
            var imgsrc = $(this).children(".imageresource").attr("src");
            $('.imagepreview').attr('src',
            imgsrc); // here asign the image to the modal when the user click the enlarge link
            $("#gallerymodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#gallerymodel').css("background", 'rgb(0 0 0 / 50%)')
        });

        $(".imagepopup1").on("click", function() {
            var imgsrc1 = $(this).children(".imageresource1").attr("src");
            $('.imagepreview').attr('src',
            imgsrc1); // here asign the image to the modal when the user click the enlarge link
            $("#gallerymodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#gallerymodel').css("background", 'rgb(0 0 0 / 50%)')
        });

        $(".videopop").on("click", function() {
            var videosrc = $(this).children('video').children(".videoresource").attr("src");
            $('.videopreview').attr('src',
            videosrc); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                'rgb(0 0 0 / 50%)') // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".videopop1").on("click", function() {
            var videosrc1 = $(this).children('video').children(".videoresource1").attr("src");
            $('.videopreview').attr('src',
            videosrc1); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                'rgb(0 0 0 / 50%)') // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".close-model").on("click", function() {
            $("#gallerymodel").removeClass("active");
            $("body").removeClass("no-scroll");
            $('html').removeClass('modal-open');
            $('#gallerymodel').css("background", '')
        });

        $(".close-model1").on("click", function() {
            $("#videomodel").removeClass("active");
            $("body").removeClass("no-scroll");
            $('html').removeClass('modal-open');
            $('#videomodel').css("background", '')
        });
        $(document).ready(function() {
            var date = new Date();
            $('.datepicker_min').pickadate({
                min: date,
            })
        });

        //Password Check
        @if (!Auth::check())
            let ispassword;
            var ispassenable = '{{ $business->enable_password }}';
            var business_password = '{{ $business->password }}';

            if (ispassenable == 'on') {
                $('.password-submit').click(function() {

                    ispassword = 'true';
                    passwordpopup('true');
                });

                function passwordpopup(type) {
                    if (type == 'false') {

                        $("#passwordmodel").addClass("active");
                        $("body").toggleClass("no-scroll");
                        $('html').addClass('modal-open');
                        $('#passwordmodel').css("background", 'rgb(0 0 0 / 50%)')
                    } else {

                        var password_val = $('.password_val').val();

                        if (password_val == business_password) {
                            $("#passwordmodel").removeClass("active");
                            $("body").removeClass("no-scroll");

                            $('html').removeClass('modal-open');
                            $('#passwordmodel').css("background", '');

                        } else {

                            $(`.span-error-password`).text("{{ __('*Please enter correct password') }}");
                            passwordpopup('false');

                        }
                    }
                }
                if (ispassword == undefined) {

                    passwordpopup('false');
                }
            }
        @endif

        $(document).ready(function() {
            $(".emojiarea").emojioneArea();
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");
            var slug = '{{ $business->slug }}';
            var url_link = `{{ url('/') }}/${slug}`;
            $(`.qr-link`).text(url_link);
            var foreground_color =
                `{{ isset($qr_detail->foreground_color) ? $qr_detail->foreground_color : '#000000' }}`;
            var background_color =
                `{{ isset($qr_detail->background_color) ? $qr_detail->background_color : '#ffffff' }}`;
            var radius = `{{ isset($qr_detail->radius) ? $qr_detail->radius : 26 }}`;
            var qr_type = `{{ isset($qr_detail->qr_type) ? $qr_detail->qr_type : 0 }}`;
            var qr_font = `{{ isset($qr_detail->qr_text) ? $qr_detail->qr_text : 'vCard' }}`;
            var qr_font_color = `{{ isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a' }}`;
            var size = `{{ isset($qr_detail->size) ? $qr_detail->size : 9 }}`;

            $('.shareqrcode').empty().qrcode({
                render: 'image',
                size: 500,
                ecLevel: 'H',
                minVersion: 3,
                quiet: 1,
                text: url_link,
                fill: foreground_color,
                background: background_color,
                radius: .01 * parseInt(radius, 10),
                mode: parseInt(qr_type, 10),
                label: qr_font,
                fontcolor: qr_font_color,
                image: $("#image-buffers")[0],
                mSize: .01 * parseInt(size, 10)
            });
        });

        $(`.rating_preview`).attr('id');
        var from_$input = $('#input_from').pickadate(),
            from_picker = from_$input.pickadate('picker')

        var to_$input = $('#input_to').pickadate(),
            to_picker = to_$input.pickadate('picker')

        var is_enabled = "{{ $is_enable }}";
        if (is_enabled) {
            $('#business-hours-div').show();
        } else {
            $('#business-hours-div').hide();
        }

        var is_contact_enable = "{{ $is_contact_enable }}";
        if (is_contact_enable) {
            $('#contact-div').show();
            $('#contact-div1').show();
        } else {
            $('#contact-div').hide();
            $('#contact-div1').hide();
        }

        var is_enable_appoinment = "{{ $is_enable_appoinment }}";
        if (is_enable_appoinment) {
            $('#appointment-div').show();
        } else {
            $('#appointment-div').hide();
        }
		
		var is_enable_leadgeneration = "{{ $is_enable_leadgeneration }}";
        if (is_enable_leadgeneration) {
            $('#leadgeneration-div').show();
        } else {
            $('#leadgeneration-div').hide();
        }

        var is_enable_service = "{{ $is_enable_service }}";
        if (is_enable_service) {
            $('#services-div').show();
        } else {
            $('#services-div').hide();
        }

        var is_enable_testimonials = "{{ $is_enable_testimonials }}";
        if (is_enable_testimonials) {
            $('#testimonials-div').show();
        } else {
            $('#testimonials-div').hide();
        }

        var is_enable_sociallinks = "{{ $is_enable_sociallinks }}";
        if (is_enable_sociallinks) {
            $('#social-div').show();

        } else {
            $('#social-div').hide();
        }

        var is_enable_sociallinks = "{{ $is_enable_sociallinks }}";
        if (is_enable_sociallinks) {
            $('#social1-div').show();

        } else {
            $('#social1-div').hide();
        }

        var is_custom_html_enable = "{{ $is_custom_html_enable }}";
        if (is_custom_html_enable) {
            $('.custom_html_text').show();
        } else {
            $('.custom_html_text').hide();
        }

        var is_branding_enable = "{{ $is_branding_enabled }}";
        if (is_branding_enable) {
            $('.branding_text').show();
        } else {
            $('.branding_text').hide();
        }

        var is_enable_gallery = "{{ $is_enable_gallery }}";
        if (is_enable_gallery) {
            $('#gallery-div').show();
        } else {
            $('#gallery-div').hide();
        }

        $(`#makeappointment`).click(function() {
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");

            var name = $(`.app_name`).val();
            var email = $(`.app_email`).val();
            var date = $(`.datepicker_min`).val();
            var phone = $(`.app_phone`).val();
            var time = $(".time").val();
            var business_id = '{{ $business->id }}';

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }
            if (date == "") {
                $(`.span-error-date`).text("*Please choose date");
                $(".close-search").trigger({
                    type: "click"
                });
            } else if (document.querySelectorAll('.time').length < 1 || time == 'Select hour') {
                $(`.span-error-time`).text("*Please choose time");
                $(".close-search").trigger({
                    type: "click"
                });
            } else if (name == "") {
                $(`.span-error-name`).text("*Please enter your name");
            } else if (email == "") {
                $(`.span-error-email`).text("*Please enter your email");
            } else if (phone == "") {
                //alert("DSfgbn");
                $(`.span-error-phone`).text("{{ __('*Please enter your phone no.') }}");
            } else {
                $(`.span-error-date`).text("");
                $(`.span-error-time`).text("");
                $(`.span-error-name`).text("");
                $(`.span-error-email`).text("");
                date = formatDate(date);
                $.ajax({
                    url: '{{ route('appoinment.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
                        "email": email,
                        "phone": phone,
                        "date": date,
                        "time": time,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                        "name": name,
                        "email": email,
                        "date": date,
                        "time": time,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.flag == false) {
                            $(".close-search").trigger({
                                type: "click"
                            });
                            show_toastr('Error', data.msg, 'error');

                        } else {
                            $(".close-search").trigger({
                                type: "click"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                            show_toastr('Success',
                                "{{ __('Thank you for booking an appointment.') }}", 'success');
                        }
                    }
                });
            }
        });

        $('#makecontact').click(function() {
    var connectButton = $(this);
    var name = $('.contact_name').val();
    var email = $('.contact_email').val();
    var phone = $('.contact_phone').val();
    var message = $('.contact_message').val();
    var business_id = '{{ $business->id }}';

    $('.span-error-contactname').text("");
    $('.span-error-contactemail').text("");
    $('.span-error-contactphone').text("");
    $('.span-error-contactmessage').text("");

    if (name == "") {
        $('.span-error-contactname').text("{{ __('*Please enter your name') }}");
    } else if (email == "") {
        $('.span-error-contactemail').text("{{ __('*Please enter your email') }}");
    } else if (phone == "") {
        $('.span-error-contactphone').text("{{ __('*Please enter your phone no.') }}");
    } else if (message == "") {
        $('.span-error-contactmessage').text("{{ __('*Please enter your message.') }}");
    } else {
        $('.span-error-contactname').text("");
        $('.span-error-contactemail').text("");
        $('.span-error-contactphone').text("");
        $('.span-error-contactmessage').text("");

        // Disable the connect button to prevent multiple submissions
        connectButton.prop('disabled', true).text("Submitting...");

        $.ajax({
            url: '{{ route('contacts.store') }}',
            type: 'POST',
            data: {
                "name": name,
                "email": email,
                "phone": phone,
                "message": message,
                "business_id": business_id,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $(".close-search").trigger({
                    type: "click"
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
                show_toastr('Success', "{{ __('Thank you for connecting.') }}", 'success');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors
                console.error(textStatus, errorThrown);
            },
            complete: function() {
                // Re-enable the connect button after the AJAX call is complete
                connectButton.prop('disabled', false).text("{{ __('Connect') }}");
            }
        });
    }
});

		
		$(`#leadcontact1`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name1`).val();
			var campaign_name = $(`.campaign_name1`).val();
			var campaign_id = $(`.campaign_id1`).val();
            var email = $(`.contact_email1`).val();
            var phone = $(`.contact_phone1`).val();
            var message = $(`.contact_message1`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname1`).text("");
			$(`.span-error-campaign_name1`).text("");
            $(`.span-error-contactemail1`).text("");
            $(`.span-error-contactphone1`).text("");
            $(`.span-error-contactmessage1`).text("");

            if (name == "") {
                $(`.span-error-contactname1`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail1`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone1`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage1`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname1`).text("");
                $(`.span-error-contactemail1`).text("");
                $(`.span-error-contactphone1`).text("");
                $(`.span-error-contactmessage1`).text("");
				
				 // Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                $(".close-search").trigger({
                    type: "click"
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
                show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors if any
                console.error(textStatus, errorThrown);
            },
            complete: function() {
                // Re-enable the send button after the AJAX call is complete
                sendButton.prop('disabled', false).text("{{ __('Send') }}");
            }
        });
            }
        });
		
		$(`#leadcontact2`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name2`).val();
			var campaign_name = $(`.campaign_name2`).val();
			var campaign_id = $(`.campaign_id2`).val();
            var email = $(`.contact_email2`).val();
            var phone = $(`.contact_phone2`).val();
            var message = $(`.contact_message2`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname2`).text("");
			$(`.span-error-campaign_name2`).text("");
            $(`.span-error-contactemail2`).text("");
            $(`.span-error-contactphone2`).text("");
            $(`.span-error-contactmessage2`).text("");

            if (name == "") {
                $(`.span-error-contactname2`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail2`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone2`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage2`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname2`).text("");
                $(`.span-error-contactemail2`).text("");
                $(`.span-error-contactphone2`).text("");
                $(`.span-error-contactmessage2`).text("");
				
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact3`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name3`).val();
			var campaign_name = $(`.campaign_name3`).val();
			var campaign_id = $(`.campaign_id3`).val();
            var email = $(`.contact_email3`).val();
            var phone = $(`.contact_phone3`).val();
            var message = $(`.contact_message3`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname3`).text("");
			$(`.span-error-campaign_name3`).text("");
            $(`.span-error-contactemail3`).text("");
            $(`.span-error-contactphone3`).text("");
            $(`.span-error-contactmessage3`).text("");

            if (name == "") {
                $(`.span-error-contactname3`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail3`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone3`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage3`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname3`).text("");
                $(`.span-error-contactemail3`).text("");
                $(`.span-error-contactphone3`).text("");
                $(`.span-error-contactmessage3`).text("");
				
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact4`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name4`).val();
			var campaign_name = $(`.campaign_name4`).val();
			var campaign_id = $(`.campaign_id4`).val();
            var email = $(`.contact_email4`).val();
            var phone = $(`.contact_phone4`).val();
            var message = $(`.contact_message4`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname4`).text("");
			$(`.span-error-campaign_name4`).text("");
            $(`.span-error-contactemail4`).text("");
            $(`.span-error-contactphone4`).text("");
            $(`.span-error-contactmessage4`).text("");

            if (name == "") {
                $(`.span-error-contactname4`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail4`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone4`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage4`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname4`).text("");
                $(`.span-error-contactemail4`).text("");
                $(`.span-error-contactphone4`).text("");
                $(`.span-error-contactmessage4`).text("");
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		$(`#leadcontact5`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name5`).val();
			var campaign_name = $(`.campaign_name5`).val();
			var campaign_id = $(`.campaign_id5`).val();
            var email = $(`.contact_email5`).val();
            var phone = $(`.contact_phone5`).val();
            var message = $(`.contact_message5`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname5`).text("");
			$(`.span-error-campaign_name5`).text("");
            $(`.span-error-contactemail5`).text("");
            $(`.span-error-contactphone5`).text("");
            $(`.span-error-contactmessage5`).text("");

            if (name == "") {
                $(`.span-error-contactname5`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail5`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone5`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage5`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname5`).text("");
                $(`.span-error-contactemail5`).text("");
                $(`.span-error-contactphone5`).text("");
                $(`.span-error-contactmessage5`).text("");
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact6`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name6`).val();
			var campaign_name = $(`.campaign_name6`).val();
			var campaign_id = $(`.campaign_id6`).val();
            var email = $(`.contact_email6`).val();
            var phone = $(`.contact_phone6`).val();
            var message = $(`.contact_message6`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname6`).text("");
			$(`.span-error-campaign_name6`).text("");
            $(`.span-error-contactemail6`).text("");
            $(`.span-error-contactphone6`).text("");
            $(`.span-error-contactmessage6`).text("");

            if (name == "") {
                $(`.span-error-contactname6`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail6`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone6`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage6`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname6`).text("");
                $(`.span-error-contactemail6`).text("");
                $(`.span-error-contactphone6`).text("");
                $(`.span-error-contactmessage6`).text("");
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact7`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name7`).val();
			var campaign_name = $(`.campaign_name7`).val();
			var campaign_id = $(`.campaign_id7`).val();
            var email = $(`.contact_email7`).val();
            var phone = $(`.contact_phone7`).val();
            var message = $(`.contact_message7`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname7`).text("");
			$(`.span-error-campaign_name7`).text("");
            $(`.span-error-contactemail7`).text("");
            $(`.span-error-contactphone7`).text("");
            $(`.span-error-contactmessage7`).text("");

            if (name == "") {
                $(`.span-error-contactname7`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail7`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone7`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage7`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname7`).text("");
                $(`.span-error-contactemail7`).text("");
                $(`.span-error-contactphone7`).text("");
                $(`.span-error-contactmessage7`).text("");
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact8`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name8`).val();
			var campaign_name = $(`.campaign_name8`).val();
			var campaign_id = $(`.campaign_id8`).val();
            var email = $(`.contact_email8`).val();
            var phone = $(`.contact_phone8`).val();
            var message = $(`.contact_message8`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname8`).text("");
			$(`.span-error-campaign_name8`).text("");
            $(`.span-error-contactemail8`).text("");
            $(`.span-error-contactphone8`).text("");
            $(`.span-error-contactmessage8`).text("");

            if (name == "") {
                $(`.span-error-contactname8`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail8`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone8`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage8`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname8`).text("");
                $(`.span-error-contactemail8`).text("");
                $(`.span-error-contactphone8`).text("");
                $(`.span-error-contactmessage8`).text("");
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact9`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name9`).val();
			var campaign_name = $(`.campaign_name9`).val();
			var campaign_id = $(`.campaign_id9`).val();
            var email = $(`.contact_email9`).val();
            var phone = $(`.contact_phone9`).val();
            var message = $(`.contact_message9`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname9`).text("");
			$(`.span-error-campaign_name9`).text("");
            $(`.span-error-contactemail9`).text("");
            $(`.span-error-contactphone9`).text("");
            $(`.span-error-contactmessage9`).text("");

            if (name == "") {
                $(`.span-error-contactname9`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail9`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone9`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage9`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname9`).text("");
                $(`.span-error-contactemail9`).text("");
                $(`.span-error-contactphone9`).text("");
                $(`.span-error-contactmessage9`).text("");
				// Disable the send button to prevent multiple submissions
					sendButton.prop('disabled', true).text("Submitting...");
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact10`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name10`).val();
			var campaign_id = $(`.campaign_id10`).val();
			var campaign_name = $(`.campaign_name10`).val();
            var email = $(`.contact_email10`).val();
            var phone = $(`.contact_phone10`).val();
            var message = $(`.contact_message10`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname10`).text("");
			$(`.span-error-campaign_name10`).text("");
            $(`.span-error-contactemail10`).text("");
            $(`.span-error-contactphone10`).text("");
            $(`.span-error-contactmessage10`).text("");

            if (name == "") {
                $(`.span-error-contactname10`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail10`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone10`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage10`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname10`).text("");
                $(`.span-error-contactemail10`).text("");
                $(`.span-error-contactphone10`).text("");
                $(`.span-error-contactmessage10`).text("");
			
					
                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact11`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name11`).val();
			var campaign_name = $(`.campaign_name11`).val();
			var campaign_id = $(`.campaign_id11`).val();
            var email = $(`.contact_email11`).val();
            var phone = $(`.contact_phone11`).val();
            var message = $(`.contact_message11`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname11`).text("");
			$(`.span-error-campaign_name11`).text("");
            $(`.span-error-contactemail11`).text("");
            $(`.span-error-contactphone11`).text("");
            $(`.span-error-contactmessage11`).text("");

            if (name == "") {
                $(`.span-error-contactname11`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail11`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone11`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage11`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname11`).text("");
                $(`.span-error-contactemail11`).text("");
                $(`.span-error-contactphone11`).text("");
                $(`.span-error-contactmessage11`).text("");
				
				sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact12`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name12`).val();
			var campaign_name = $(`.campaign_name12`).val();
			var campaign_id = $(`.campaign_id12`).val();
            var email = $(`.contact_email12`).val();
            var phone = $(`.contact_phone12`).val();
            var message = $(`.contact_message12`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname12`).text("");
			$(`.span-error-campaign_name12`).text("");
            $(`.span-error-contactemail12`).text("");
            $(`.span-error-contactphone12`).text("");
            $(`.span-error-contactmessage12`).text("");

            if (name == "") {
                $(`.span-error-contactname12`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail12`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone12`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage12`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname12`).text("");
                $(`.span-error-contactemail12`).text("");
                $(`.span-error-contactphone12`).text("");
                $(`.span-error-contactmessage12`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact13`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name13`).val();
			var campaign_name = $(`.campaign_name13`).val();
			var campaign_id = $(`.campaign_id13`).val();
            var email = $(`.contact_email13`).val();
            var phone = $(`.contact_phone13`).val();
            var message = $(`.contact_message13`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname13`).text("");
			$(`.span-error-campaign_name13`).text("");
            $(`.span-error-contactemail13`).text("");
            $(`.span-error-contactphone13`).text("");
            $(`.span-error-contactmessage13`).text("");

            if (name == "") {
                $(`.span-error-contactname13`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail13`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone13`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage13`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname13`).text("");
                $(`.span-error-contactemail13`).text("");
                $(`.span-error-contactphone13`).text("");
                $(`.span-error-contactmessage13`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact14`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name14`).val();
			var campaign_name = $(`.campaign_name14`).val();
			var campaign_id = $(`.campaign_id14`).val();
            var email = $(`.contact_email14`).val();
            var phone = $(`.contact_phone14`).val();
            var message = $(`.contact_message14`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname14`).text("");
			$(`.span-error-campaign_name14`).text("");
            $(`.span-error-contactemail14`).text("");
            $(`.span-error-contactphone14`).text("");
            $(`.span-error-contactmessage14`).text("");

            if (name == "") {
                $(`.span-error-contactname14`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail14`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone14`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage14`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname14`).text("");
                $(`.span-error-contactemail14`).text("");
                $(`.span-error-contactphone14`).text("");
                $(`.span-error-contactmessage14`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact15`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name15`).val();
			var campaign_name = $(`.campaign_name15`).val();
			var campaign_id = $(`.campaign_id15`).val();
            var email = $(`.contact_email15`).val();
            var phone = $(`.contact_phone15`).val();
            var message = $(`.contact_message15`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname15`).text("");
			$(`.span-error-campaign_name15`).text("");
            $(`.span-error-contactemail15`).text("");
            $(`.span-error-contactphone15`).text("");
            $(`.span-error-contactmessage15`).text("");

            if (name == "") {
                $(`.span-error-contactname15`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail15`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone15`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage15`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname15`).text("");
                $(`.span-error-contactemail15`).text("");
                $(`.span-error-contactphone15`).text("");
                $(`.span-error-contactmessage15`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact16`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name16`).val();
			var campaign_name = $(`.campaign_name16`).val();
			var campaign_id = $(`.campaign_id16`).val();
            var email = $(`.contact_email16`).val();
            var phone = $(`.contact_phone16`).val();
            var message = $(`.contact_message16`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname16`).text("");
			$(`.span-error-campaign_name16`).text("");
            $(`.span-error-contactemail16`).text("");
            $(`.span-error-contactphone16`).text("");
            $(`.span-error-contactmessage16`).text("");

            if (name == "") {
                $(`.span-error-contactname16`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail16`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone16`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage16`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname16`).text("");
                $(`.span-error-contactemail16`).text("");
                $(`.span-error-contactphone16`).text("");
                $(`.span-error-contactmessage16`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact17`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name17`).val();
			var campaign_name = $(`.campaign_name17`).val();
			var campaign_id = $(`.campaign_id17`).val();
            var email = $(`.contact_email17`).val();
            var phone = $(`.contact_phone17`).val();
            var message = $(`.contact_message17`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname17`).text("");
			$(`.span-error-campaign_name17`).text("");
            $(`.span-error-contactemail17`).text("");
            $(`.span-error-contactphone17`).text("");
            $(`.span-error-contactmessage17`).text("");

            if (name == "") {
                $(`.span-error-contactname17`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail17`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone17`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage17`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname17`).text("");
                $(`.span-error-contactemail17`).text("");
                $(`.span-error-contactphone17`).text("");
                $(`.span-error-contactmessage17`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact18`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name18`).val();
			var campaign_name = $(`.campaign_name18`).val();
			var campaign_id = $(`.campaign_id18`).val();
            var email = $(`.contact_email18`).val();
            var phone = $(`.contact_phone18`).val();
            var message = $(`.contact_message18`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname18`).text("");
			$(`.span-error-campaign_name18`).text("");
            $(`.span-error-contactemail18`).text("");
            $(`.span-error-contactphone18`).text("");
            $(`.span-error-contactmessage18`).text("");

            if (name == "") {
                $(`.span-error-contactname18`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail18`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone18`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage18`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname18`).text("");
                $(`.span-error-contactemail18`).text("");
                $(`.span-error-contactphone18`).text("");
                $(`.span-error-contactmessage18`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact19`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name19`).val();
			var campaign_name = $(`.campaign_name19`).val();
			var campaign_id = $(`.campaign_id19`).val();
            var email = $(`.contact_email19`).val();
            var phone = $(`.contact_phone19`).val();
            var message = $(`.contact_message19`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname19`).text("");
			$(`.span-error-campaign_name19`).text("");
            $(`.span-error-contactemail19`).text("");
            $(`.span-error-contactphone19`).text("");
            $(`.span-error-contactmessage19`).text("");

            if (name == "") {
                $(`.span-error-contactname19`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail19`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone19`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage19`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname19`).text("");
                $(`.span-error-contactemail19`).text("");
                $(`.span-error-contactphone19`).text("");
                $(`.span-error-contactmessage19`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
		
		
		$(`#leadcontact20`).click(function() {
			var sendButton = $(this);
            var name = $(`.contact_name20`).val();
			var campaign_name = $(`.campaign_name20`).val();
			var campaign_id = $(`.campaign_id20`).val();
            var email = $(`.contact_email20`).val();
            var phone = $(`.contact_phone20`).val();
            var message = $(`.contact_message20`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname20`).text("");
			$(`.span-error-campaign_name20`).text("");
            $(`.span-error-contactemail20`).text("");
            $(`.span-error-contactphone20`).text("");
            $(`.span-error-contactmessage20`).text("");

            if (name == "") {
                $(`.span-error-contactname20`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-contactemail20`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-contactphone20`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage20`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname20`).text("");
                $(`.span-error-contactemail20`).text("");
                $(`.span-error-contactphone20`).text("");
                $(`.span-error-contactmessage20`).text("");

                sendButton.prop('disabled', true).text("Submitting...");
				
                $.ajax({
                    url: '{{ route('leadcontact.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
						$(".close-search").trigger({
							type: "click"
						});
						setTimeout(function() {
							location.reload();
						}, 1500);
						show_toastr('Success', "{{ __('Saved Successfully.') }}", 'success');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// Handle errors if any
						console.error(textStatus, errorThrown);
					},
					complete: function() {
						// Re-enable the send button after the AJAX call is complete
						sendButton.prop('disabled', false).text("{{ __('Send') }}");
					}
				});
            }
        });
    </script>
    <!-- Google Analytic Code -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $business->google_analytic }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ $business->google_analytic }}');
    </script>
    @if (isset($is_slug))
        <script>
            function show_toastr(title, message, type) {
                var o, i;
                var icon = '';
                var cls = '';

                if (type == 'success') {
                    icon = 'ti ti-check-circle';
                    cls = 'success';
                } else {
                    icon = 'ti ti-times-circle';
                    cls = 'danger';
                }

                $.notify({
                    icon: icon,
                    title: " " + title,
                    message: message,
                    url: ""
                }, {
                    element: "body",
                    type: cls,
                    allow_dismiss: !0,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 15,
                        y: 15
                    },
                    spacing: 80,
                    z_index: 1080,
                    delay: 2500,
                    timer: 2000,
                    url_target: "_blank",
                    mouse_over: !1,
                    animate: {
                        enter: o,
                        exit: i
                    },
                    template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                });
            }
            if ($(".datepicker").length) {
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    format: 'yyyy-mm-dd',
                });
            }
        </script>
    
        @if ($message = Session::get('success'))
            <script>
                show_toastr('Success', '{!! $message !!}', 'success');
            </script>
        @endif
        @if ($message = Session::get('error'))
            <script>
                show_toastr('Error', '{!! $message !!}', 'error');
            </script>
        @endif
    @endif
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $business->fbpixel_code }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript={{ $business->fbpixel_code }}" /></noscript>

    <!-- Custom Code -->
    <script type="text/javascript">
        {!! $business->customjs !!}
    </script>
    @if (isset($is_pdf))
        @include('business.script');
    @endif
    @if (isset($is_slug))
        @if ($is_gdpr_enabled)
            <script src="{{ asset('js/cookieconsent.js') }}"></script>
            <script>
                let myVar = {!! json_encode($a) !!};
                let data = JSON.parse(myVar);
                let language_code = document.documentElement.getAttribute('lang');
                let languages = {};
                languages[language_code] = {
                    consent_modal: {
                        title: 'hello',
                        description: 'description',
                        primary_btn: {
                            text: 'primary_btn text',
                            role: 'accept_all'
                        },
                        secondary_btn: {
                            text: 'secondary_btn text',
                            role: 'accept_necessary'
                        }
                    },
                    settings_modal: {
                        title: 'settings_modal',
                        save_settings_btn: 'save_settings_btn',
                        accept_all_btn: 'accept_all_btn',
                        reject_all_btn: 'reject_all_btn',
                        close_btn_label: 'close_btn_label',
                        blocks: [{
                                title: 'block title',
                                description: 'block description'
                            },

                            {
                                title: 'title',
                                description: 'description',
                                toggle: {
                                    value: 'necessary',
                                    enabled: true,
                                    readonly: false
                                }
                            },
                        ]
                    }
                };
            </script>
            <script>
                function setCookie(cname, cvalue, exdays) {
                    const d = new Date();
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    let expires = "expires=" + d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }

                function getCookie(cname) {
                    let name = cname + "=";
                    let decodedCookie = decodeURIComponent(document.cookie);
                    let ca = decodedCookie.split(';');
                    for (let i = 0; i < ca.length; i++) {
                        let c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }


                // obtain plugin
                var cc = initCookieConsent();
                // run plugin with your configuration
                cc.run({
                    current_lang: 'en',
                    autoclear_cookies: true, // default: false
                    page_scripts: true,
                    // ...
                    gui_options: {
                        consent_modal: {
                            layout: 'cloud', // box/cloud/bar
                            position: 'bottom center', // bottom/middle/top + left/right/center
                            transition: 'slide', // zoom/slide
                            swap_buttons: false // enable to invert buttons
                        },
                        settings_modal: {
                            layout: 'box', // box/bar
                            // position: 'left',           // left/right
                            transition: 'slide' // zoom/slide
                        }
                    },

                    onChange: function(cookie, changed_preferences) {},
                    onAccept: function(cookie) {
                        if (!getCookie('cookie_consent_logged')) {
                            var cookie = cookie.level;
                            var slug = '{{ $business->slug }}';
                            $.ajax({
                                url: '{{ route('card-cookie-consent') }}',
                                datType: 'json',
                                data: {
                                    cookie: cookie,
                                    slug: slug,
                                },
                            })
                            setCookie('cookie_consent_logged', '1', 182, '/');
                        }
                    },
                    languages: {
                        'en': {
                            consent_modal: {
                                title: data.cookie_title,
                                description: data.cookie_description + ' ' +
                                    '<button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                                primary_btn: {
                                    text: "{{ __('Accept all') }}",
                                    role: 'accept_all' // 'accept_selected' or 'accept_all'
                                },
                                secondary_btn: {
                                    text: "{{ __('Reject all') }}",
                                    role: 'accept_necessary' // 'settings' or 'accept_necessary'
                                },
                            },
                            settings_modal: {
                                title: "{{ __('Cookie preferences') }}",
                                save_settings_btn: "{{ __('Save settings') }}",
                                accept_all_btn: "{{ __('Accept all') }}",
                                reject_all_btn: "{{ __('Reject all') }}",
                                close_btn_label: "{{ __('Close') }}",
                                cookie_table_headers: [{
                                        col1: 'Name'
                                    },
                                    {
                                        col2: 'Domain'
                                    },
                                    {
                                        col3: 'Expiration'
                                    },
                                    {
                                        col4: 'Description'
                                    }
                                ],
                                blocks: [{
                                    title: data.cookie_title + ' ' + '📢',
                                    description: data.cookie_description,
                                }, {
                                    title: data.strictly_cookie_title,
                                    description: data.strictly_cookie_description,
                                    toggle: {
                                        value: 'necessary',
                                        enabled: true,
                                        readonly: true // cookie categories with readonly=true are all treated as "necessary cookies"
                                    }
                                }, {
                                    title: "{{ __('More information') }}",
                                    description: data.more_information_description + ' ' +
                                        '<a class="cc-link" href="' + data.contactus_url + '">Contact Us</a>.',
                                }]
                            }
                        }
                    }

                });
            </script>
        @endif
    @endif

    <!--scripts end here-->
</body>

</html>
