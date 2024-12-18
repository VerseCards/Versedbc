@php
    $social_no = 1;
    $appointment_no = 0;
    $service_row_no = 0;
    $testimonials_row_no = 0;
    $gallery_row_no = 0;
    
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
    
    if (!is_null($contactinfo) && !is_null($contactinfo)) {
        $contactinfo['is_enabled'] == '1' ? ($is_contact_enable = true) : ($is_contact_enable = false);
    }
    
    if (!is_null($business_hours) && !is_null($businesshours)) {
        $businesshours['is_enabled'] == '1' ? ($is_enable = true) : ($is_enable = false);
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
    
    if (!is_null($gallery_contents) && !is_null($gallery)) {
        $gallery['is_enabled'] == '1' ? ($is_enable_gallery = true) : ($is_enable_gallery = false);
    }
    
    if (!is_null($custom_html) && !is_null($customhtml)) {
        $customhtml->is_custom_html_enabled == '1' ? ($is_custom_html_enable = true) : ($is_custom_html_enable = false);
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
<html lang="en" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="{{ $business->title }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="HandheldFriendly" content="True">

    <title>{{ $business->title }}</title>
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
    <link rel="stylesheet" href="{{ asset('custom/theme4/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/theme4/fonts/stylesheet.css') }}">
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('custom/theme4/css/rtl-main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('custom/theme4/css/rtl-responsive.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('custom/theme4/css/main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('custom/theme4/css/responsive.css') }}">
    @endif
    @if (isset($is_slug))
        <link rel='stylesheet' href='{{ asset('css/cookieconsent.css') }}' media="screen" />
        <style type="text/css">
            {{ $business->customcss }}
        </style>
    @endif
    @if ($business->google_fonts != 'Default' && isset($business->google_fonts))
        <style>
            @import url('{{ \App\Models\Utility::getvalueoffont($business->google_fonts)['link'] }}');

            :root {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }
        </style>
    @endif
    {{-- pwa customer app --}}
    <meta name="mobile-wep-app-capable" content="yes">
    <meta name="apple-mobile-wep-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <link rel="apple-touch-icon"
        href="{{ asset(Storage::url('uploads/logo/') . (!empty($setting->value) ? $setting->value : 'favicon.png')) }}" />

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
    <div class="{{ \App\Models\Utility::themeOne()['theme4'][$business->theme_color]['theme_name'] }}"
        id="view_theme14">
        <main id="boxes">
            <div class="card-wrapper">
                <div class="bussiness-card">
                    <div class="bussiness-card-body" style="border-radius: 127px 136px 0 63px">
                        <section class="profile-section" style="padding-bottom: 45px;border-radius: 127px 136px 0 63px;">
                            <div class="profile-cover" style="border-radius: 127px 136px 0 63px">
                                <img src="{{ isset($business->banner) && !empty($business->banner) ? $banner . '/' . $business->banner : asset('custom/img/placeholder-image.jpg') }}"
                                    id="banner_preview" alt="fs" style="border-radius: 30px 80px 0 63px">
                            </div>
                            <div class="profile-content">
                                <div class="user-profile" style="margin-top: -35px">
                                    <div class="user-avatar">
                                        <img id="business_logo_preview"
                                            src="{{ isset($business->logo) && !empty($business->logo) ? $logo . '/' . $business->logo : asset('custom/img/logo-placeholder-image-2.png') }}"
                                            alt="">
                                    </div>
                                    <div class="user-name">
                                        <h3 id="{{ $stringid . '_title' }}_preview">{{ $business->title }}</h3>
                                        <p id="{{ $stringid . '_designation' }}_preview">{{ $business->designation }}
                                        </p>
                                        <span id="{{ $stringid . '_subtitle' }}_preview"
                                            class="subtitle">{{ $business->sub_title }}</span>
                                    </div>
                                </div>
                                <div class="text-left desc-wrapper">
                                    <p id="{{ $stringid . '_desc' }}_preview">{{ $business->description }}
                                    </p>
                                </div>

                            </div>
                        </section>
                        @php $j = 1; @endphp
                        @foreach ($card_theme->order as $order_key => $order_value)
                            @if ($j == $order_value)
                                @if ($order_key == 'gallery')
                                    <section class="gallery-section" id="gallery-div">
                                        <div class="section-title text-center">
                                            <h2>{{ __('Gallery') }}</h2>
                                        </div>
                                        <div id="inputrow_gallery_preview">
                                            @php $image_count = 0; @endphp
                                            @if (isset($is_pdf))
                                                <div class="gallery-cards">
                                                    <div class="row">
                                                        @if (!is_null($gallery_contents) && !is_null($gallery))
                                                            @foreach ($gallery_contents as $key => $gallery_content)
                                                                @if (isset($gallery_content->type))
                                                                    @if ($gallery_content->type == 'video')
                                                                    @elseif($gallery_content->type == 'image')
                                                                        <div class="gallery-itm  col-12">
                                                                            <div class="gallery-media">
                                                                                <a href="javascript:;" id="imagepopup"
                                                                                    tabindex="0" class="imagepopup">
                                                                                    <img src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                        alt="images"
                                                                                        class="imageresource">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                @php
                                                                    $image_count++;
                                                                    $gallery_row_no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            @else
                                                <div class="gallery-slider">
                                                    @if (!is_null($gallery_contents) && !is_null($gallery))
                                                        @foreach ($gallery_contents as $key => $gallery_content)
                                                            <div class="gallery-itm"
                                                                id="gallery_{{ $gallery_row_no }}">
                                                                <div class="gallery-media">
                                                                    @if (isset($gallery_content->type))
                                                                        @if ($gallery_content->type == 'video')
                                                                            <a href="javascript:;" tabindex="0"
                                                                                class="videopop play-btn">

                                                                                <video loop  controls="true">
                                                                                    <source class="videoresource"
                                                                                        src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'image')
                                                                            <a href="javascript:;" tabindex="0"
                                                                                class="imagepopup">

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
                                                                                    tabindex="0"
                                                                                    class="videopop1 play-btn">
                                                                                    <video loop controls="true"
                                                                                        poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                        <source class="videoresource1"
                                                                                            src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? 'https://www.youtube.com/embed/' . $video_url : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            @else
                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0"
                                                                                    class="videopop1 play-btn">
                                                                                    <video loop controls="true"
                                                                                        poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                        <source class="videoresource1"
                                                                                            src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            @endif
                                                                        @elseif($gallery_content->type == 'custom_image_link')
                                                                            <a href="javascript:;" tabindex="0"
                                                                                class="imagepopup1">

                                                                                <img class="imageresource1"
                                                                                    src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images" id="upload_image">
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </section>
                                @endif
                                
                                
                                @if ($order_key == 'contact_info')
                                    <section class="contact-section" id="contact-div">
                                       
                                        <ul id="inputrow_contact_preview">
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
                                                            @php $href = $val1 @endphp
                                                        @endif
                                                        @if ($key1 != 'id')
                                                            <li id="contact_{{ $loop->parent->index + 1 }}" style="border: 1px solid #ffffff3d;justify-content: space-evenly;border-radius: 25px;padding: 15px;margin-top:20px">
                                                                @if ($key1 == 'Address')
                                                                    @foreach ($val1 as $key2 => $val2)
                                                                        @if ($key2 == 'Address_url')
                                                                            @php $href = $val2; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                    <a href="{{ $href }}" style="justify-content: space-between;margin-top: 0">
                                                                        <span>
                                                                            <img src="{{ asset('custom/theme4/icon/' . $color . '/' . strtolower($key1) . '.svg') }}"
                                                                                class="img-fluid">
                                                                        </span>
                                                                        @foreach ($val1 as $key2 => $val2)
                                                                            @if ($key2 == 'Address')
                                                                                <span
                                                                                    id="{{ $key1 . '_' . $no }}_preview">
                                                                                    {{ $val2 }}
                                                                                </span>
                                                                            @endif
                                                                        @endforeach
                                                                    </a>
                                                                @else
                                                                    @if ($key1 == 'Whatsapp')
                                                                        <a href="{{ url('https://wa.me/' . $href) }}"
                                                                            target="_blank" style="justify-content: space-between;margin-top: 0;">
                                                                        @else
                                                                            <a href="{{ $href }}" style="justify-content: space-between;margin-top: 0">
                                                                    @endif
                                                                    <span>
                                                                        <img src="{{ asset('custom/theme4/icon/' . $color . '/' . strtolower($key1) . '.svg') }}"
                                                                            class="img-fluid">
                                                                    </span>
                                                                    <span id="{{ $key1 . '_' . $no }}_preview" style="color:#ffffff">
                                                                        {{ Str::limit($val1, 18) }}</span>
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endif
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach
                                                @endforeach
												<li 
                                                                   style="border: 1px solid #ffffff3d;justify-content: space-evenly;border-radius: 25px;padding: 15px;margin-top:20px">
																	<a href="javascript:void(0)"
                                                    class="btn make-contact-modal-toggle" style="justify-content: space-between;margin-top: 0">
                                                                        <span>
                                                                            <img src="{{ asset('custom/theme4/icon/' . $color . '/phone.svg') }}"
                                                                                class="img-fluid">
                                                                        </span>
                                                                                    <span>
                                                                                        Connect With Me
                                                                                    </span> 
                                                                        </a>
																</li>
																<li 
                                                                   style="border: 1px solid #ffffff3d;justify-content: space-evenly;border-radius: 25px;padding: 15px;margin-top:20px">
																	<a href="javascript:void(0)"
                                                    class="btn share-modal-toggle" style="justify-content: space-between;margin-top: 0">
                                                                        <span>
                                                                            <img src="{{ asset('custom/theme4/icon/' . $color . '/phone.svg') }}"
                                                                                class="img-fluid">
                                                                        </span>
                                                                                    <span>
                                                                                       View QR Code
                                                                                    </span> 
                                                                        </a>
																</li>
																
                                            @endif
                                        </ul>
									<section id = "leadgeneration-div" >
										<div class="container">
										
										<div class="more-btn" >
											
												@foreach ($leadGeneration_content  as $leadgen) 
												<div style="border: 1px solid #ffffff3d;justify-content: space-evenly;border-radius: 25px;padding: 15px;margin-top:20px">
													<a href="javascript:;" class="btn make-contact-modal-toggle{{$leadgen->id}}" tabindex="0" style="width:100%; margin-top: 15px; border-radius: 25px;height: 40px; justify-content: flex-end;font-size: 18px;">
														
														&nbsp;
														{{ __($leadgen->btitle) }}
													</a>
												</div>
												@endforeach

											</div>
										</div>
                                    </section>
                                @endif
                                
                                
                                @if ($order_key == 'social')
                                    <section class="social" id="social-div">
                                        <div style="border: 1px solid #ffffff3d;margin-top: 40px;padding: 30px;border-radius: 25px; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;">
                                        <ul class="social-list" id="inputrow_socials_preview">
                                            @if (!is_null($social_content) && !is_null($sociallinks))
                                                @foreach ($social_content as $social_key => $social_val)
                                                    @foreach ($social_val as $social_key1 => $social_val1)
                                                        @if ($social_key1 != 'id')
                                                            <li id="socials_{{ $loop->parent->index + 1 }}">
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
                                                                    @php
                                                                        $social_links = url($social_val1);
                                                                    @endphp
                                                                @endif
                                                                <a href="{{ $social_links }}" target="_blank"
                                                                    id="{{ 'social_link_' . $social_no . '_href_preview' }}">
                                                                    <img src="{{ asset('custom/theme4/icon/social/' . strtolower($social_key1) . '.svg') }}"
                                                                        alt="social" class="img-fluid">
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @php
                                                            $social_no++;
                                                        @endphp
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </ul>
									</div>
										
                                    </section>
                                @endif

                                @php $j = $j + 1; @endphp
                            @endif
                        @endforeach

                        @if ($is_branding_enabled)
                            <div class="copy-right is_branding_enable" id="is_branding_enabled" style="margin-top: 50px;background: #00000000;">
                                <p id="{{ $stringid . '_branding' }}_preview" style="color: white;">{{ $business->branding_text }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <img src="{{ isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : '' }}" id="image-buffers"
                style="display: none">
        </main>
        <div id="previewImage"> </div>
        <a id="download" href="#" class="font-lg download mr-3 text-white">
            <i class="fas fa-download"></i>
        </a>
        <!-- Share card popup -->
        <div class="theme-modal share-card">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close share-modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title">{{ __('Scan QR Code') }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="qrcode-wrapper">
                            <div class="shareqrcode"></div>
                        </div>
                      
                        </p>

                        <p>{{ __('') }}</p>
                        
                    </div>
                </div>
            </div>
        </div>
		
		<div class="add-to-contact-wrapper " style="position: fixed;bottom: 10px;left: 50%;transform: translateX(-50%);z-index: 999999">
        <a href="{{ route('bussiness.save', $business->slug) }}" class="btn add-to-contact-btn add-to-contact-botton" style="font-size: 16px; padding: 15px 21px;background-color: var(--black);border: 1px solid var(--contact);"><i class="fa fa-address-card"></i>&nbsp; Add to Contact</a>
    </div>
        <!-- appointment popup -->
        <div class="theme-modal appointment-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close close-search1 appointment-modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title">{{ __('Make Appointment') }}</h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('Name:') }}</label>
                                <input type="text" name="name" class="app_name"
                                    placeholder="{{ __('Enter your name') }}">
                                <span class="text-danger  h6 span-error-name"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Email:') }}</label>
                                <input type="email" name="email" class="app_email"
                                    placeholder="{{ __('Enter your email') }}">
                                <span class="text-danger  h6 span-error-email"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Phone:') }}</label>
                                <input type="tel" name="phone" class="app_phone"
                                    placeholder="{{ __('Enter your phone no') }}">
                                <span class="text-danger  h6 span-error-phone"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary appointment-modal-toggle"
                                type="button">{{ __('Close') }}</button>
                            <button class="btn-secondary" id="makeappointment"
                                type="button">{{ __('Make Appointment') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Make Contact Popup -->
        <div class="theme-modal contact-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close make-contact-modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title">{{ __('Connect With Me') }}</h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('Name:') }}</label>
                                <input type="text" name="name" class="contact_name"
                                    placeholder="{{ __('Enter your name') }}">
                                <span class="text-danger  h6 span-error-contactname"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Email:') }}</label>
                                <input type="email" name="email" class="contact_email"
                                    placeholder="{{ __('Enter your email') }}">
                                <span class="text-danger  h6 span-error-contactemail"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Phone:') }}</label>
                                <input type="tel" name="phone" class="contact_phone"
                                    placeholder="{{ __('Enter your phone no') }}">
                                <span class="text-danger  h6 span-error-contactphone"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Message:') }}</label>
                                <textarea name="message" class="contact_message" cols="30" rows="5"></textarea>
                                <span class="text-danger  h6 span-error-contactmessage"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary make-contact-modal-toggle"
                                type="button">{{ __('Close') }}</button>
                            <button class="btn-secondary" id="makecontact"
                                type="button">{{ __('Connect') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		@foreach ($leadGeneration_content  as $leadgen) 
		<div class="theme-modal{{$leadgen->id}} contact-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close make-contact-modal-toggle{{$leadgen->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title">{{__($leadgen->title) }}</h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('Name:') }}</label>
                                <input type="text" name="name{{$leadgen->id}}" class="contact_name{{$leadgen->id}}"
                                    placeholder="{{ __('Enter your name') }}" style="border-radius:25px">
                                <span class="text-danger  h6 span-error-contactname"></span>
								<input type="hidden" name="campaign_name{{$leadgen->id}}" class="form-control campaign_name{{$leadgen->id}}" value = "{{$leadgen->title}}">
								<input type="hidden" name="campaign_id{{$leadgen->id}}" class="form-control campaign_id{{$leadgen->id}}" value = "{{$leadgen->id}}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Email:') }}</label>
                                <input type="email" name="email{{$leadgen->id}}" class="contact_email{{$leadgen->id}}"
                                    placeholder="{{ __('Enter your email') }}" style="border-radius:25px">
                                <span class="text-danger  h6 span-error-contactemail"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Phone:') }}</label>
                                <input type="tel" name="phone{{$leadgen->id}}" class="contact_phone{{$leadgen->id}}"
                                    placeholder="{{ __('Enter your phone no') }}" style="border-radius:25px">
                                <span class="text-danger  h6 span-error-contactphone"></span>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Additional Info:') }}</label>
                                <textarea name="message{{$leadgen->id}}" class="contact_message{{$leadgen->id}}" cols="30" rows="5" style="border-radius:25px"></textarea>
                                <span class="text-danger  h6 span-error-contactmessage"></span>
                            </div>
                        </div>
                        <div class="modal-footer"style="flex-direction: column;">
                            <button class="btn-secondary d-none make-contact-modal-toggle{{$leadgen->id}}"
                                type="button" style="display:none">{{ __('Cancel') }}</button>
                            <button class="btn-secondary" id="leadcontact{{$leadgen->id}}"
                                type="button">{{ __('Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		@endforeach
		
        {{-- Password modal --}}
        <div class="theme-modal" id="passwordmodel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">{{ __('Password') }}</h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('Password:') }}</label>
                                <input type="password" name="Password" class="password_val"
                                    placeholder="{{ __('Enter password') }}">
                                <span class="text-danger h6 span-error-password"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary password-submit"
                                type="button">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End password modal --}}
        {{-- Image modal --}}
        <div class="theme-modal" id="gallerymodel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close close-model">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title">{{ __('Gallary') }}</h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('Image preview:') }}</label>
                                <img src="" class="imagepreview" style="width: 500px; height: 300px;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary close-model" type="button">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End image modal --}}
        {{-- Video modal --}}
        <div class="theme-modal" id="videomodel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close close-model1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title">{{ __('Gallary') }}</h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('Video preview:') }}</label>
                                <iframe width="100%" height="360" class="videopreview" src=""
                                    frameborder="0" allowfullscreen ></iframe>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary close-model1" type="button">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End video modal --}}
        {{-- All Model end here --}}
    </div>
    <script src="{{ asset('custom/theme4/js/jquery.min.js') }}"></script>
    <script src="{{ asset('custom/theme4/js/slick.min.js') }}" defer="defer"></script>
    @if ($SITE_RTL == 'on')
        <script src="{{ asset('custom/theme4/js/rtl-custom.js') }}" defer="defer"></script>
    @else
        <script src="{{ asset('custom/theme4/js/custom.js') }}" defer="defer"></script>
    @endif
    <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.date.js"></script>
    <script src="{{ asset('custom/js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.min.js') }}"></script>
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
                'rgb(0 0 0 / 50%)'
            ) // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".videopop1").on("click", function() {
            var videosrc1 = $(this).children('video').children(".videoresource1").attr("src");
            $('.videopreview').attr('src',
                videosrc1); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                'rgb(0 0 0 / 50%)'
            ) // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
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
                            $('#passwordmodel').css("background", '')
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


        function downloadURI(uri, name) {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            R
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            delete link;
        };


        $(document).ready(function() {
            $(".emojiarea").emojioneArea();
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");
            $(`.span-error-contactname`).text("");
            $(`.span-error-contactemail`).text("");
            $(`.span-error-contactphone`).text("");
            $(`.span-error-contactmessage`).text("");


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
        } else {
            $('#contact-div').hide();
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

        var is_enable_gallery = "{{ $is_enable_gallery }}";
        if (is_enable_gallery) {
            $('#gallery-div').show();
        } else {
            $('#gallery-div').hide();
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
        $(`#makeappointment`).click(function() {
            var name = $(`.app_name`).val();
            var email = $(`.app_email`).val();
            var date = $(`.datepicker_min`).val();
            var phone = $(`.app_phone`).val();
            // var time = $("input[type='radio']:checked").data('id');
            var time = $("input[type='radio']:checked").data('id');
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
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");

            if (date == "") {

                $(`.span-error-date`).text("{{ __('*Please choose date') }}");
                $(".close-search1").trigger({
                    type: "click"
                });
                // } else if (document.querySelectorAll('.app_time').length < 1) {
            } else if (document.querySelectorAll('input[type="radio"][name="time"]:checked').length < 1) {

                $(`.span-error-time`).text("{{ __('*Please choose time') }}");
                $(".close-search1").trigger({
                    type: "click"
                });
            } else if (name == "") {

                $(`.span-error-name`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {

                $(`.span-error-email`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {

                $(`.span-error-phone`).text("{{ __('*Please enter your phone no') }}");
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
                    },
                    success: function(data) {
                        if (data.flag == false) {
                            $(".close-search1").trigger({
                                type: "click"
                            });
                            show_toastr('Error', data.msg, 'error');

                        } else {
                            $(".close-search1").trigger({
                                type: "click"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
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
                    template: '<div class="alert theme-toaster theme-toaster-success alert-{0} alert-icon theme-toaster-danger  theme-toaster-success  alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
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
</body>

</html>
